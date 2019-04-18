<?php
/**
 * Theme Customizer functionality
 *
 * @package     Charmed Pro
 * @link        https://palamut.com/themes/palamut
 */
require_once PALA_THEME_DIR . '/inc/customizer/sanitization.php';
require_once PALA_THEME_DIR . '/inc/customizer/dynamic-css.php';
require_once PALA_THEME_DIR . '/inc/customizer/fonts-library.php';
/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize the Customizer object.
 */
function palamut_customize_register( $wp_customize ) {

	/**
	 * Customize.
	 */
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'blogname',
		array(
			'selector'        => '.site-title a',
			'settings'        => array( 'blogname' ),
			'render_callback' => 'palamut_customize_partial_blogname',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'blogdescription',
		array(
			'selector'        => '.site-description',
			'render_callback' => 'palamut_customize_partial_blogdescription',
		)
	);

	/**
	 * Remove unnecessary controls.
	 */
	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_control( 'background_color' );

	/**
	 * Add custom controls.
	 */
	require_once PALA_THEME_DIR . '/inc/customizer/controls/class-palamut-range-control.php';
	require_once PALA_THEME_DIR . '/inc/customizer/controls/class-palamut-toggle-control.php';
	if ( class_exists( 'Palamut_Range_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Range_Control' );
	}
	if ( class_exists( 'Palamut_Toggle_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Toggle_Control' );
	}

	/**
	 * Top-Level Customizer sections and panels.
	 */
	$wp_customize->add_panel(
		'palamut_theme_options',
		array(
			'title'    => esc_html__( 'Theme Options', 'palamut' ),
			'priority' => 30,
		)
	);

	/**
	 * Add the site logo max-width option to the Site Identity section.
	 */
	$wp_customize->add_setting(
		'custom_logo_max_width',
		array(
			'default'           => '50',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new Palamut_Range_Control(
			$wp_customize,
			'custom_logo_max_width',
			array(
				'default'     => '50',
				'type'        => 'palamut-range',
				'label'       => esc_html__( 'Logo Max Width', 'palamut' ),
				'description' => 'px',
				'section'     => 'title_tagline',
				'priority'    => 8,
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 300,
					'step' => 2,
				),
			)
		)
	);

	/**
	 * Theme Customizer Sections.
	 * For more information on Theme Customizer settings and default sections:
	 *
	 * @see https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
	 */

	$wp_customize->add_setting(
		'theme_background_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_background_color',
			array(
				'label'   => esc_html__( 'Background Color', 'palamut' ),
				'section' => 'colors',
			)
		)
	);

	// PRO: Add main accent color setting and control.
	$wp_customize->add_setting(
		'theme_accent_color',
		array(
			'default'           => '#61bfad',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_accent_color',
			array(
				'label'   => esc_html__( 'Accent Color', 'palamut' ),
				'section' => 'colors',
			)
		)
	);

	// PRO: Add main accent color setting and control.
	$wp_customize->add_setting(
		'header_a_color',
		array(
			'default'           => '#222222',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_a_color',
			array(
				'label'   => esc_html__( 'Header Link Color', 'palamut' ),
				'section' => 'colors',
			)
		)
	);

	// PRO: Add main accent color setting and control.
	$wp_customize->add_setting(
		'wt_color',
		array(
			'default'           => '#999999',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'wt_color',
			array(
				'label'   => esc_html__( 'Header Sub-Title Color', 'palamut' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'social_svg_color',
		array(
			'default'           => '#222222',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'social_svg_color',
			array(
				'label'   => esc_html__( 'Social Icon Color', 'palamut' ),
				'section' => 'colors',
			)
		)
	);

	// PRO: Add main accent color setting and control.
	$wp_customize->add_setting(
		'body_typography_color',
		array(
			'default'           => '#222222',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'body_typography_color',
			array(
				'label'   => esc_html__( 'Body Text Color', 'palamut' ),
				'section' => 'colors',
			)
		)
	);

	// PRO: Add main accent color setting and control.
	$wp_customize->add_setting(
		'header_typography_color',
		array(
			'default'           => '#222222',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_typography_color',
			array(
				'label'   => esc_html__( 'Headings Text Color', 'palamut' ),
				'section' => 'colors',
			)
		)
	);

	// PRO: Add main accent color setting and control.
	$wp_customize->add_setting(
		'footer_color',
		array(
			'default'           => '#999999',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_color',
			array(
				'label'   => esc_html__( 'Footer Text Color', 'palamut' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'css_filter',
		array(
			'default'           => 'none',
			'sanitize_callback' => '',
		)
	);

	$wp_customize->add_control(
		'css_filter',
		array(
			'type'        => 'select',
			'label'       => esc_html__( 'CSS3 Filter', 'palamut' ),
			'description' => esc_html__( 'Enable the CSS filtering effect on posts. Please note that this only works in modern browsers and does not function when using Blurring.', 'palamut' ),
			'section'     => 'colors',
			'choices'     => array(
				'none'      => esc_html__( 'None', 'palamut' ),
				'grayscale' => esc_html__( 'Black and White', 'palamut' ),
				'sepia'     => esc_html__( 'Sepia', 'palamut' ),
			),
		)
	);

	/**
	 * Add the portfolio section.
	 */
	$wp_customize->add_section(
		'palamut_pro_portfolio',
		array(
			'title' => esc_html__( 'Portfolio', 'palamut' ),
			'panel' => 'palamut_theme_options',
		)
	);

			$wp_customize->add_setting(
				'portfolio_loop_pages',
				array(
					'default'           => true,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'portfolio_loop_pages',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Page Portfolio Loop', 'palamut' ),
					'description' => esc_html__( 'Activate the portfolio loop on all standard WordPress pages, which contains a masonry grid of all posts.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			$wp_customize->add_setting(
				'portfolio_loop',
				array(
					'default'           => true,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'portfolio_loop',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Single Portfolio Loop', 'palamut' ),
					'description' => esc_html__( 'Activate the portfolio loop on all portfolio posts, which contains a masonry grid of all portfolios.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			$wp_customize->add_setting(
				'portfolio_sticky',
				array(
					'default'           => true,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'portfolio_sticky',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Portfolio Sticky Content', 'palamut' ),
					'description' => esc_html__( 'Enable the sticky content on the singular portfolio pages.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			$wp_customize->add_setting(
				'portfolio_social',
				array(
					'default'           => true,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'portfolio_social',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Portfolio Social', 'palamut' ),
					'description' => esc_html__( 'Activate the portfolio social sharing module and enable viewers to share your portfolio projects.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			// Add the CTA button text setting and control.
			$wp_customize->add_setting(
				'twitter_username',
				array(
					'default'           => '@palamut',
					'transport'         => 'postMessage',
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'twitter_username',
				array(
					'type'    => 'text',
					'label'   => esc_html__( 'Twitter Username', 'palamut' ),
					'section' => 'palamut_pro_portfolio',
				)
			);

			$wp_customize->add_setting(
				'portfolio_filtering',
				array(
					'default'           => true,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'portfolio_filtering',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Portfolio Filtering', 'palamut' ),
					'description' => esc_html__( 'Optional filtering tags on the portfolio & index pages.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			// Add the portfolio sorting selector setting and control.
			$wp_customize->add_setting(
				'portfolio_sorting',
				array(
					'default'           => false,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'portfolio_sorting',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Portfolio Sorting', 'palamut' ),
					'description' => esc_html__( 'Optional "Random", "Popularity" and "Date" sorting toggles on the portfolio & index pages.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			// Add the portfolio lightbox selector setting and control.
			$wp_customize->add_setting(
				'portfolio_lightbox',
				array(
					'default'           => false,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'portfolio_lightbox',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Photoswipe Lightbox', 'palamut' ),
					'description' => esc_html__( 'Add a JavaScript image gallery to single views for mobile and desktop viewports, with touch gestures, zooming and optimized asset delivery.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			// Add the portfolio caption style selector setting and control.
			$wp_customize->add_setting(
				'portfolio_caption-style',
				array(
					'default'           => false,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'portfolio_caption-style',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Large Captions', 'palamut' ),
					'description' => esc_html__( 'Enabled the large-scale gallery captions to display between your portfolio items.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			// Add the portfolio lightbox selector setting and control.
			$wp_customize->add_setting(
				'portfolio_white_play_icon',
				array(
					'default'           => true,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'portfolio_white_play_icon',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'White Lightbox Icon', 'palamut' ),
					'description' => esc_html__( 'Use the white play icon, instead of the default dark play button - for projects with lightbox embed URLs.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

			$wp_customize->add_setting(
				'portfolio_lightbox-colorscheme',
				array(
					'default'           => 'light',
					'sanitize_callback' => 'palamut_sanitize_select',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'portfolio_lightbox-colorscheme',
				array(
					'type'        => 'select',
					'label'       => esc_html__( 'Lightbox Color Scheme', 'palamut' ),
					'description' => esc_html__( 'Select either the light or dark color scheme for the portfolio lightbox feature.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
					'choices'     => array(
						'light' => esc_html__( 'Light', 'palamut' ),
						'dark'  => esc_html__( 'Dark', 'palamut' ),
					),
				)
			);

			// Add the portfolio post count selector setting and control.
			$wp_customize->add_setting(
				'portfolio_posts_count',
				array(
					'default'           => '',
					'sanitize_callback' => 'palamut_sanitize_number_intval',
				)
			);

			$wp_customize->add_control(
				'portfolio_posts_count',
				array(
					'type'        => 'number',
					'label'       => esc_html__( 'Portfolio Count', 'palamut' ),
					'description' => esc_html__( 'Set the number of posts to display on the portfolio template. Use "-1" to load them all.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio',
				)
			);

	/**
	 * Add the call to action section.
	 */
	$wp_customize->add_section(
		'palamut_pro_portfolio_cta',
		array(
			'title' => esc_html__( 'Call to Action', 'palamut' ),
			'panel' => 'palamut_theme_options',
		)
	);

			// Add the call to option on/off selector setting and control.
			$wp_customize->add_setting(
				'portfolio_cta',
				array(
					'default'           => true,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Enable Call to Action', 'palamut' ),
					'description' => esc_html__( 'Choose to activate the portfolio single view call to action, which adds opens up a contact lead-generation form when clicked.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the CTA button text setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_button_text',
				array(
					'default'           => esc_html__( 'Hire Me', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_button_text',
				array(
					'type'        => 'text',
					'label'       => esc_html__( 'Trigger Button', 'palamut' ),
					'description' => esc_html__( 'Enter a call to action text ("ex: Hire Me") you would like on the trigger button.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the form header setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_header',
				array(
					'default'           => esc_html__( 'Lets Talk', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_header',
				array(
					'type'        => 'text',
					'label'       => esc_html__( 'Form Header', 'palamut' ),
					'description' => esc_html__( 'Customize the form header text.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the first subject line setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_subject1',
				array(
					'default'           => esc_html__( 'Web Development', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_subject1',
				array(
					'type'        => 'text',
					'label'       => esc_html__( 'Form Subjects', 'palamut' ),
					'description' => esc_html__( 'Add multiple subject line options to your project query contact form.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the second subject line setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_subject2',
				array(
					'default'           => esc_html__( 'Web Design', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_subject2',
				array(
					'type'    => 'text',
					'section' => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the third subject line setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_subject3',
				array(
					'default'           => esc_html__( 'iOS App Design', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_subject3',
				array(
					'type'    => 'text',
					'section' => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the fourth subject line setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_subject4',
				array(
					'default'           => esc_html__( 'Branding', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_subject4',
				array(
					'type'    => 'text',
					'section' => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the fifth subject line setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_subject5',
				array(
					'default'           => esc_html__( 'Illustration', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_subject5',
				array(
					'type'    => 'text',
					'section' => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the contact email address selector setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_email',
				array(
					'default'           => '',
					'sanitize_callback' => 'is_email',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_email',
				array(
					'type'        => 'email',
					'label'       => esc_html__( 'Email Address', 'palamut' ),
					'description' => esc_html__( 'Enter the email address you would like the project form to send to.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio_cta',
				)
			);

			// Add the portfolio CTA button setting and control.
			$wp_customize->add_setting(
				'portfolio_cta_button',
				array(
					'default'           => esc_html__( 'Send Email', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'portfolio_cta_button',
				array(
					'type'        => 'text',
					'label'       => esc_html__( 'Form Send Button', 'palamut' ),
					'description' => esc_html__( 'Customize the form button text.', 'palamut' ),
					'section'     => 'palamut_pro_portfolio_cta',
				)
			);

	/**
	 * Add the contact section.
	 */
	$wp_customize->add_section(
		'palamut_theme_options_contact',
		array(
			'title' => esc_html__( 'Contact', 'palamut' ),
			'panel' => 'palamut_theme_options',
		)
	);

			// Add the contact email address selector setting and control.
			$wp_customize->add_setting(
				'contact_email',
				array(
					'default'           => '',
					'sanitize_callback' => 'is_email',
				)
			);

			$wp_customize->add_control(
				'contact_email',
				array(
					'type'        => 'email',
					'label'       => esc_html__( 'Email Address', 'palamut' ),
					'description' => esc_html__( 'Enter the email address you would like the contact form to send to.', 'palamut' ),
					'section'     => 'palamut_theme_options_contact',
				)
			);

			// Add the contact email address selector setting and control.
			$wp_customize->add_setting(
				'contact_button',
				array(
					'default'           => esc_html__( 'Send Email', 'palamut' ),
					'sanitize_callback' => 'palamut_sanitize_nohtml',
				)
			);

			$wp_customize->add_control(
				'contact_button',
				array(
					'type'        => 'text',
					'label'       => esc_html__( 'Contact Button', 'palamut' ),
					'description' => esc_html__( 'Enter the text of the contact form button.', 'palamut' ),
					'section'     => 'palamut_theme_options_contact',
				)
			);

	/**
	 * Add the footer section.
	 */
	$wp_customize->add_section(
		'palamut_theme_options_footer',
		array(
			'title' => esc_html__( 'Footer', 'palamut' ),
			'panel' => 'palamut_theme_options',
		)
	);

			// Bottom Bar Toggle
			$wp_customize->add_setting(
				'show_bottombar',
				array(
					'default'           => palamut_theme_defaults( 'show_bottombar' ),
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				new Palamut_Toggle_Control(
					$wp_customize,
					'show_bottombar',
					array(
						'type'        => 'palamut-toggle',
						'priority'    => 1,
						'style'       => 'flat',
						'label'       => esc_html__( 'Bottom Bar', 'palamut' ),
						'description' => 'Show or hide bottom bar.',
						'section'     => 'palamut_theme_options_footer',
					)
				)
			);

			$wp_customize->add_setting(
				'copyright_text',
				array(
					'default'           => palamut_theme_strings( 'copyright-text' ),
					'sanitize_callback' => 'palamut_sanitize_html',
				)
			);

			$wp_customize->add_control(
				'copyright_text',
				array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Footer Text', 'palamut' ),
					'description' => esc_html__( 'Add a custom copyright or colophon text to the site footer. The option must be selected below to display this.', 'palamut' ),
					'section'     => 'palamut_theme_options_footer',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'copyright_text',
				array(
					'settings'        => 'copyright_text',
					'selector'        => '.copyright',
					'render_callback' => 'palamut_customize_partial_copyright_text',
				)
			);

			$wp_customize->add_setting(
				'copyright_text_display',
				array(
					'default'           => true,
					'sanitize_callback' => 'palamut_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'copyright_text_display',
				array(
					'type'    => 'checkbox',
					'label'   => esc_html__( 'Display Footer Text', 'palamut' ),
					'section' => 'palamut_theme_options_footer',
				)
			);

		/**
		 * Add the typography section.
		 */
		$wp_customize->add_panel(
			'palamut_pro_typography',
			array(
				'title'       => esc_html__( 'Typography', 'palamut' ),
				'description' => esc_html__( 'Customize various typographic options throughout the theme with the settings within this panel.', 'palamut' ),
				'priority'    => 32,
			)
		);

		/**
		 * Add the $fonts variables for typography choices.
		 */
		$fonts = palamut_font_library();

		/**
		 * Add the body typography section.
		 */
		$wp_customize->add_section(
			'palamut_pro_typography_body',
			array(
				'title' => esc_html__( 'Body', 'palamut' ),
				'panel' => 'palamut_pro_typography',
			)
		);

			// Add the body font fanily setting and control.
			$wp_customize->add_setting(
				'body_font_family',
				array(
					'default' => 'Karla',
				)
			);

			$wp_customize->add_control(
				'body_font_family',
				array(
					'type'    => 'select',
					'label'   => esc_html__( 'Font Family', 'palamut' ),
					'section' => 'palamut_pro_typography_body',
					'choices' => $fonts,
				)
			);

			$wp_customize->add_setting(
				'body_font_size',
				array(
					'default'           => '15',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'body_font_size',
					array(
						'default'     => '15',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Font Size', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_body',
						'input_attrs' => array(
							'min'  => 10,
							'max'  => 100,
							'step' => 1,
						),
					)
				)
			);

			$wp_customize->add_setting(
				'body_line_height',
				array(
					'default'           => '26',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'body_line_height',
					array(
						'default'     => '26',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Line Height', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_body',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						),
					)
				)
			);

			$wp_customize->add_setting(
				'body_letter_spacing',
				array(
					'default'           => '0',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'body_letter_spacing',
					array(
						'default'     => '0',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Letter Spacing', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_body',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 10,
							'step' => 1,
						),
					)
				)
			);

			$wp_customize->add_setting(
				'body_word_spacing',
				array(
					'default'           => '0',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'body_word_spacing',
					array(
						'default'     => '0',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Word Spacing', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_body',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 20,
							'step' => 1,
						),
					)
				)
			);

			/**
			 * Add the page titles typography section.
			 */
			$wp_customize->add_section(
				'palamut_pro_typography_pagetitles',
				array(
					'title' => esc_html__( 'Page Title', 'palamut' ),
					'panel' => 'palamut_pro_typography',
				)
			);

			// Add the body font fanily setting and control.
			$wp_customize->add_setting(
				'pagetitle_font_family',
				array(
					'default' => 'Karla',
				)
			);

			$wp_customize->add_control(
				'pagetitle_font_family',
				array(
					'type'    => 'select',
					'label'   => esc_html__( 'Font Family', 'palamut' ),
					'section' => 'palamut_pro_typography_pagetitles',
					'choices' => $fonts,
				)
			);

			$wp_customize->add_setting(
				'pagetitle_font_size',
				array(
					'default'           => '26',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'pagetitle_font_size',
					array(
						'default'     => '26',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Font Size', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_pagetitles',
						'input_attrs' => array(
							'min'  => 10,
							'max'  => 100,
							'step' => 1,
						),
					)
				)
			);

			$wp_customize->add_setting(
				'pagetitle_line_height',
				array(
					'default'           => '26',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'pagetitle_line_height',
					array(
						'default'     => '26',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Line Height', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_pagetitles',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						),
					)
				)
			);

			$wp_customize->add_setting(
				'pagetitle_letter_spacing',
				array(
					'default'           => '0',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'pagetitle_letter_spacing',
					array(
						'default'     => '0',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Letter Spacing', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_pagetitles',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 10,
							'step' => 1,
						),
					)
				)
			);

			$wp_customize->add_setting(
				'pagetitle_word_spacing',
				array(
					'default'           => '0',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'pagetitle_word_spacing',
					array(
						'default'     => '0',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Word Spacing', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_pagetitles',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 20,
							'step' => 1,
						),
					)
				)
			);

			/**
			 * Add the page content section.
			 */
			$wp_customize->add_section(
				'palamut_pro_typography_pagecontent',
				array(
					'title' => esc_html__( 'Page Content', 'palamut' ),
					'panel' => 'palamut_pro_typography',
				)
			);

			$wp_customize->add_setting(
				'pagecontent_font_size',
				array(
					'default'           => '19',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'pagecontent_font_size',
					array(
						'default'     => '19',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Font Size', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_pagecontent',
						'input_attrs' => array(
							'min'  => 10,
							'max'  => 100,
							'step' => 1,
						),
					)
				)
			);

			$wp_customize->add_setting(
				'pagecontent_line_height',
				array(
					'default'           => '32',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'pagecontent_line_height',
					array(
						'default'     => '32',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Line Height', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_pagecontent',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						),
					)
				)
			);

			$wp_customize->add_setting(
				'pagecontent_word_spacing',
				array(
					'default'           => '0',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'pagecontent_word_spacing',
					array(
						'default'     => '0',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Word Spacing', 'palamut' ),
						'description' => 'px',
						'section'     => 'palamut_pro_typography_pagecontent',
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 20,
							'step' => 1,
						),
					)
				)
			);

			/**
			 * Add the site logo max-width option to the Site Identity section.
			 */
			$wp_customize->add_setting(
				'custom_logo_max_width',
				array(
					'default'           => '50',
					'transport'         => 'postMessage',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new Palamut_Range_Control(
					$wp_customize,
					'custom_logo_max_width',
					array(
						'default'     => '50',
						'type'        => 'palamut-range',
						'label'       => esc_html__( 'Logo Max Width', 'palamut' ),
						'description' => 'px',
						'section'     => 'title_tagline',
						'priority'    => 8,
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 300,
							'step' => 2,
						),
					)
				)
			);

	/**
	 * Set transports for the Customizer.
	 */
	$wp_customize->get_setting( 'custom_logo_max_width' )->transport     = 'postMessage';

	$wp_customize->get_setting( 'contact_button' )->transport            = 'postMessage';
	$wp_customize->get_setting( 'portfolio_cta_button_text' )->transport = 'postMessage';
	$wp_customize->get_setting( 'portfolio_cta_header' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'portfolio_cta_button' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'portfolio_sorting' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'portfolio_filtering' )->transport       = 'postMessage';
	$wp_customize->get_setting( 'contact_email' )->transport             = 'postMessage';
	$wp_customize->get_setting( 'portfolio_cta_email' )->transport       = 'postMessage';

	$wp_customize->get_setting( 'powered_by_wordpress' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'copyright_text_display' )->transport    = 'postMessage';
	$wp_customize->get_setting( 'copyright_text' )->transport            = 'postMessage';
	$wp_customize->get_setting( 'portfolio_white_play_icon' )->transport = 'postMessage';
}

add_action( 'customize_register', 'palamut_customize_register', 11 );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function palamut_customize_preview_js() {
	wp_enqueue_script( 'palamut-customize-preview-scripts', PALA_THEME_DIR_URL . '/inc/customizer/assets/js/customize-preview.js', array( 'customize-preview', 'jquery' ), '1.0', true );
}
add_action( 'customize_preview_init', 'palamut_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function palamut_customize_controls_js() {
	wp_enqueue_script( 'palamut-customize-controls', PALA_THEME_DIR_URL . '/inc/customizer/assets/js/customize-controls.js', array( 'customize-controls' ), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'palamut_customize_controls_js' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @see palamut_customize_register()
 *
 * @return void
 */
function palamut_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see palamut_customize_register()
 *
 * @return void
 */
function palamut_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see palamut_customize_register()
 */
function palamut_customize_partial_copyright_text() {
	return get_theme_mod( 'copyright_text' );
}

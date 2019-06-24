<?php
/**
 * Customizer > Sections > Footer
 *
 * Footer Widget area, colophon and bottom bar area customization fields.
 *
 * @link to be defined
 *
 * @package pdwname
 *
 * @subpackage Template Functions
 * @category Theme Framework
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pkg.author
 * @copyright pdwcopyright
 * @license pdwlicense
 */

// Register Section.
$wp_customize->add_section(
	'prefix_theme_options_footer',
	array(
		'title' => esc_html__( 'Footer', 'textdomain' ),
		'panel' => 'prefix_theme_options',
	)
);

// Bottom Bar Toggle.
$wp_customize->add_setting(
	'colophon_copyright',
	array(
		'default'           => prefix_theme_defaults( 'show_bottombar' ),
		'sanitize_callback' => 'prefix_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new Palamut_Toggle_Control(
		$wp_customize,
		'colophon_copyright',
		array(
			'type'        => 'palamut-toggle',
			'priority'    => 1,
			'style'       => 'flat',
			'label'       => esc_html__( 'Show Copyright Section', 'textdomain' ),
			'description' => 'Show or hide bottom bar.',
			'section'     => 'prefix_theme_options_footer',
		)
	)
);

$wp_customize->add_setting(
	'copyright_text',
	array(
		'default'           => prefix_theme_strings( 'copyright-text' ),
		'sanitize_callback' => 'prefix_sanitize_html',
	)
);

$wp_customize->add_control(
	'copyright_text',
	array(
		'type'        => 'textarea',
		'label'       => esc_html__( 'Footer Text', 'textdomain' ),
		'description' => esc_html__( 'Add a custom copyright or colophon text to the site footer. The option must be selected below to display this.', 'textdomain' ),
		'section'     => 'prefix_theme_options_footer',
	)
);

$wp_customize->selective_refresh->add_partial(
	'copyright_text',
	array(
		'settings'        => 'copyright_text',
		'selector'        => '.copyright',
		'render_callback' => 'prefix_customize_partial_copyright_text',
	)
);

$wp_customize->add_setting(
	'colophon_theme_info',
	array(
		'default'           => prefix_theme_defaults( 'show_theme_info' ),
		'sanitize_callback' => 'prefix_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new Palamut_Toggle_Control(
		$wp_customize,
		'colophon_theme_info',
		array(
			'type'        => 'palamut-toggle',
			'priority'    => 1,
			'style'       => 'flat',
			'label'       => esc_html__( 'Show Theme Info', 'textdomain' ),
			'description' => 'Show or hide theme info.',
			'section'     => 'prefix_theme_options_footer',
		)
	)
);


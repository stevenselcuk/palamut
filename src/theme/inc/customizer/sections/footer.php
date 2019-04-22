<?php
/**
 * Customizer > Sections > Footer
 *
 * { Document descriptions will be add. }
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
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */
 /**
  * Layout (Its onder)
  * @TODO : Renew its position.
  */
$wp_customize->add_section(
	'palamut_theme_options_footer',
	array(
		'title' => esc_html__( 'Footer', 'palamut' ),
		'panel' => 'palamut_theme_options',
	)
);

		 // Bottom Bar Toggle.
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

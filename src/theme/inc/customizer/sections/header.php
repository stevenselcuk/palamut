<?php
/**
 * Customizer > Sections > Header
 *
 * Header & Nav Area Customizations.
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
	'prefix_theme_options_header',
	array(
		'title' => esc_html__( 'Header', 'textdomain' ),
		'panel' => 'prefix_theme_options',
	)
);

// Logo Max. Height (Its under Site Identity).
$wp_customize->add_setting(
	'header_max_width',
	array(
		'default'           => '1100',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Palamut_Range_Control(
		$wp_customize,
		'header_max_width',
		array(
			'default'     => '1100',
			'type'        => 'palamut-range',
			'label'       => esc_html__( 'Header Width', 'textdomain' ),
			'description' => 'px',
			'section'     => 'prefix_theme_options_header',
			'priority'    => 1,
			'input_attrs' => array(
				'min'  => 600,
				'max'  => 2200,
				'step' => 50,
			),
		)
	)
);

// Header Background Color.
$wp_customize->add_setting(
	'header_bg_color',
	array(
		'default'           => '#ffffff',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'prefix_sanitize_rgba',
	)
);

$wp_customize->add_control(
	new Palamut_Alpha_Color_Control(
		$wp_customize,
		'header_bg_color',
		array(
			'label'   => esc_html__( 'Header Background Color', 'textdomain' ),
			'section' => 'prefix_theme_options_header',
		)
	)
);



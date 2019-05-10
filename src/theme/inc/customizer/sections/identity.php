<?php
/**
 * Customizer > Sections > Identity
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
 * @author pkg.author
 * @copyright pdwcopyright
 * @license pdwlicense
 */

// Logo Max. Height (Its under Site Identity).
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
			'label'       => esc_html__( 'Logo Max Width', 'textdomain' ),
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

// Site Name Font Size (Its under Site Identity).
$wp_customize->add_setting(
	'site_title_font_size',
	array(
		'default'           => '50',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Palamut_Range_Control(
		$wp_customize,
		'site_title_font_size',
		array(
			'default'     => '50',
			'type'        => 'palamut-range',
			'label'       => esc_html__( 'Site Title Font Size', 'textdomain' ),
			'description' => 'px',
			'section'     => 'title_tagline',
			'priority'    => 10,
			'input_attrs' => array(
				'min'  => 12,
				'max'  => 96,
				'step' => 1,
			),
		)
	)
);

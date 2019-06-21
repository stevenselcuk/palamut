<?php
/**
 * Customizer > Sections > Navigation
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

 /**
  * Layout (Its onder)
  *
  * @TODO : Renew its position.
  */
$wp_customize->add_section(
	'prefix_theme_options_navigation',
	array(
		'title' => esc_html__( 'Navigation', 'textdomain' ),
		'panel' => 'prefix_theme_options',
	)
);

// Logo Max. Height (Its under Site Identity).
$wp_customize->add_setting(
	'header_min_width',
	array(
		'default'           => '1100',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Palamut_Range_Control(
		$wp_customize,
		'header_min_width',
		array(
			'default'     => '1100',
			'type'        => 'palamut-range',
			'label'       => esc_html__( 'Header Width', 'textdomain' ),
			'description' => 'px',
			'section'     => 'prefix_theme_options_navigation',
			'priority'    => 1,
			'input_attrs' => array(
				'min'  => 600,
				'max'  => 2200,
				'step' => 50,
			),
		)
	)
);
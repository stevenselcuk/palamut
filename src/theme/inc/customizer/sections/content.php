<?php
/**
 * Customizer > Sections > Content
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
	'prefix_theme_options_content',
	array(
		'title' => esc_html__( 'Content', 'textdomain' ),
		'panel' => 'prefix_theme_options',
	)
);

// Header Background Color.
$wp_customize->add_setting(
	'content_bg_color',
	array(
		'default'           => '#ffffff',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'prefix_sanitize_rgba',
	)
);

$wp_customize->add_control(
	new Palamut_Alpha_Color_Control(
		$wp_customize,
		'content_bg_color',
		array(
			'label'   => esc_html__( 'Content Background Color', 'textdomain' ),
			'section' => 'prefix_theme_options_content',
		)
	)
);


// Feed pagination type.
$wp_customize->add_setting(
	'pagination_type',
	array(
		'default'           => prefix_theme_defaults( 'pagination_type' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'prefix_sanitize_select',
	)
);

$wp_customize->add_control(
	'pagination_type',
	array(
		'type'        => 'select',
		'label'       => esc_html__( 'Pagination Type', 'textdomain' ),
		'description' => '',
		'section'     => 'prefix_theme_options_content',
		'choices'     => array(
			'classic'   => esc_html__( 'Classic', 'textdomain' ),
			'paginated' => esc_html__( 'Paginated', 'textdomain' ),
		),
	)
);

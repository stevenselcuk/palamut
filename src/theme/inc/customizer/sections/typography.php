<?php
/**
 * Customizer > Sections > Typography
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

// Call Google Font List.
$fonts = palamut_font_library();

// Register Typography Panel.
$wp_customize->add_panel(
	'palamut_typography',
	array(
		'title'       => esc_html__( 'Typography', 'palamut' ),
		'description' => esc_html__( 'Customize various typographic options throughout the theme with the settings within this panel.', 'palamut' ),
		'priority'    => 32,
	)
);

// Register Heading Typography Section.
$wp_customize->add_section(
	'palamut_typography_pagetitles',
	array(
		'title'    => esc_html__( 'Heading', 'palamut' ),
		'panel'    => 'palamut_typography',
		'priority' => 1,
	)
);

// Register Body Typography Section.
$wp_customize->add_section(
	'palamut_typography_body',
	array(
		'title'    => esc_html__( 'Body', 'palamut' ),
		'panel'    => 'palamut_typography',
		'priority' => 2,
	)
);

// Register Content Typography Section.
$wp_customize->add_section(
	'palamut_typography_pagecontent',
	array(
		'title'    => esc_html__( 'Page Content', 'palamut' ),
		'panel'    => 'palamut_typography',
		'priority' => 3,
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
			'section' => 'palamut_typography_body',
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
				'section'     => 'palamut_typography_body',
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
				'section'     => 'palamut_typography_body',
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
				'section'     => 'palamut_typography_body',
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
				'section'     => 'palamut_typography_body',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 20,
					'step' => 1,
				),
			)
		)
	);



	 // Add the body font fanily setting and control.
	$wp_customize->add_setting(
		'heading_font_family',
		array(
			'default' => 'Karla',
		)
	);

	$wp_customize->add_control(
		'heading_font_family',
		array(
			'type'    => 'select',
			'label'   => esc_html__( 'Font Family', 'palamut' ),
			'section' => 'palamut_typography_pagetitles',
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
				'section'     => 'palamut_typography_pagetitles',
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
				'section'     => 'palamut_typography_pagetitles',
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
				'section'     => 'palamut_typography_pagetitles',
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
				'section'     => 'palamut_typography_pagetitles',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 20,
					'step' => 1,
				),
			)
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
				'section'     => 'palamut_typography_pagecontent',
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
				'section'     => 'palamut_typography_pagecontent',
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
				'section'     => 'palamut_typography_pagecontent',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 20,
					'step' => 1,
				),
			)
		)
	);

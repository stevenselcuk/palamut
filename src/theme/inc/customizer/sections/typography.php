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
 * @author pkg.author
 * @copyright pdwcopyright
 * @license pdwlicense
 */

// Call Google Font List.
$fonts = prefix_font_library();

// Register Typography Panel.
$wp_customize->add_panel(
	'prefix_typography',
	array(
		'title'       => esc_html__( 'Typography', 'textdomain' ),
		'description' => esc_html__( 'Customize various typographic options throughout the theme with the settings within this panel.', 'textdomain' ),
		'priority'    => 32,
	)
);


// Register Content Typography Section.
$wp_customize->add_section(
	'prefix_typography_navigation',
	array(
		'title'    => esc_html__( 'Header & Navigation', 'textdomain' ),
		'panel'    => 'prefix_typography',
		'priority' => 1,
	)
);

// Register Heading Typography Section.
$wp_customize->add_section(
	'prefix_typography_pagetitles',
	array(
		'title'    => esc_html__( 'Heading', 'textdomain' ),
		'panel'    => 'prefix_typography',
		'priority' => 2,
	)
);

// Register Body Typography Section.
$wp_customize->add_section(
	'prefix_typography_body',
	array(
		'title'    => esc_html__( 'Body', 'textdomain' ),
		'panel'    => 'prefix_typography',
		'priority' => 3,
	)
);

// Register Content Typography Section.
$wp_customize->add_section(
	'prefix_typography_pagecontent',
	array(
		'title'    => esc_html__( 'Page Content', 'textdomain' ),
		'panel'    => 'prefix_typography',
		'priority' => 4,
	)
);


// =======================================
// NAVIGATION TYPOGRAPHY
// =======================================
// Add the navigation  typography setting and controls.
$wp_customize->add_setting(
	'menu_item_font_family'
);

$wp_customize->add_control(
	new Palamut_Typography_Control(
		$wp_customize,
		'menu_item_font_family',
		array(
			'type'    => 'prefix-font-family',
			'label'   => esc_html__( 'Navigation Font Family', 'textdomain' ),
			'section' => 'prefix_typography_navigation',
			'default' => 'Default',
		)
	)
);

$wp_customize->add_setting(
	'menu_item_font_size',
	array(
		'default'           => '15',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Palamut_Range_Control(
		$wp_customize,
		'menu_item_font_size',
		array(
			'default'     => '15',
			'type'        => 'palamut-range',
			'label'       => esc_html__( 'Font Size', 'textdomain' ),
			'description' => 'px',
			'section'     => 'prefix_typography_navigation',
			'input_attrs' => array(
				'min'  => 8,
				'max'  => 64,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'menu_item_font_weight',
	array(
		'default'           => '400',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'prefix_sanitize_select',
	)
);

$wp_customize->add_control(
	'menu_item_font_weight',
	array(
		'type'        => 'select',
		'label'       => esc_html__( 'Font Weight', 'textdomain' ),
		'description' => '',
		'section'     => 'prefix_typography_navigation',
		'choices'     => array(
			'400' => esc_html__( 'Normal', 'textdomain' ),
			'800' => esc_html__( 'Bold', 'textdomain' ),
		),
	)
);

$wp_customize->add_setting(
	'menu_item_transform',
	array(
		'default'           => 'none',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'prefix_sanitize_select',
	)
);

$wp_customize->add_control(
	'menu_item_transform',
	array(
		'type'        => 'select',
		'label'       => esc_html__( 'Transform', 'textdomain' ),
		'description' => '',
		'section'     => 'prefix_typography_navigation',
		'choices'     => array(
			'none'      => esc_html__( 'Normal', 'textdomain' ),
			'lowercase' => esc_html__( 'Lowercase', 'textdomain' ),
			'uppercase' => esc_html__( 'Uppercase', 'textdomain' ),
		),
	)
);

$wp_customize->get_setting( 'menu_item_font_size' )->transport = 'postMessage';
$wp_customize->get_setting( 'menu_item_transform' )->transport = 'postMessage';



// =======================================
// BODY TYPOGRAPHY
// =======================================
// Add the body typography setting and controls.
$wp_customize->add_setting(
	'body_font_family_subset',
	array(
		'sanitize_callback' => 'prefix_sanitize_multiselect',
		'default'           => array( 'latin', 'latin-ext' ),
	)
);


	// Add the body font fanily setting and control.
	$wp_customize->add_setting(
		'body_font_family'
	);

	$wp_customize->add_control(
		new Palamut_Typography_Control(
			$wp_customize,
			'body_font_family',
			array(
				'type'    => 'prefix-font-family',
				'label'   => esc_html__( 'Body Font Family', 'textdomain' ),
				'section' => 'prefix_typography_body',
				'default' => 'Inherit',
			)
		)
	);



	// Add the body font fanily setting and control.
	$wp_customize->add_setting(
		'body_font_family_subset',
		array(
			'sanitize_callback' => 'prefix_sanitize_multiselect',
			'default'           => array( 'latin', 'latin-ext' ),
		)
	);

	$wp_customize->add_control(
		new Palamut_Multiple_Select_Control(
			$wp_customize,
			'body_font_family_subset',
			array(
				'type'         => 'prefix-multiple-select',
				'label'        => esc_html__( 'Body Font Family Subset', 'textdomain' ),
				'section'      => 'prefix_typography_body',
				'custom_class' => 'selectize',
				'choices'      => array(
					'latin'        => 'latin',
					'latin-ext'    => 'latin-ext',
					'cyrillic'     => 'cyrillic',
					'cyrillic-ext' => 'cyrillic-ext',
					'greek'        => 'greek',
					'greek-ext'    => 'greek-ext',
					'vietnamese'   => 'vietnamese',
				),
			)
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
				'label'       => esc_html__( 'Font Size', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_body',
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
				'label'       => esc_html__( 'Line Height', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_body',
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
				'label'       => esc_html__( 'Letter Spacing', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_body',
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
				'label'       => esc_html__( 'Word Spacing', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_body',
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
			'label'   => esc_html__( 'Font Family', 'textdomain' ),
			'section' => 'prefix_typography_pagetitles',
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
				'label'       => esc_html__( 'Font Size', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_pagetitles',
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
				'label'       => esc_html__( 'Line Height', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_pagetitles',
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
				'label'       => esc_html__( 'Letter Spacing', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_pagetitles',
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
				'label'       => esc_html__( 'Word Spacing', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_pagetitles',
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
				'label'       => esc_html__( 'Font Size', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_pagecontent',
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
				'label'       => esc_html__( 'Line Height', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_pagecontent',
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
				'label'       => esc_html__( 'Word Spacing', 'textdomain' ),
				'description' => 'px',
				'section'     => 'prefix_typography_pagecontent',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 20,
					'step' => 1,
				),
			)
		)
	);

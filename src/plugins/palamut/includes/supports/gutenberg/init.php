<?php
/**
 * Gutenberg Support for our theme
 *
 * Adds some blocks, editor styling and more...
 *
 * @link       https://hevalandsteven.com
 * @since      1.0.0
 *
 * @package    Palamut
 * @subpackage Supports
 */

/**
 * Load Gutenberg Blocks
 */
require_once PALAMUT_PATH . 'includes/supports/gutenberg/blocks/init.php';

/**
 * [palamut_gutenberg_settings description]
 *
 * @method palamut_gutenberg_settings
 *
 * @since
 *
 * @link
 */
function palamut_gutenberg_settings() {
	/*
	 * Enable support for responsive embedded content
	 * See: https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#responsive-embedded-content
	 */
	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'align-wide' );

//	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
// We don't need this option for this theme.
//	add_theme_support( 'dark-editor-style' );

	/**
		* Themes Color Schemes
		*/
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => esc_html__( 'White', 'palamut' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => esc_html__( 'Dark Black', 'palamut' ),
				'slug'  => 'dark-black',
				'color' => '#040402',
			),
			array(
				'name'  => esc_html__( 'Mine Shaft', 'palamut' ),
				'slug'  => 'mine-shaft',
				'color' => '#333333',
			),
			array(
				'name'  => esc_html__( 'Persian Blue', 'palamut' ),
				'slug'  => 'persian-blue',
				'color' => '#6200FF',
			),
			array(
				'name'  => esc_html__( 'Medium Spring Green', 'palamut' ),
				'slug'  => 'medium-spring-green',
				'color' => '#00F2A5',
			),
		)
	);
	/**
		* Font sizing options
		*
		* @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/#block-font-sizes
		*/
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => __( 'Small', 'palamut' ),
				'shortName' => __( 'S', 'palamut' ),
				'size'      => 16,
				'slug'      => 'small',
			),
			array(
				'name'      => __( 'Medium', 'palamut' ),
				'shortName' => __( 'M', 'palamut' ),
				'size'      => 19,
				'slug'      => 'regular',
			),
			array(
				'name'      => __( 'Large', 'palamut' ),
				'shortName' => __( 'L', 'palamut' ),
				'size'      => 24,
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Larger', 'palamut' ),
				'shortName' => __( 'XL', 'palamut' ),
				'size'      => 32,
				'slug'      => 'larger',
			),
		)
	);
}

add_action( 'after_setup_theme', 'palamut_gutenberg_settings' );



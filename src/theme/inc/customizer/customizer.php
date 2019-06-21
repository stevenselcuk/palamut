<?php
/**
 * Customizer
 *
 * Options and related functions.
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
 * Sub-Files
 */
require_once __PRE_THEME_DIR . '/inc/customizer/sanitization.php';
require_once __PRE_THEME_DIR . '/inc/customizer/dynamic-css.php';
require_once __PRE_THEME_DIR . '/inc/customizer/fonts-library.php';
/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize the Customizer object.
 */
function prefix_customize_register( $wp_customize ) {

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
			'render_callback' => 'prefix_customize_partial_blogname',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'blogdescription',
		array(
			'selector'        => '.site-description',
			'render_callback' => 'prefix_customize_partial_blogdescription',
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
	require_once get_theme_file_path( '/inc/customizer/controls/class-palamut-range-control.php' );
	require_once get_theme_file_path( '/inc/customizer/controls/class-palamut-toggle-control.php' );
	require_once get_theme_file_path( '/inc/customizer/controls/class-palamut-alpha-color-control.php' );
	require_once get_theme_file_path( '/inc/customizer/controls/class-palamut-typography-control.php' );
	require_once get_theme_file_path( '/inc/customizer/controls/class-palamut-multiple-select-control.php' );

	if ( class_exists( 'Palamut_Range_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Range_Control' );
	}

	if ( class_exists( 'Palamut_Toggle_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Toggle_Control' );
	}

	if ( class_exists( 'Palamut_Multiple_Select_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Multiple_Select_Control' );
	}

	// Get Sections & Options.
	require_once get_theme_file_path( '/inc/customizer/sections/identity.php' );
	require_once get_theme_file_path( '/inc/customizer/sections/typography.php' );
	require_once get_theme_file_path( '/inc/customizer/sections/header.php' );
	require_once get_theme_file_path( '/inc/customizer/sections/navigation.php' );
	require_once get_theme_file_path( '/inc/customizer/sections/content.php' );
	require_once get_theme_file_path( '/inc/customizer/sections/footer.php' );
	/**
	 * Top-Level Customizer sections and panels.
	 */
	$wp_customize->add_panel(
		'prefix_theme_options',
		array(
			'title'    => esc_html__( 'Theme Options', 'textdomain' ),
			'priority' => 30,
		)
	);

}

add_action( 'customize_register', 'prefix_customize_register', 11 );

/**
 * Customizer Preview.
 */
function prefix_customize_preview_js() {
	wp_enqueue_script( 'prefix-customize-preview', get_theme_file_uri( '/inc/customizer/assets/js/customize-preview.js' ), array( 'jquery', 'customize-preview' ), __PRE_THEME_VERSION, true );
	wp_enqueue_script( 'prefix-customize-live', get_theme_file_uri( '/inc/customizer/assets/js/customize-live.js' ), array( 'jquery', 'customize-preview', 'prefix-customize-preview' ), __PRE_THEME_VERSION, true );
}

add_action( 'customize_preview_init', 'prefix_customize_preview_js' );

/**
 * Customizer Events.
 */
function prefix_customize_events_enqueue_scripts() {
	wp_enqueue_script( 'prefix-customize-controls', get_theme_file_uri( '/inc/customizer/assets/js/customize-controls.js' ), false, '1.0', true );
	wp_enqueue_script( 'prefix-customize-events', get_theme_file_uri( '/inc/customizer/assets/js/customize-events.js' ), false, '1.0', true );
}

add_action( 'customize_controls_enqueue_scripts', 'prefix_customize_events_enqueue_scripts' );

/**
 * [prefix_customize_preview_style description]
 *
 * @method prefix_customize_preview_style
 */
function prefix_customize_preview_style() {
	wp_enqueue_style( 'prefix-customize-preview', get_theme_file_uri( '/inc/customizer/assets/css/customizer-styles.css' ), false, __PRE_THEME_VERSION );
}

if ( is_customize_preview() ) {
	add_action( 'admin_enqueue_scripts', 'prefix_customize_preview_style' );
}
/**
 * Render the site title for the selective refresh partial.
 *
 * @see prefix_customize_register()
 *
 * @return void
 */
function prefix_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see prefix_customize_register()
 *
 * @return void
 */
function prefix_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see prefix_customize_register()
 */
function prefix_customize_partial_copyright_text() {
	return get_theme_mod( 'copyright_text' );
}

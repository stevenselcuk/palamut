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
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

require_once PALA_THEME_DIR . '/inc/customizer/sanitization.php';
require_once PALA_THEME_DIR . '/inc/customizer/dynamic-css.php';
require_once PALA_THEME_DIR . '/inc/customizer/fonts-library.php';
/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize the Customizer object.
 */
function palamut_customize_register( $wp_customize ) {

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
			'render_callback' => 'palamut_customize_partial_blogname',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'blogdescription',
		array(
			'selector'        => '.site-description',
			'render_callback' => 'palamut_customize_partial_blogdescription',
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
	require_once PALA_THEME_DIR . '/inc/customizer/controls/class-palamut-range-control.php';
	require_once PALA_THEME_DIR . '/inc/customizer/controls/class-palamut-toggle-control.php';
	require_once PALA_THEME_DIR . '/inc/customizer/controls/class-palamut-alpha-color-control.php';

	if ( class_exists( 'Palamut_Range_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Range_Control' );
	}

	if ( class_exists( 'Palamut_Toggle_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Toggle_Control' );
	}

	require get_theme_file_path( '/inc/customizer/sections/identity.php' );
	require get_theme_file_path( '/inc/customizer/sections/typography.php' );
	require get_theme_file_path( '/inc/customizer/sections/footer.php' );
	/**
	 * Top-Level Customizer sections and panels.
	 */
	$wp_customize->add_panel(
		'palamut_theme_options',
		array(
			'title'    => esc_html__( 'Theme Options', 'palamut' ),
			'priority' => 30,
		)
	);
	
	$wp_customize->add_panel(
		'palamut_theme_options',
		array(
			'title'    => esc_html__( 'Theme Options', 'palamut' ),
			'priority' => 30,
		)
	);
	
	
	$wp_customize->add_section(
		'palamut_demo',
		array(
			'title'    => esc_html__( 'Demo', 'palamut' ),
			'panel'    => 'palamut_theme_options',
			'priority' => 1,
		)
	);
	// Logo Max. Height (Its under Site Identity).
	$wp_customize->add_setting(
		'color_1',
		array(
			'default'   => '#ff0099',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Palamut_Alpha_Color_Control(
			$wp_customize,
			'color_1',
			array(
				'type'    => 'alpha-color',
				'label'   => esc_html__( 'Logo Max Width', 'palamut' ),
				'section' => 'palamut_demo',
			)
		)
	);

	/**
	 * Set transports for the Customizer.
	 */
	$wp_customize->get_setting( 'custom_logo_max_width' )->transport = 'postMessage';
}

add_action( 'customize_register', 'palamut_customize_register', 11 );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function palamut_customize_preview_js() {
	wp_enqueue_script( 'palamut-customize-preview-scripts', PALA_THEME_DIR_URL . '/inc/customizer/assets/js/customize-preview.js', array( 'customize-preview', 'jquery' ), '1.0', true );
}
add_action( 'customize_preview_init', 'palamut_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function palamut_customize_controls_js() {
	wp_enqueue_script( 'palamut-customize-controls', PALA_THEME_DIR_URL . '/inc/customizer/assets/js/customize-controls.js', array( 'customize-controls' ), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'palamut_customize_controls_js' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @see palamut_customize_register()
 *
 * @return void
 */
function palamut_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see palamut_customize_register()
 *
 * @return void
 */
function palamut_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see palamut_customize_register()
 */
function palamut_customize_partial_copyright_text() {
	return get_theme_mod( 'copyright_text' );
}

<?php
/**
 * Palamut functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pkg.name
 *
 * @subpackage Template Functions
 * @category Theme Framework
 *
 * @version pkg.version
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

/**
 * Prevent switching to this theme from on old versions of WordPress.
 *
 * Switches to the default theme.
 */
function prefix_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'prefix_upgrade_notice' );
}
add_action( 'after_switch_theme', 'prefix_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * this theme on WordPress versions prior to 4.7.
 */
function prefix_upgrade_notice() {
	$message = sprintf( esc_html( 'This theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'textdomain' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', esc_html( $message ) );
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.7.
 */
function prefix_customize() {
	wp_die(
		sprintf( esc_html( 'This theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'textdomain' ), esc_html( $GLOBALS['wp_version'] ) ),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'prefix_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.7.
 */
function prefix_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html( 'This theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'textdomain' ), esc_html( $GLOBALS['wp_version'] ) ) );
	}
}
add_action( 'template_redirect', 'prefix_preview' );

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support WordPress versions prior to 5.2.0.
	 *
	 * @since 1.0.0
	 */
	function wp_body_open() {
			/**
			 * Triggered after the opening <body> tag.
			 *
			 * @since Twenty Nineteen 1.4
			 */
			do_action( 'wp_body_open' );
	}
}

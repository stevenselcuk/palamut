<?php
/**
 * Widgets
 *
 * Theme Spesific WordPress Widgets
 *
 * @link https://codex.wordpress.org/Widgets_API
 *
 * @package Palamut
 *
 * @subpackage Widgets
 * @category Theme Features
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

/**
 * [palamut_load_widgets description]
 *
 * @method palamut_load_widgets
 *
 * @since
 *
 * @link
 */
function palamut_load_widgets() {
	$widget_files = glob( dirname( __FILE__ ) . '/inc/*.php' );
	if ( ! empty( $widget_files ) ) {
		foreach ( $widget_files as $file ) {
			require_once $file;
		}
	}
}

add_action( 'plugins_loaded', 'palamut_load_widgets', 9999 );

/**
 * Include CSS & JS files for Widgets
 */
function palamut_widget_assets() {
	wp_enqueue_style( 'palamut-widgets', PALAMUT_PATH_URL . 'includes/widgets/assets/css/widgets.css', false, PALAMUT_VERSION );
	wp_enqueue_script( 'palamut-widgets', PALAMUT_PATH_URL . 'includes/widgets/assets/js/widgets.js', array( 'jquery' ), PALAMUT_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'palamut_widget_assets', 30 );

<?php
/**
 * Shortcode loader
 *
 * Adds shortcodes and necessary assets to theme
 *
 * @link https://codex.wordpress.org/Shortcode_API
 *
 * @package Palamut
 *
 * @subpackage Shortcodes
 * @category Theme Features
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shortcode Loader
 *
 * @method palamut_load_shortcodes
 *
 * @since 1.0.2
 */
function palamut_load_shortcodes() {
	$shortcode_files = glob( dirname( __FILE__ ) . '/inc/*.php' );
	if ( ! empty( $shortcode_files ) ) {
		foreach ( $shortcode_files as $file ) {
			require_once $file;
		}
	}
}

add_action( 'plugins_loaded', 'palamut_load_shortcodes', 9999 );

/**
 * Include CSS & JS files for Shortcodes
 */
function palamut_shortcode_assets() {
	wp_enqueue_style( 'palamut-shortcodes', PALAMUT_PATH_URL . 'includes/supports/classic-editor/shortcodes/assets/css/shortcodes.css', false, PALAMUT_VERSION );
	wp_enqueue_script( 'palamut-shortcodes', PALAMUT_PATH_URL . 'includes/supports/classic-editor/shortcodes/assets/js/shortcodes.js', array( 'jquery' ), PALAMUT_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'palamut_shortcode_assets', 20 );

if ( ! function_exists( 'palamut_shortcode_cleaning_exceprt' ) ) {
	/**
	 * Remove shortcodes from excerpt
	 *
	 * @method palamut_shortcode_cleaning_exceprt
	 *
	 * @since 1.0.2
	 *
	 * @param  string $content [description].
	 *
	 * @return string Cleaned $content string.
	 */
	function palamut_shortcode_cleaning_exceprt( $content ) {
		$content = strip_shortcodes( $content );
		return $content;
	}
}
add_filter( 'the_excerpt', 'palamut_shortcode_cleaning_exceprt' );

/**
 * Small fixes for shortcode env.
 *
 * @method palamut_shortcode_fix
 *
 * @since 1.0.2
 *
 * @param  string $content The Post Condent.
 *
 * @return string Replaced content.
 */
function palamut_shortcode_fix( $content ) {

	$array = array(
		'<p>['     => '[',
		'<span>['  => '[',
		'<div>['   => '[',
		']</p>'    => ']',
		']</span>' => ']',
		']</div>'  => ']',
		']<br />'  => ']',
		']&nbsp;'  => ']',
		'&nbsp;['  => '[',
	);
	return strtr( $content, $array );

}

add_filter( 'the_content', 'palamut_shortcode_fix' );


add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'the_excerpt', 'do_shortcode' );

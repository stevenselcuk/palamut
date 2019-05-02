<?php
/**
 * Layout Shortcode Set
 *
 * Flex Shortcodes for building layout.
 *
 * @package Palamut
 *
 * @subpackage Theme Features
 * @category Shortcode
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

if ( ! function_exists( 'row' ) ) {
	/**
	 * [row description]
	 *
	 * @method row
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $attr    [description].
	 * @param  [type] $content [description].
	 *
	 * @return [type]          [description]
	 */
	function row( $attr, $content = null ) {
		$output  = '<div class="flex">';
		$output .= do_shortcode( $content );
		$output .= '</div>' . "\n";

		return $output;
	}
	add_shortcode( 'row', 'row' );
}

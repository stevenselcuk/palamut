<?php
/**
 * Highlight
 *
 * Highlights a text w/ a bg color.
 *
 * @link to be defined
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

if ( ! function_exists( 'highlight' ) ) {
	/**
	 * [highlight description]
	 *
	 * @method highlight
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $atts    [description].
	 * @param  [type] $content [description].
	 *
	 * @return [type]             [description]
	 */
	function highlight( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'background' => '',
				'color'      => '',
			),
			$atts
		);

		return '<span class="hightlight" style="background:' . $atts['background'] . '; color:' . $atts['color'] . ';">' . do_shortcode( $content ) . '</span>';
	}
}
add_shortcode( 'highlight', 'highlight' );

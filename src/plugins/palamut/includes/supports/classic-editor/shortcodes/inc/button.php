<?php
/**
 * { Document title }
 *
 * { Document descriptions will be add. }
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

if ( ! function_exists( 'button' ) ) {

	/**
	 * Button Shortcode for PDW Themes
	 *
	 * @method button
	 *
	 * @since 1.0.0
	 *
	 * @link
	 *
	 * @param  [type] $atts    [description].
	 * @param  [type] $content [description].
	 *
	 * @return [type]          [description]
	 */
	function button( $atts, $content = null ) {
		$html = '';

		extract(
			shortcode_atts(
				array(
					'size'             => '',
					'border'           => '',
					'border_color'     => '',
					'shadow'           => '',
					'color'            => '',
					'background_color' => '',
					'font_size'        => '',
					'line_height'      => '',
					'font_style'       => '',
					'font_weight'      => '',
					'text'             => 'Button',
					'link'             => 'https://google.com/',
					'target'           => '_self',
				),
				$atts
			)
		);
		if ( '' === $target ) {
			$target = '_self';
		}
		$html .= '<a href="' . $link . '" target="' . $target . '" class="button ' . $size . ' ' . $border . ' ' . $shadow . '" style="';
		if ( '' !== $color ) {
			$html .= 'color: ' . $color . '; ';
		}
		if ( '' !== $background_color ) {
			$html .= 'background-color: ' . $background_color . '; ';
		}
		if ( '' !== $font_size ) {
			$html .= 'font-size: ' . $font_size . 'px; ';
		}
		if ( '' !== $line_height ) {
			$html .= 'line-height: ' . $line_height . 'px; ';
		}
		if ( '' !== $font_style ) {
			$html .= 'font-style: ' . $font_style . '; ';
		}
		if ( '' !== $font_weight ) {
			$html .= 'font-weight: ' . $font_weight . '; ';
		}
		if ( '' !== $border_color ) {
			$html .= 'border-color: ' . $border_color . '; ';
		}
		$html .= '">' . $text . '</a>';

		return $html;
	}
}
add_shortcode( 'button', 'button' );

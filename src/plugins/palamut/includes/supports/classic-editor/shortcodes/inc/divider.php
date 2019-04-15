<?php
/**
 * Divider
 *
 * Adds a gap with stylish SVG image.
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

if ( ! function_exists( 'divider' ) ) {
	/**
	 * [svg_divider description]
	 *
	 * @method svg_divider
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $attrs         [description].
	 * @param  [type] $content       [description].
	 */
	function divider( $attrs, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'type'        => 'divider',
					'fillcolor'   => '#ffffff',
					'strokecolor' => '#ffffff',
				),
				$attrs
			)
		);

		$out = "<svg class='pala-{$type}' xmlns='http://www.w3.org/2000/svg' version='1.1' width='100%' height='150' viewBox='0 0 400 260' preserveAspectRatio='none'>
			 <path style='fill:{$fillcolor}; stroke:{$strokecolor}' d='M0 0 Q 2.5 40 5 0 Q 7.5 40 10 0 Q 12.5 40 15 0 Q 17.5 40 20 0 Q 22.5 40 25 0 Q 27.5 40 30 0 Q 32.5 40 35 0
					  Q 37.5 40 40 0 Q 42.5 40 45 0 Q 47.5 40 50 0 Q 52.5 40 55 0 Q 57.5 40 60 0 Q 62.5 40 65 0 Q 67.5 40 70 0 Q 72.5 40 75 0 Q 77.5 40 80 0 Q 82.5 40 85 0
					  Q 87.5 40 90 0 Q 92.5 40 95 0 Q 97.5 40 100 0 Q 102.5 40 105 0 Q 107.5 40 110 0 Q 112.5 40 115 0 Q 117.5 40 120 0 Q 122.5 40 125 0 Q 127.5 40 130 0
					  Q 132.5 40 135 0 Q 137.5 40 140 0 Q 142.5 40 145 0 Q 147.5 40 150 0 Q 152.5 40 155 0 Q 157.5 40 160 0 Q 162.5 40 165 0 Q 167.5 40 170 0 Q 172.5 40 175 0
					  Q 177.5 40 180 0 Q 182.5 40 185 0 Q 187.5 40 190 0 Q 192.5 40 195 0 Q 197.5 40 200 0 Q 202.5 40 205 0 Q 207.5 40 210 0 Q 212.5 40 215 0 Q 217.5 40 220 0
					  Q 222.5 40 225 0 Q 227.5 40 230 0 Q 232.5 40 235 0 Q 237.5 40 240 0 Q 242.5 40 245 0 Q 247.5 40 250 0 Q 252.5 40 255 0 Q 257.5 40 260 0 Q 262.5 40 265 0
					  Q 267.5 40 270 0 Q 272.5 40 275 0 Q 277.5 40 280 0 Q 282.5 40 285 0 Q 287.5 40 290 0 Q 292.5 40 295 0 Q 297.5 40 300 0 Q 302.5 40 305 0 Q 307.5 40 310 0
					  Q 312.5 40 315 0 Q 317.5 40 320 0 Q 322.5 40 325 0 Q 327.5 40 330 0 Q 332.5 40 335 0 Q 337.5 40 340 0 Q 342.5 40 345 0 Q 347.5 40 350 0 Q 352.5 40 355 0
					  Q 357.5 40 360 0 Q 362.5 40 365 0 Q 367.5 40 370 0 Q 372.5 40 375 0 Q 377.5 40 380 0 Q 382.5 40 385 0 Q 387.5 40 390 0 Q 392.5 40 395 0 Q 397.5 40 400 0 Z'>
			 </path>
		 </svg>";
		return $out;
	}
}

add_shortcode( 'divider', 'divider' );

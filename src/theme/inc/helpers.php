<?php
/**
 * { Document title }
 *
 * { Document descriptions will be add. }
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

/**
 * [palamut_is_front description]
 *
 * @method palamut_is_front
 *
 * @since
 *
 * @link
 *
 * @return boolean
 */
function palamut_is_front() {
	if ( ( ! is_home() ) && ( is_front_page() ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Query whether WooCommerce is activated.
 */
function palamut_is_woocommerce_activated() {
	if ( class_exists( 'woocommerce' ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * [palamut_is_blog description]
 *
 * @method palamut_is_blog
 *
 * @since
 *
 * @link
 *
 * @return boolean
 */
function palamut_is_blog() {
	if ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) || ( is_search() ) ) {
		return true;
	} else {
		return false;
	}
}


if ( ! function_exists( 'palamut_allowed_html' ) ) {
	/**
	 * It gives you back allowed tags. Kinda shorthand for boring wp_kses thing.
	 *
	 * @method palamut_allowed_html()
	 *
	 * @since 1.0
	 *
	 * @return array Allowed html tags.
	 */
	function palamut_allowed_html() {
		$allowed_tags = array(
			'a'          => array(
				'class'  => array(),
				'href'   => array(),
				'rel'    => array(),
				'title'  => array(),
				'target' => array(),
			),
			'abbr'       => array(
				'title' => array(),
			),
			'iframe'     => array(
				'src' => array(),
			),
			'b'          => array(),
			'br'         => array(),
			'blockquote' => array(
				'cite' => array(),
			),
			'cite'       => array(
				'title' => array(),
			),
			'code'       => array(),
			'del'        => array(
				'datetime' => array(),
				'title'    => array(),
			),
			'dd'         => array(),
			'div'        => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'dl'         => array(),
			'dt'         => array(),
			'em'         => array(),
			'h1'         => array(),
			'h2'         => array(),
			'h3'         => array(),
			'h4'         => array(),
			'h5'         => array(),
			'h6'         => array(),
			'i'          => array(
				'class' => array(),
			),
			'img'        => array(
				'alt'    => array(),
				'class'  => array(),
				'height' => array(),
				'src'    => array(),
				'width'  => array(),
			),
			'li'         => array(
				'class' => array(),
			),
			'ol'         => array(
				'class' => array(),
			),
			'p'          => array(
				'class' => array(),
			),
			'q'          => array(
				'cite'  => array(),
				'title' => array(),
			),
			'span'       => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'strike'     => array(),
			'strong'     => array(),
			'ul'         => array(
				'class' => array(),
			),
		);

		return $allowed_tags;
	}
}


/**
 * [palamut_svg_allowed_html description]
 *
 * @method palamut_svg_allowed_html
 *
 * @since
 *
 * @link
 *
 * @return [type]
 */
function palamut_clean_svg() {
	return apply_filters(
		'palamut_svg_allowed_html',
		array(
			'svg' => array(
				'class'       => array(),
				'aria-hidden' => array(),
				'role'        => array(),
			),
			'use' => array(
				'xlink:href' => array(),
			),
		)
	);

}

/**
 * [palamut_gimme description]
 *
 * @method palamut_gimme
 *
 * @since
 *
 * @link
 *
 * @param  [type] $name desc.
 * @param  [type] $default_value desc.
 *
 * @return [type]
 */
function palamut_gimme( $name = null, $default_value = null ) {

	if ( null === $name ) {
		return $default_value ? $default_value : null;
	}

	$value = null;

	if ( null === $value || 'default' === $value ) {
			$value = get_theme_mod( $name );
	}
	/**
	 * What if there is no BestMan? Ugly theme? Nope.
	 *
	 * Try theme palamuttheme_defaults
	 *
	 * @see palamuttheme_defaults
	 */
	if ( null === $value ) {
		$value = palamut_theme_defaults( $name );
	}
		/**
		* Still no luck? let's look user given value.
		*
		* @var $value
		* @var $default_value
		*/
	if ( null === $value && null !== $default_value ) {
		$value = $default_value;
	}
	return $value;
}


/**
 * [palamut_icons description]
 *
 * @method palamut_icons
 *
 * @since
 *
 * @link
 *
 * @see classes/class-palamut-icon-bucket.php
 *
 * @return [type]
 */
function palamut_icons() {
	return Palamut_Icon_Bucket::instance();
}

/**
 * Convert HEX to RGB.
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 * HEX code, empty array otherwise.
 */
function palamut_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}


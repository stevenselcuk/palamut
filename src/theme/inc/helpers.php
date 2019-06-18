<?php
/**
 * Document_title
 *
 * Document_desc
 *
 * @link N/A
 *
 * @package pkg.name
 *
 * @subpackage Theme Functions
 * @category Functions
 *
 * @version pkg.license
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

/**
 * [prefix_is_front description]
 *
 * @method prefix_is_front
 *
 * @since 1.0
 *
 * @return boolean
 */
function prefix_is_front() {
	if ( ( ! is_home() ) && ( is_front_page() ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Query whether WooCommerce is activated.
 */
function prefix_is_woocommerce_activated() {
	if ( class_exists( 'woocommerce' ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * [prefix_is_blog description]
 *
 * @method prefix_is_blog
 *
 * @since 1.0
 *
 * @return boolean
 */
function prefix_is_blog() {
	if ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) || ( is_search() ) ) {
		return true;
	} else {
		return false;
	}
}


if ( ! function_exists( 'prefix_allowed_html' ) ) {
	/**
	 * It gives you back allowed tags. Kinda shorthand for boring wp_kses thing.
	 *
	 * @method prefix_allowed_html()
	 *
	 * @since 1.0
	 *
	 * @return array Allowed html tags.
	 */
	function prefix_allowed_html() {
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
 * [prefix_svg_allowed_html description]
 *
 * @method prefix_svg_allowed_html
 *
 * @since 1.0
 *
 * @return [type]
 */
function prefix_clean_svg() {
	return apply_filters(
		'prefix_svg_allowed_html',
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
 * [prefix_gimme description]
 *
 * @method prefix_gimme
 *
 * @since 1.0
 *
 * @param  [type] $name desc.
 * @param  [type] $default_value desc.
 *
 * @return [type]
 */
function prefix_gimme( $name = null, $default_value = null ) {

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
		$value = prefix_theme_defaults( $name );
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
 * [prefix_icons description]
 *
 * @method prefix_icons
 *
 * @since 1.0
 *
 * @see classes/class-palamut-icon-bucket.php
 *
 * @return [type]
 */
function prefix_icons() {
	return Palamut_Icon_Bucket::instance();
}

/**
 * Convert HEX to RGB.
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 * HEX code, empty array otherwise.
 */
function prefix_hex2rgb( $color ) {
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

/**
 * [get_google_fonts description]
 *
 * @method get_google_fonts
 *
 * @return [type]
 */
function prefix_get_google_fonts() {

	if ( empty( $this->$google_fonts ) ) {

		$google_fonts_file = apply_filters( 'prefix_google_fonts_json_file', __PRE_THEME_DIR . 'assets/fonts/google-fonts.json' );

		if ( ! file_exists( __PRE_THEME_DIR . 'assets/fonts/google-fonts.json' ) ) {
			return array();
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$file_contants     = $wp_filesystem->get_contents( $google_fonts_file );
		$google_fonts_json = json_decode( $file_contants, 1 );

		foreach ( $google_fonts_json as $key => $font ) {
			$name = key( $font );
			foreach ( $font[ $name ] as $font_key => $single_font ) {

				if ( 'variants' === $font_key ) {

					foreach ( $single_font as $variant_key => $variant ) {

						if ( 'regular' == $variant ) {
							$font[ $name ][ $font_key ][ $variant_key ] = '400';
						}
					}
				}

				$this->$google_fonts[ $name ] = array_values( $font[ $name ] );
			}
		}
	}

	return apply_filters( 'prefix_google_fonts', $this->$google_fonts );
}

/*

 */
function prefix_menu_fallback() {
	return 'Add menu';
}

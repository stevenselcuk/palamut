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
 * [palamut_enqueue_fonts description]
 *
 * @method palamut_enqueue_fonts
 *
 * @since
 *
 * @link
 *
 * @see
 *
 * @return [type]
 */
function palamut_enqueue_fonts() {
	$default = array(
		'default',
		'Default',
		'arial',
		'Arial',
		'courier',
		'Courier',
		'verdana',
		'Verdana',
		'trebuchet',
		'Trebuchet',
		'georgia',
		'Georgia',
		'times',
		'Times',
		'tahoma',
		'Tahoma',
		'helvetica',
		'Helvetica',
	);

	$fonts = array();

	$body_font_family   = get_theme_mod( 'body_font_family' );
	$header_font_family = get_theme_mod( 'header_font_family' );

	if ( $body_font_family ) {
			$fonts[] = $body_font_family;
	}

	if ( $header_font_family ) {
		$fonts[] = $header_font_family;
	}

	$fonts = array_unique( $fonts );

	foreach ( $fonts as $font ) {
		if ( ! in_array( $font, $default, true ) ) {
			palamut_enqueue_google_fonts( $font );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'palamut_enqueue_fonts' );

/**
 * [palamut_enqueue_google_fonts description]
 *
 * @method palamut_enqueue_google_fonts
 *
 * @since
 *
 * @link
 *
 * @see
 *
 * @param  [type] $font
 *
 * @return [type]
 */
function palamut_enqueue_google_fonts( $font ) {
	$font = explode( ',', $font );
	$font = $font[0];

	// CUSTOM CHECKS FOR CERTAIN FONTS.
	if ( 'Open Sans' === $font ) {
		$font = 'Open Sans:400,600';
	} else {
		$font = $font . ':400,500,700';
	}

	// FRIENDLY MOD.
	$font = str_replace( ' ', '+', $font );

	// CSS ENQUEUE.
	wp_enqueue_style( 'palamut-google-' . $font, 'https://fonts.googleapis.com/css?family=' . $font, false, '1.0', 'all' );
}

/**
 * [palamut_customizer_css description]
 *
 * @method palamut_customizer_css
 *
 * @since
 *
 * @link
 *
 * @see
 *
 * @return [type]
 */
function palamut_customizer_css() {

	$background_color        = get_theme_mod( 'theme_background_color', '#ffffff' );
	$theme_accent_color      = get_theme_mod( 'theme_accent_color', '#61bfad' );
	$body_typography_color   = get_theme_mod( 'body_typography_color', '#222222' );
	$social_svg_color        = get_theme_mod( 'social_svg_color', '#222222' );
	$header_typography_color = get_theme_mod( 'header_typography_color', '#222222' );
	$header_a_color          = get_theme_mod( 'header_a_color', '#222222' );
	$footer_color            = get_theme_mod( 'footer_color', '#999999' );
	$widget_title_color      = get_theme_mod( 'wt_color', '#999999' );

	$body_font_family    = get_theme_mod( 'body_font_family', 'Karla' );
	$body_font_size      = get_theme_mod( 'body_font_size', '15' );
	$body_line_height    = get_theme_mod( 'body_line_height', '26' );
	$body_letter_spacing = get_theme_mod( 'body_letter_spacing', '0' );
	$body_word_spacing   = get_theme_mod( 'body_word_spacing', '0' );

	$pagetitle_font_family    = get_theme_mod( 'pagetitle_font_family', 'Karla' );
	$pagetitle_font_size      = get_theme_mod( 'pagetitle_font_size', '26' );
	$pagetitle_line_height    = get_theme_mod( 'pagetitle_line_height', '26' );
	$pagetitle_letter_spacing = get_theme_mod( 'pagetitle_letter_spacing', '0' );
	$pagetitle_word_spacing   = get_theme_mod( 'pagetitle_word_spacing', '0' );

	$pagecontent_font_size    = get_theme_mod( 'pagecontent_font_size', '19' );
	$pagecontent_line_height  = get_theme_mod( 'pagecontent_line_height', '32' );
	$pagecontent_word_spacing = get_theme_mod( 'pagecontent_word_spacing', '0' );

	$site_logo_width = get_theme_mod( 'custom_logo_max_width', '50' );

	// RGB.
	$theme_accent_color_rgb = palamut_hex2rgb( $theme_accent_color );
	// If the rgba values are empty return early.
	if ( empty( $theme_accent_color_rgb ) ) {
		return;
	}
	$progress_border = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.4)', $theme_accent_color_rgb );

	$css =
	'
	:root {
		--site-logo-height: ' . $site_logo_width . 'px!important;
		--body-text-fontfamily: ' . $body_font_family . '!important;
		--body-text-fontsize: ' . $body_font_size . 'px!important;
	}
	';

	$css_filter_style = get_theme_mod( 'css_filter' );
	if ( '' !== $css_filter_style ) {
		switch ( $css_filter_style ) {
			case 'none':
				break;
			case 'grayscale':
				echo ' . brick-fullwidth .brick { filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); filter:gray; -webkit-filter:grayscale(100%);-moz-filter: grayscale(100%);-o-filter: grayscale(100%);}';
				break;
			case 'sepia':
				echo ' . brick-fullwidth .brick { -webkit-filter: sepia(50%); }';
				break;
			case 'saturation':
				echo ' . brick-fullwidth .brick { -webkit-filter: saturate(150%); }';
				break;
		}
	}

	/**
	 * Combine the values from above and minifiy them.
	 */
	$css_minified = $css;

	$css_minified = preg_replace( '#/\*.*?\*/#s', '', $css_minified );
	$css_minified = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css_minified );
	$css_minified = preg_replace( '/\s\s+(.*)/', '$1', $css_minified );

	wp_add_inline_style( 'palamut-style', wp_strip_all_tags( $css ) );

}

add_action( 'wp_enqueue_scripts', 'palamut_customizer_css' );

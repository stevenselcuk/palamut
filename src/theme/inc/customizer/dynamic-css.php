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
 * [palamut_customizer_css description]
 *
 * @method palamut_customizer_css
 *
 * @since
 *
 * @link
 *
 * @return $css It's our user defined CSS vars. and other values.
 */
function palamut_customizer_css() {

	$body_font_family    = get_theme_mod( 'body_font_family', 'Karla' );
	$body_font_size      = get_theme_mod( 'body_font_size', '15' );
	$body_line_height    = get_theme_mod( 'body_line_height', '26' );
	$body_letter_spacing = get_theme_mod( 'body_letter_spacing', '0' );
	$body_word_spacing   = get_theme_mod( 'body_word_spacing', '0' );

	$heading_font_family = get_theme_mod( 'heading_font_family' );

	$site_logo_width = get_theme_mod( 'custom_logo_max_width', '50' );

	$css =
	'
 	:root {
 		--site-logo-height: ' . $site_logo_width . 'px!important;
 		--body-text-fontfamily: ' . $body_font_family . '!important;
 		--body-text-fontsize: ' . $body_font_size . 'px!important;
 		--heading-fontfamily:' . $heading_font_family . '!important;
 	}
 	';

	/**
	 * Combine the values from above and minifiy them.
	 */
	$css_minified = $css;

	$css_minified = preg_replace( '#/\*.*?\*/#s', '', $css_minified );
	$css_minified = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css_minified );
	$css_minified = preg_replace( '/\s\s+(.*)/', '$1', $css_minified );

	return $css;

}
/**
 * [palamut_enqueue_google_fonts description]
 *
 * @method palamut_enqueue_google_fonts
 *
 * @since
 *
 * @link
 *
 * @return [type]
 */
function palamut_google_fonts() {
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

	$body_font_family    = get_theme_mod( 'body_font_family' );
	$heading_font_family = get_theme_mod( 'heading_font_family' );

	if ( $body_font_family && ! in_array( $body_font_family, $default, true ) ) {
		$fonts[] = $body_font_family . ':400,500,700';
	}

	if ( $heading_font_family && $heading_font_family !== $body_font_family && ! in_array( $heading_font_family, $default, true ) ) {
		$fonts[] = $heading_font_family . ':400,500,700';
	}

	$query_args = array(
		'family' => rawurlencode( implode( '|', $fonts ) ),
		'subset' => rawurlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

/**
 * [palamut_enqueue_google_fonts description]
 *
 * @method palamut_enqueue_google_fonts
 *
 * @since
 *
 * @link
 */
function palamut_enqueue_google_fonts() {
	wp_enqueue_style( 'palamut-google-fonts', palamut_google_fonts(), false, '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'palamut_enqueue_google_fonts' );

add_action( 'enqueue_block_editor_assets', 'palamut_enqueue_google_fonts', 11 );

/**
 * [palamut_classic_editor_google_fonts description]
 *
 * @method palamut_classic_editor_google_fonts
 *
 * @since
 *
 * @link
 *
 * @return [type]
 */
function palamut_classic_editor_google_fonts() {
	if ( class_exists( 'Classic_Editor' ) || version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
		add_editor_style( palamut_google_fonts() );
	}
}

add_action( 'after_setup_theme', 'palamut_classic_editor_google_fonts', 99 );

/**
 * Add preconnect for Google Fonts.
 *
 * @param  array  $urls           URLs to print for resource hints.
 * @param  string $relation_type  The relation type the URLs are printed.
 * @return array  $urls           URLs to print for resource hints.
 */
function palamut_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'palamut-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'palamut_resource_hints', 10, 2 );



/**
 * [palamut_enqueue_dynamic_css description]
 *
 * @method palamut_enqueue_dynamic_css
 *
 * @since
 *
 * @link
 */
function palamut_dynamic_styles() {
	wp_add_inline_style( 'palamut-style', palamut_customizer_css() );
}

add_action( 'wp_enqueue_scripts', 'palamut_dynamic_styles' );


/**
 * [palamut_editor_customizer_styles description]
 *
 * @method palamut_editor_customizer_styles
 *
 * @since
 *
 * @link
 */
function palamut_gutenberg_dynamic_styles() {
	wp_add_inline_style( 'gutenberg-editor-style', palamut_customizer_css() );
}

add_action( 'enqueue_block_editor_assets', 'palamut_gutenberg_dynamic_styles' );


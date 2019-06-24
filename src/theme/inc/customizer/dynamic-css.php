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
 * @version pkg.version
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

/**
 * [prefix_customizer_css description]
 *
 * @method prefix_customizer_css
 *
 * @since
 *
 * @link
 *
 * @return $css It's our user defined CSS vars. and other values.
 */
function prefix_customizer_css() {
	// Body Typography.
	$body_font_family    = get_theme_mod( 'body_font_family', prefix_theme_defaults( 'body_font_family' ) );
	$heading_font_family = get_theme_mod( 'heading_font_family', prefix_theme_defaults( 'heading_font_family' ) );
	// Menu Typography.
	$menu_item_font_family = get_theme_mod( 'menu_item_font_family', prefix_theme_defaults( 'menu_item_font_family' ) );
	$menu_item_font_size   = get_theme_mod( 'menu_item_font_size', '14' );
	$menu_item_font_weight = get_theme_mod( 'menu_item_font_weight', 'normal' );
	$menu_item_transform   = get_theme_mod( 'menu_item_transform', 'none' );
	// Site Identity.
	$site_logo_width     = get_theme_mod( 'custom_logo_max_width', prefix_theme_defaults( 'custom_logo_max_width' ) );
	$site_title_fontsize = get_theme_mod( 'site_title_font_size', prefix_theme_defaults( 'site_title_font_size' ) );
	$site_desc_fontsize  = get_theme_mod( 'site_desc_font_size', prefix_theme_defaults( 'site_desc_font_size' ) );
	// Layout.
	$header_max_width = get_theme_mod( 'header_max_width', prefix_theme_defaults( 'header_max_width' ) );

	// Colors.
	$header_bg_color     = get_theme_mod( 'header_bg_color', prefix_theme_defaults( 'header_bg_color' ) );
	$content_bg_color    = get_theme_mod( 'content_bg_color', prefix_theme_defaults( 'content_bg_color' ) );
	$body_text_color     = get_theme_mod( 'body_text_color', prefix_theme_defaults( 'body_text_color' ) );
	$body_text_link_color     = get_theme_mod( 'body_text_link_color', prefix_theme_defaults( 'body_text_link_color' ) );
	$body_text_link_color_hover    = get_theme_mod( 'body_text_link_color_hover', prefix_theme_defaults( 'body_text_link_color_hover' ) );
	$body_text_link_color_visited     = get_theme_mod( 'body_text_link_color_visited', prefix_theme_defaults( 'body_text_link_color_visited' ) );
	$heading_text_color  = get_theme_mod( 'heading_text_color', prefix_theme_defaults( 'heading_text_color' ) );

	// CSS render.
	$css =
	'
 	:root {
	
 		--site-logo-width:     ' . $site_logo_width . 'px;
		--site-title-fontsize: ' . $site_title_fontsize . 'px;
		--site-desc-fontsize: ' . $site_desc_fontsize . 'px;
		
		--header-max-width: ' . $header_max_width . 'px;

 		--body-text-fontfamily: ' . $body_font_family . ';
 		--body-text-fontsize:   ' . $body_font_size . 'px;
 		--heading-fontfamily:   ' . $heading_font_family . ';

		--menu-item-fontfamily:' . $menu_item_font_family . ';
		--menu-item-fontsize:  ' . $menu_item_font_size . 'px;
		--menu-item-fontweight:  ' . $menu_item_font_weight . ';
		--menu-item-transform:  ' . $menu_item_transform . ';
		
		--header-bg-color:  ' . $header_bg_color . ';
		--content-bg-color:  ' . $content_bg_color . ';
		
		--body-text-color:  ' . $body_text_color . ';
		--heading-color: ' . $heading_text_color . ';
		
		--link-color: ' . $body_text_link_color . ';
		--link-color__hover: ' . $body_text_link_color_hover . ';
		--link-color__visited: ' . $body_text_link_color_visited . ';


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
 * [prefix_enqueue_google_fonts description]
 *
 * @method prefix_enqueue_google_fonts
 *
 * @since
 *
 * @link
 *
 * @return [type]
 */
function prefix_google_fonts() {
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

	$body_font_family         = get_theme_mod( 'body_font_family', 'Open Sans' );
	$body_font_family_subsets = get_theme_mod( 'body_font_family_subset', array( 'latin', 'latin-ext' ) );
	$heading_font_family      = get_theme_mod( 'heading_font_family', 'Merriweather' );
	$menu_item_font_family    = get_theme_mod( 'menu_item_font_family', 'inherit' );

	$body_font_family    = trim( $body_font_family );
	$heading_font_family = trim( $heading_font_family );

	$subsets = '';
	if ( ! empty( $body_font_family_subsets ) ) {
		$font_subsets = array();
		foreach ( $body_font_family_subsets as $get_subset ) {
			$font_subsets[] = $get_subset;
		}
		$subsets .= implode( ',', $font_subsets );
	}

	// Register Bodu Font.
	if ( $body_font_family && ! in_array( $body_font_family, $default, true ) ) {
		$fonts[] = $body_font_family . ':400,500,700';
	}

	// Register Heading Font.
	if ( $heading_font_family && $heading_font_family !== $body_font_family && ! in_array( $heading_font_family, $default, true ) ) {
		$fonts[] = $heading_font_family . ':400,500,700';
	}

	// Register Menu Item Font.
	if ( $menu_item_font_family && $menu_item_font_family !== $body_font_family && $menu_item_font_family !== $heading_font_family && ! in_array( $menu_item_font_family, $default, true ) ) {
		$fonts[] = $menu_item_font_family . ':400,500,700';
	}

	$query_args = array(
		'family' => rawurlencode( implode( '|', $fonts ) ),
	);

	if ( ! empty( $subsets ) ) {
		$query_args['subset'] = rawurlencode( $subsets );
	}

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

/**
 * [prefix_enqueue_google_fonts description]
 *
 * @method prefix_enqueue_google_fonts
 *
 * @since
 *
 * @link
 */
function prefix_enqueue_google_fonts() {
	wp_enqueue_style( 'prefix-google-fonts', prefix_google_fonts(), false, null, 'all' );
}
add_action( 'wp_enqueue_scripts', 'prefix_enqueue_google_fonts' );

add_action( 'enqueue_block_editor_assets', 'prefix_enqueue_google_fonts', 11 );

/**
 * [prefix_classic_editor_google_fonts description]
 *
 * @method prefix_classic_editor_google_fonts
 *
 * @since
 *
 * @link
 *
 * @return [type]
 */
function prefix_classic_editor_google_fonts() {
	if ( class_exists( 'Classic_Editor' ) || version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
		add_editor_style( prefix_google_fonts() );
	}
}

add_action( 'after_setup_theme', 'prefix_classic_editor_google_fonts', 99 );

/**
 * Add preconnect for Google Fonts.
 *
 * @param  array  $urls           URLs to print for resource hints.
 * @param  string $relation_type  The relation type the URLs are printed.
 * @return array  $urls           URLs to print for resource hints.
 */
function prefix_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'prefix-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'prefix_resource_hints', 10, 2 );



/**
 * [prefix_enqueue_dynamic_css description]
 *
 * @method prefix_enqueue_dynamic_css
 *
 * @since
 *
 * @link
 */
function prefix_dynamic_styles() {
	wp_add_inline_style( 'prefix-style', prefix_customizer_css() );
}

add_action( 'wp_enqueue_scripts', 'prefix_dynamic_styles' );


/**
 * [prefix_editor_customizer_styles description]
 *
 * @method prefix_editor_customizer_styles
 *
 * @since
 *
 * @link
 */
function prefix_gutenberg_dynamic_styles() {
	wp_add_inline_style( 'gutenberg-editor-style', prefix_customizer_css() );
}

add_action( 'enqueue_block_editor_assets', 'prefix_gutenberg_dynamic_styles' );


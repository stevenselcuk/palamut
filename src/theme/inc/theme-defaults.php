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
 * @author pkg.author
 * @copyright pdwcopyright
 * @license pdwlicense
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Definitions & Globals
 */

if ( ! defined( '__PRE_THEME_DIR' ) ) :
	define( '__PRE_THEME_DIR', get_template_directory() );
endif;
if ( ! defined( '__PRE_THEME_DIR_URL' ) ) :
	define( '__PRE_THEME_DIR_URL', get_template_directory_uri() );
endif;

if ( ! defined( '__PRE_THEME_NAME' ) ) :
	define( '__PRE_THEME_NAME', wp_get_theme()->get( 'Name' ) );
endif;

if ( ! defined( '__PRE_THEME_VERSION' ) ) :
	define( '__PRE_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
endif;

if ( ! defined( 'PORTFOLIO_SUPPORT' ) ) :
	define( 'PORTFOLIO_SUPPORT', 'true' );
endif;

/**
 * [prefix_theme_defaults description]
 *
 * @method prefix_theme_defaults
 *
 * @since 1.0
 *
 * @param  string $name The Default that we want!.
 *
 * @return string Value of default.
 */
function prefix_theme_defaults( $name ) {
	static $defaults;
	if ( ! $defaults ) {
		$defaults = apply_filters(
			'prefix_theme_defaults',
			array(
				// Fonts.
				'heading_font_family'          => 'Karla',
				'body_font_family'             => 'Open Sans',
				'menu_item_font_family'        => 'Open Sans',
				// Colors.
				'heading_text_color'           => '#000000',
				'header_bg_color'              => '#ffffff',
				'content_bg_color'             => '#ffffff',
				'body_text_color'              => '#000000',
				'body_text_link_color'         => '#000000',
				'body_text_link_color_hover'   => '#000000',
				'body_text_link_color_visited' => '#000000',
				// Identity.
				'custom_logo_max_width'        => 64,
				'site_title_font_size'         => 32,
				'site_desc_font_size'          => 12,
				// Layout.
				'header_max_width'             => 1100,
				'content_max_width'            => 1100,
				// Options.
				'show_sidebar'                 => false,
				'prefix_site_info'             => true,
				'show_theme_info'              => true,
				'pagination_type'              => 'paginated',
			)
		);
	}
	return isset( $defaults[ $name ] ) ? $defaults[ $name ] : null;
}

/**
 * [prefix_theme_strings description]
 *
 * @method prefix_theme_strings
 *
 * @since 1.0
 *
 * @param  string $name Default string.
 *
 * @return [type]
 */
function prefix_theme_strings( $name ) {
	static $strings;
	if ( ! $strings ) {
		$strings = apply_filters(
			'prefix_theme_strings',
			array(
				// Identity.
				'no_result_found_title'   => _x( 'Nothing Found', 'Search result page warning title', 'textdomain' ),
				'no_result_found_desc'    => _x( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'Search result page warning text', 'textdomain' ),
				'search_form_title'       => _x( 'Search for:', 'Search form placeholder text.', 'textdomain' ),
				'search_form_placeholder' => _x( 'Search', 'Search form placeholder text.', 'textdomain' ),
				// Translators: 1. Year 2. Site Name.
				'colophon_copyright_text' => sprintf( 'Copyright &copy; %1$s %2$s. All rights reserved.', date_i18n( __( 'Y', 'textdomain' ) ), get_bloginfo( 'name' ) ),
			)
		);
	}
	return isset( $strings[ $name ] ) ? $strings[ $name ] : null;
}

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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Definitions & Globals
 */

if ( ! defined( 'PALA_THEME_DIR' ) ) :
	define( 'PALA_THEME_DIR', get_template_directory() );
endif;
if ( ! defined( 'PALA_THEME_DIR_URL' ) ) :
	define( 'PALA_THEME_DIR_URL', get_template_directory_uri() );
endif;

if ( ! defined( 'PALA_THEME_NAME' ) ) :
	define( 'PALA_THEME_NAME', wp_get_theme()->get( 'Name' ) );
endif;

if ( ! defined( 'PALA_THEME_VERSION' ) ) :
	define( 'PALA_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
endif;

/**
 * [palamut_theme_defaults description]
 *
 * @method palamut_theme_defaults
 *
 * @since 1.0
 *
 * @param  string $name The Default that we want!.
 *
 * @return string Value of default.
 */
function palamut_theme_defaults( $name ) {
	static $defaults;
	if ( ! $defaults ) {
		$defaults = apply_filters(
			'palamut_theme_defaults',
			array(
				// Identity.
				'site_title'                   => false,
				'show_bottombar'               => true,
				'custom_logo_max_width'        => 50,
				'custom_logo_mobile_max_width' => 50,
				'custom_logo_border_radius'    => true,
				// Layout.
				'pagination_type'              => 'paginated',
				'alt_heading_color'            => '#656e79',
				'text_color'                   => '#2a2a2a',
				'header_icon_color'            => '#2a2a2a',
				'nav_color'                    => '#656e79',
				'mobile_nav_color'             => '#2a2a2a',
				'footer_bg_color'              => '#f1f1f1',
				'footer_text_color'            => '#2a2a2a',
				// Options.
				'header_search'                => true,
				'night_mode'                   => true,
				'categories'                   => true,
			)
		);
	}
	return isset( $defaults[ $name ] ) ? $defaults[ $name ] : null;
}

/**
 * [palamut_theme_strings description]
 *
 * @method palamut_theme_strings
 *
 * @since 1.0
 *
 * @param  string $name Default string.
 *
 * @return [type]
 */
function palamut_theme_strings( $name ) {
	static $strings;
	if ( ! $strings ) {
		$strings = apply_filters(
			'palamut_theme_strings',
			array(
				// Identity.
				'no_result_found_title'   => _x( 'Nothing Found', 'Search result page warning title', 'palamut' ),
				'no_result_found_desc'    => _x( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'Search result page warning text', 'palamut' ),
				'search_form_title'       => _x( 'Search for:', 'Search form placeholder text.', 'palamut' ),
				'search_form_placeholder' => _x( 'Search', 'Search form placeholder text.', 'palamut' ),
				// Translators: 1. Year 2. Site Name.
				'copyright-text'          => sprintf( 'Copyright &copy; %1$s %2$s. All rights reserved.', date_i18n( __( 'Y', 'palamut' ) ), get_bloginfo( 'name' ) ),
			)
		);
	}
	return isset( $strings[ $name ] ) ? $strings[ $name ] : null;
}

<?php
/**
 * Palamut functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pkg.name
 *
 * @subpackage Template Functions
 * @category Theme Framework
 *
 * @version pkg.version
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

// Return before it is too late...
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_parent_theme_file_path( '/inc/back-compat.php' );
}
// Add Defaults, Theme Costants, Default Strings and Theme Variables.
require get_theme_file_path( '/inc/theme-defaults.php' );

// Helper Functions.
require get_theme_file_path( '/inc/helpers.php' );

// Setting up Palamut Theme, Supports etc.
require get_theme_file_path( '/inc/theme-setup.php' );

// Enqueque JS, CSS, fonts etc. for both of side.
require get_theme_file_path( '/inc/theme-sources.php' );

// Functions which enhance the theme by hooking into WordPress.
require get_theme_file_path( '/inc/theme-functions.php' );

// Theme specific changes about WP.
require get_theme_file_path( '/inc/theme-filters.php' );

require get_theme_file_path( '/inc/theme-components.php' );

// Theme specific changes about WP.
require get_theme_file_path( '/inc/theme-hooks.php' );

// Custom theme tags for this theme.
require get_theme_file_path( '/inc/theme-tags.php' );

// Init Customizer.
require get_theme_file_path( '/inc/customizer/customizer.php' );

// Palamut Theme Classes.
/**
 * Call Icon Bucket
 */
require get_theme_file_path( '/inc/classes/class-palamut-icon-bucket.php' );

/**
 * Call Navwalker
 */
require get_theme_file_path( '/inc/classes/class-palamut-mobile-navwalker.php' );

/**
 * Implement the Custom Header feature.
 */
require get_theme_file_path( '/inc/supports/custom-header.php' );

require get_theme_file_path( '/inc/supports/portfolio-support.php' );
require get_theme_file_path( '/inc/extras/documentation/init.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_theme_file_path( '/inc/supports/jetpack.php' );
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_theme_file_path( '/inc/supports/woocommerce.php' );
}

/**
 * Recommended Plugins.
 */
require get_theme_file_path( '/inc/plugins/recommended-plugins.php' );

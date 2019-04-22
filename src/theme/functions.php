<?php
/**
 * Palamut functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package palamut
 */

// Add Defaults, Theme Costants, Default Strings and Theme Variables.
require get_template_directory() . '/inc/theme-defaults.php';

// Helper Functions.
require PALA_THEME_DIR . '/inc/helpers.php';

// Setting up Palamut Theme, Supports etc.
require PALA_THEME_DIR . '/inc/theme-setup.php';

// Enqueque JS, CSS, fonts etc. for both of side.
require PALA_THEME_DIR . '/inc/theme-sources.php';

// Functions which enhance the theme by hooking into WordPress.
require PALA_THEME_DIR . '/inc/theme-functions.php';

// Theme specific changes about WP.
require PALA_THEME_DIR . '/inc/theme-filters.php';

// Theme specific changes about WP.
require PALA_THEME_DIR . '/inc/theme-hooks.php';

// Custom theme tags for this theme.
require PALA_THEME_DIR . '/inc/theme-tags.php';

// Init Customizer.
require PALA_THEME_DIR . '/inc/customizer/customizer.php';


// Palamut Theme Classes.
/**
 * Call Icon Bucket
 */
require PALA_THEME_DIR . '/inc/classes/class-palamut-icon-bucket.php';

/**
 * Call Navwalker
 */
require PALA_THEME_DIR . '/inc/classes/class-palamut-mobile-navwalker.php';

/**
 * Implement the Custom Header feature.
 */
require PALA_THEME_DIR . '/inc/custom-header.php';

/**
 * Recommended Plugins.
 */
require PALA_THEME_DIR . '/inc/plugins/recommended-plugins.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require PALA_THEME_DIR . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require PALA_THEME_DIR . '/inc/woocommerce.php';
}

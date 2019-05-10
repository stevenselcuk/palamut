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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue for front-end.
 *
 * @method prefix_scripts
 *
 * @since 1.0
 */
function prefix_scripts() {

	wp_enqueue_style( 'prefix-style', get_stylesheet_uri(), __PRE_THEME_VERSION, true );

	if ( 'default' === get_theme_mod( 'body_font_family' ) || 'default' === get_theme_mod( 'heading_font_family' ) || 'default' === get_theme_mod( 'navigation_font_family' ) ) {
		wp_enqueue_style( 'prefix-font', get_theme_file_uri( '/assets/fonts/circularstd/circular-std.css' ), false, __PRE_THEME_VERSION );
	}

	wp_enqueue_style( 'fontawesome', get_theme_file_uri( '/assets/fonts/fontawesome/css/all.min.css' ), array(), '5.8.1' );

	wp_enqueue_script( 'headroom', get_theme_file_uri( '/assets/js/headroom.min.js' ), array(), '1.0', true );

	wp_enqueue_script( 'headroom-jquery', get_theme_file_uri( '/assets/js/jquery.headroom.min.js' ), array( 'jquery', 'headroom' ), '1.0', true );

	wp_enqueue_script( 'infinitescroll', get_theme_file_uri( '/assets/js/infinitescroll.js' ), array(), '1.0', true );

	wp_enqueue_script( 'pace', get_theme_file_uri( '/assets/js/pace.min.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'aos', get_theme_file_uri( '/assets/js/aos.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'prefix-app', get_theme_file_uri( '/assets/js/app.js' ), array( 'jquery' ), __PRE_THEME_VERSION, true );
/**
	if ( prefix_is_woocommerce_activated() ) {

		// Custom WooCommerce scripts.
		wp_enqueue_script( 'prefix-woocommerce', get_theme_file_uri( '/assets/js/ava-woocommerce.js' ), array( 'jquery' ), __PRE_THEME_VERSION, true );
		wp_enqueue_script( 'prefix-woocommerce-add-to-cart', get_theme_file_uri( '/assets/js/woocommerce-add-to-cart.js' ), array( 'jquery' ), __PRE_THEME_VERSION, true );
		wp_enqueue_script( 'prefix-woocommerce-cart', get_theme_file_uri( '/assets/js/woocommerce-cart.js' ), array( 'jquery' ), __PRE_THEME_VERSION, true );
		wp_enqueue_script( 'prefix-woocommerce-shop', get_theme_file_uri( '/assets/js/woocommerce-shop.js' ), array( 'jquery' ), __PRE_THEME_VERSION, true );
		$local_js_vars = array(
			'prefix_ajaxUrl'           => admin_url( 'admin-ajax.php' ),
			'prefix_shopAjaxAddToCart' => ( get_option( 'woocommerce_enable_ajax_add_to_cart' ) === 'yes' && get_option( 'woocommerce_cart_redirect_after_add' ) === 'no' ) ? 1 : 0,
		);
		wp_localize_script( 'prefix-woocommerce', 'prefix_wp_vars', $local_js_vars );
		wp_localize_script( 'prefix-woocommerce-shop', 'prefix_wp_vars', $local_js_vars );
	}
**/
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'prefix_scripts' );

/**
 * Enqueue theme styles related to Gutenberg.
 *
 * @method prefix_gutenberg_styles
 *
 * @since 1.0
 */
function prefix_gutenberg_styles() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'prefix-gutenberg-editor-style', __PRE_THEME_DIR_URL . '/assets/css/gutenberg-editor-style.css', false, __PRE_THEME_VERSION );
}

add_action( 'enqueue_block_editor_assets', 'prefix_gutenberg_styles', 10 );

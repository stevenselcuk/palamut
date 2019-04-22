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
 * Enqueue for front-end.
 *
 * @method palamut_scripts
 *
 * @since 1.0
 */
function palamut_scripts() {

	wp_enqueue_style( 'palamut-style', get_stylesheet_uri(), '1.0', true );

	wp_enqueue_style( 'palamut-font', PALA_THEME_DIR_URL . '/assets/fonts/circularstd/circular-std.css', false, '1.0' );

	wp_enqueue_style( 'fontawesome', PALA_THEME_DIR_URL . '/assets/fonts/fontawesome/css/all.min.css', array(), '5.8.1' );

	wp_enqueue_script( 'headroom', PALA_THEME_DIR_URL . '/assets/js/headroom.min.js', array(), '1.0', true );

	wp_enqueue_script( 'headroom-jquery', PALA_THEME_DIR_URL . '/assets/js/jquery.headroom.min.js', array( 'jquery', 'headroom' ), '1.0', true );
	
		wp_enqueue_script( 'infinitescroll', PALA_THEME_DIR_URL . '/assets/js/infinitescroll.js', array(), '1.0', true );

	wp_enqueue_script( 'pace', PALA_THEME_DIR_URL . '/assets/js/pace.min.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'aos', PALA_THEME_DIR_URL . '/assets/js/aos.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'palamut-app', PALA_THEME_DIR_URL . '/assets/js/app.js', array( 'jquery' ), '1.0', true );


	
	

	if ( palamut_is_woocommerce_activated() ) {

		// Custom WooCommerce scripts.
		wp_enqueue_script( 'ava-woocommerce', PALA_THEME_DIR_URL . '/assets/js/ava-woocommerce.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'ava-woocommerce-add-to-cart', PALA_THEME_DIR_URL . '/assets/js/woocommerce-add-to-cart.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'ava-woocommerce-cart', PALA_THEME_DIR_URL . '/assets/js/woocommerce-cart.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'ava-woocommerce-shop', PALA_THEME_DIR_URL . '/assets/js/woocommerce-shop.js', array( 'jquery' ), '1.0', true );
		$local_js_vars = array(
			'ava_ajaxUrl'           => admin_url( 'admin-ajax.php' ),
			'ava_shopAjaxAddToCart' => ( get_option( 'woocommerce_enable_ajax_add_to_cart' ) === 'yes' && get_option( 'woocommerce_cart_redirect_after_add' ) === 'no' ) ? 1 : 0,
		);
		wp_localize_script( 'ava-woocommerce', 'ava_wp_vars', $local_js_vars );
		wp_localize_script( 'ava-woocommerce-shop', 'ava_wp_vars', $local_js_vars );
	}


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'palamut_scripts' );

/**
 * Enqueue theme styles related to Gutenberg.
 *
 * @method palamut_gutenberg_styles
 *
 * @since
 *
 * @link
 */
function palamut_gutenberg_styles() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'gutenberg-editor-style', PALA_THEME_DIR_URL . '/assets/css/gutenberg-editor-style.css', false, '1.0' );
}

add_action( 'enqueue_block_editor_assets', 'palamut_gutenberg_styles', 10 );

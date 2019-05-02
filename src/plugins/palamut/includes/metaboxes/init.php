<?php
/**
 * Metaboxes & Custom Fields
 *
 * Adds Theme spesific custom fields and old skool metabox function
 *
 * @uses CMB2 (Located at /vendors folder)
 *
 * @link https://github.com/CMB2/CMB2/wiki
 *
 * @package Palamut
 *
 * @subpackage Metaboxes & Custom Fields
 * @category Theme Features
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

/**
 * [palamut_init_cmb2 description]
 *
 * @method palamut_init_cmb2
 *
 * @since
 *
 * @link
 */
function palamut_init_cmb2() {
	if ( ! class_exists( 'CMB2_Bootstrap_260' ) && file_exists( PALAMUT_PATH . 'includes/vendors/cmb2/init.php' ) ) {
		require_once PALAMUT_PATH . 'includes/vendors/cmb2/init.php';
	}
}
add_action( 'init', 'palamut_init_cmb2' );

/**
 * [palamut_load_metaboxes description]
 *
 * @method palamut_load_metaboxes
 *
 * @since
 *
 * @link
 */
function palamut_load_metaboxes() {
	$metabox_files = glob( dirname( __FILE__ ) . '/inc/*.php' );
	if ( ! empty( $metabox_files ) ) {
		foreach ( $metabox_files as $file ) {
			require_once $file;
		}
	}
}

add_action( 'plugins_loaded', 'palamut_load_metaboxes', 9999 );

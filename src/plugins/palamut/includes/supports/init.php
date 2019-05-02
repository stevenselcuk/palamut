<?php
/**
 * 3rd party or native components that which are supported by our theme
 *
 * It depends on theme
 *
 * @link       https://hevalandsteven.com
 * @since      1.0.0
 *
 * @package    Palamut
 * @subpackage Palamut/includes/supports
 */

/**
 * Add full support for Gutenberg.
 */
if ( function_exists( 'register_block_type' ) || ! class_exists( 'Classic_Editor' ) ) :
	require_once plugin_dir_path( __FILE__ ) . 'gutenberg/init.php';
endif;
/**
 * Add full support for Gutenberg.
 */
require_once plugin_dir_path( __FILE__ ) . 'elementor/init.php';

if ( ! function_exists( 'register_block_type' ) || class_exists( 'Classic_Editor' ) ) :

	/**
	* Add full support for Classic Editor
	*/
	require_once plugin_dir_path( __FILE__ ) . 'classic-editor/init.php';
endif;

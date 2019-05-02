<?php
/**
 * Oldskool (pre-Gutenberg area) Custom Metaboxes for pages
 *
 * It may be theme spesific
 *
 * @package Palamut
 *
 * @subpackage Metaboxes
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
 * Add custom metaboxes to posts
 *
 * @method palamut_register_post_metabox
 *
 * @since 1.0.1
 *
 * @link https://github.com/CMB2/CMB2/wiki/Examples
 */
function palamut_register_page_metabox() {
	$prefix  = 'palamut_page_';
	$context = ( function_exists( 'register_block_type' ) ) ? 'side' : 'normal';
	// But wait... What if there is Classic Editor or old WP... Let's do it bigger.
	if ( class_exists( 'Classic_Editor' ) || version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
		$context = 'normal';
	}

	$cmb_page = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Page Settings', 'palamut' ),
			'object_types' => array( 'page' ),
			'context'      => $context,
		)
	);

	$cmb_page->add_field(
		array(
			'name' => esc_html__( 'Hide title', 'palamut' ),
			'desc' => esc_html__( 'You can hide page title (optional)', 'palamut' ),
			'id'   => $prefix . 'hide_page_title',
			'type' => 'checkbox',
		)
	);
}

add_action( 'cmb2_admin_init', 'palamut_register_page_metabox' );

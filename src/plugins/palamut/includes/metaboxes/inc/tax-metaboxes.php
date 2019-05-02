<?php
/**
 * Custom Metabox for Category and Tags
 *
 * Gives functionality for displaying category icon & header bg image
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
 * Add custom metaboxes to taxonomy pages
 *
 * @method palamut_user_profile_metabox_init
 *
 * @since 1.0.1
 *
 * @link https://github.com/CMB2/CMB2/wiki/Examples
 */
function palamut_taxonomy_metabox() {
	$prefix = 'pdw_term_';

	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box(
		array(
			'id'               => $prefix . 'edit',
			'title'            => esc_html__( 'Category Settings', 'palamut' ),
			'object_types'     => array( 'term' ),
			'taxonomies'       => array( 'category', 'post_tag' ),
			'new_term_section' => true,
		)
	);

	$cmb_term->add_field(
		array(
			'name' => esc_html__( 'Category Icon', 'palamut' ),
			'desc' => esc_html__( 'Choose an icon for this category', 'palamut' ),
			'id'   => $prefix . 'icon',
			'type' => 'file',
		)
	);

	$cmb_term->add_field(
		array(
			'name' => esc_html__( 'Category Header Image', 'palamut' ),
			'desc' => esc_html__( 'Choose a header bg image for this category', 'palamut' ),
			'id'   => $prefix . 'bg_image',
			'type' => 'file',
		)
	);

}

add_action( 'cmb2_admin_init', 'palamut_taxonomy_metabox' );

<?php
/**
 * Post Type: Portfolio
 *
 * @link       https://hevalandsteven.com
 * @since      1.0.0
 *
 * @package    Palamut
 * @subpackage Palamut/includes/post-types/portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'palamut_portfolio_post_type' ) ) {
	/**
	 * [palamut_portfolio_post_type description]
	 *
	 * @method palamut_portfolio_post_type
	 *
	 * @since
	 *
	 * @link
	 */
	function palamut_portfolio_post_type() {
		$slug = esc_attr( 'portfolio' );
		$tax  = esc_attr( 'Categories' );

		$labels = array(
			'name'               => esc_html__( 'Portfolio', 'palamut' ),
			'singular_name'      => esc_html__( 'Portfolio item', 'palamut' ),
			'add_new'            => esc_html__( 'Add New', 'palamut' ),
			'add_new_item'       => esc_html__( 'Add New Portfolio item', 'palamut' ),
			'edit_item'          => esc_html__( 'Edit Portfolio item', 'palamut' ),
			'new_item'           => esc_html__( 'New Portfolio item', 'palamut' ),
			'view_item'          => esc_html__( 'View Portfolio item', 'palamut' ),
			'search_items'       => esc_html__( 'Search Portfolio items', 'palamut' ),
			'not_found'          => esc_html__( 'No portfolio items found', 'palamut' ),
			'not_found_in_trash' => esc_html__( 'No portfolio items found in Trash', 'palamut' ),
			'parent_item_colon'  => '',
		);

		$args = array(
			'labels'             => $labels,
			'menu_icon'          => 'dashicons-portfolio',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => null,
			'show_in_rest'       => true,
			'rewrite'            => array(
				'slug' => $slug,
			),
			'supports'           => array( 'author', 'comments', 'custom-fields', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'title' ),
		);

		register_post_type( 'portfolio', $args );

		register_taxonomy(
			'portfolio-types',
			'portfolio',
			array(
				'label'        => esc_html__( 'Portfolio categories', 'palamut' ),
				'hierarchical' => true,
				'query_var'    => true,
				'rewrite'      => array(
					'slug' => $tax,
				),
			)
		);
	}
}

add_action( 'init', 'palamut_portfolio_post_type' );

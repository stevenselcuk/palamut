<?php
/**
 * Gutenberg Blocks
 *
 * Theme Spesific and/or generic Gutenberg Blocks and Support Functions
 *
 * @link https://wordpress.org/gutenberg/handbook/designers-developers/
 *
 * @package Palamut
 *
 * @subpackage Gutenberg Blocks
 * @category Theme Features
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

// Register PHP Blocks aka dynamic blocks.
require_once PALAMUT_PATH . 'includes/supports/gutenberg/blocks/src/blocks/post-grid/index.php';

/**
 * Add Style Source to front-end enqueue
 *
 * @method palamut_block_assets
 *
 * @since 1.0.1
 */
function palamut_block_assets() {
	wp_enqueue_script(
		'swiper',
		PALAMUT_PATH_URL . 'includes/supports/gutenberg/assets/js/swiper.min.js',
		array(),
		'4.5.0',
		true
	);
	wp_enqueue_script(
		'swiper-init',
		PALAMUT_PATH_URL . 'includes/supports/gutenberg/assets/js/swiper-init.js',
		array( 'swiper' ),
		'1.0',
		true
	);
	wp_enqueue_style(
		'palamut-gutenberg-frontend',
		PALAMUT_PATH_URL . 'includes/supports/gutenberg/blocks/dist/blocks.style.build.css',
		array(),
		PALAMUT_VERSION
	);

	global $pagenow;
	$localized = array(
		'curPage' => ( ! empty( $pagenow ) ? $pagenow : '' ),
	);
	wp_localize_script( 'swiper-init', 'palamut', $localized );
}

add_action( 'enqueue_block_assets', 'palamut_block_assets' );

/**
 * Add Style & JS Sources to editor
 *
 * @method palamut_editor_assets
 *
 * @since 1.0.1
 */
function palamut_editor_assets() {
	wp_register_style(
		'palamut-gutenberg-editor',
		PALAMUT_PATH_URL . 'includes/supports/gutenberg/blocks/dist/blocks.editor.build.css',
		array(),
		PALAMUT_VERSION
	);

	// Scripts.
	wp_register_script(
		'palamut-gutenberg-editor',
		PALAMUT_PATH_URL . 'includes/supports/gutenberg/blocks/dist/blocks.build.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-plugins', 'wp-components', 'wp-edit-post', 'wp-api' ),
		PALAMUT_VERSION,
		true
	);

}

add_action( 'init', 'palamut_editor_assets' );

/**
 * Register the blocks
 *
 * @method palamut_register_blocks
 *
 * @since 1.0.1
 */
function palamut_register_blocks() {

	// No Guteberg No register.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	register_block_type(
		'palamut/accordion',
		array(
			'editor_script' => 'palamut-gutenberg-editor',
			'editor_style'  => 'palamut-gutenberg-editor',
			'style'         => 'palamut-gutenberg-frontend',
		)
	);
	register_block_type(
		'palamut/alert',
		array(
			'editor_script' => 'palamut-gutenberg-editor',
			'editor_style'  => 'palamut-gutenberg-editor',
			'style'         => 'palamut-gutenberg-frontend',
		)
	);
	register_block_type(
		'palamut/author',
		array(
			'editor_script' => 'palamut-gutenberg-editor',
			'editor_style'  => 'palamut-gutenberg-editor',
			'style'         => 'palamut-gutenberg-frontend',
		)
	);
	register_block_type(
		'palamut/click-to-tweet',
		array(
			'editor_script' => 'palamut-gutenberg-editor',
			'editor_style'  => 'palamut-gutenberg-editor',
			'style'         => 'palamut-gutenberg-frontend',
		)
	);
	register_block_type(
		'palamut/dynamic-separator',
		array(
			'editor_script' => 'palamut-gutenberg-editor',
			'editor_style'  => 'palamut-gutenberg-editor',
			'style'         => 'palamut-gutenberg-frontend',
		)
	);
	register_block_type(
		'palamut/gif',
		array(
			'editor_script' => 'palamut-gutenberg-editor',
			'editor_style'  => 'palamut-gutenberg-editor',
			'style'         => 'palamut-gutenberg-frontend',
		)
	);
	register_block_type(
		'palamut/gist',
		array(
			'editor_script' => 'palamut-gutenberg-editor',
			'editor_style'  => 'palamut-gutenberg-editor',
			'style'         => 'palamut-gutenberg-frontend',
		)
	);

	register_block_type(
		'palamut/highlight',
		array(
			'editor_script' => 'palamut-gutenberg-editor',
			'editor_style'  => 'palamut-gutenberg-editor',
			'style'         => 'palamut-gutenberg-frontend',
		)
	);

	register_block_type(
		'palamut/postgrid',
		array(
			'attributes'      => array(
				'categories'         => array(
					'type' => 'string',
				),
				'className'          => array(
					'type' => 'string',
				),
				'postsToShow'        => array(
					'type'    => 'number',
					'default' => 6,
				),
				'displayPostDate'    => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostExcerpt' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostAuthor'  => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostImage'   => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostLink'    => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostTitle'   => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'postLayout'         => array(
					'type'    => 'string',
					'default' => 'grid',
				),
				'columns'            => array(
					'type'    => 'number',
					'default' => 2,
				),
				'align'              => array(
					'type'    => 'string',
					'default' => 'center',
				),
				'width'              => array(
					'type'    => 'string',
					'default' => 'wide',
				),
				'order'              => array(
					'type'    => 'string',
					'default' => 'desc',
				),
				'orderBy'            => array(
					'type'    => 'string',
					'default' => 'date',
				),
				'imageCrop'          => array(
					'type'    => 'string',
					'default' => 'landscape',
				),
				'readMoreText'       => array(
					'type'    => 'string',
					'default' => 'Continue Reading',
				),
			),
			'render_callback' => 'palamut_render_block_core_latest_posts',
		)
	);
}

add_action( 'init', 'palamut_register_blocks' );

/**
 * Registers Post-Grid Meta
 *
 * @method palamut_register_rest_fields
 *
 * @since
 *
 * @link
 */
function palamut_register_rest_fields() {
	register_rest_field(
		'post',
		'featured_image_src',
		array(
			'get_callback'    => 'palamut_get_image_src_landscape',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	register_rest_field(
		'post',
		'featured_image_src_square',
		array(
			'get_callback'    => 'palamut_get_image_src_square',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	register_rest_field(
		'post',
		'author_info',
		array(
			'get_callback'    => 'palamut_get_author_info',
			'update_callback' => null,
			'schema'          => null,
		)
	);

}
add_action( 'rest_api_init', 'palamut_register_rest_fields' );

/**
 * [palamut_register_meta description]
 *
 * @method palamut_register_meta
 *
 * @since
 *
 * @link
 */
function palamut_register_meta() {
	register_meta(
		'post',
		'_palamut_attr',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'auth_callback' => function() {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	register_meta(
		'post',
		'_palamut_dimensions',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'auth_callback' => function() {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	register_meta(
		'post',
		'_palamut_responsive_height',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'auth_callback' => function() {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	register_meta(
		'post',
		'_palamut_accordion_ie_support',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'auth_callback' => function() {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}

add_action( 'init', 'palamut_register_meta' );

/**
 * [palamut_register_settings description]
 *
 * @method palamut_register_settings
 *
 * @since
 *
 * @link
 */
function palamut_register_settings() {
	register_setting(
		'palamut_settings_api',
		'palamut_settings_api',
		array(
			'type'              => 'string',
			'description'       => __( 'Enable or disable blocks', 'palamut' ),
			'sanitize_callback' => 'sanitize_text_field',
			'show_in_rest'      => true,
			'default'           => '',
		)
	);
}

add_action( 'init', 'palamut_register_settings' );



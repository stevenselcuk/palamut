<?php
/**
 * Serverside for Post-Grid Block
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

/**
 * [palamut_render_block_core_latest_posts description]
 *
 * @method palamut_render_block_core_latest_posts
 *
 * @since
 *
 * @link
 *
 * @param  array $attributes [description].
 */
function palamut_render_block_core_latest_posts( $attributes ) {

	$categories = isset( $attributes['categories'] ) ? $attributes['categories'] : '';

	$recent_posts = wp_get_recent_posts(
		array(
			'numberposts' => $attributes['postsToShow'],
			'post_status' => 'publish',
			'order'       => $attributes['order'],
			'orderby'     => $attributes['orderBy'],
			'category'    => $categories,
		),
		'OBJECT'
	);

	$list_items_markup = '';

	if ( $recent_posts ) {
		foreach ( $recent_posts as $post ) {
			$post_id = $post->ID;

			$post_thumb_id = get_post_thumbnail_id( $post_id );

			if ( $post_thumb_id && isset( $attributes['displayPostImage'] ) && $attributes['displayPostImage'] ) {
				$post_thumb_class = 'has-thumb';
			} else {
				$post_thumb_class = 'no-thumb';
			}

			$list_items_markup .= sprintf(
				'<article class="%1$s">',
				esc_attr( $post_thumb_class )
			);

			if ( isset( $attributes['displayPostImage'] ) && $attributes['displayPostImage'] && $post_thumb_id ) {
				if ( $attributes['imageCrop'] === 'landscape' ) {
					$post_thumb_size = 'palamut-block-post-grid-landscape';
				} else {
					$post_thumb_size = 'palamut-block-post-grid-square';
				}

				$list_items_markup .= sprintf(
					'<div class="palamut-block-post-grid-image"><a href="%1$s" rel="bookmark">%2$s</a></div>',
					esc_url( get_permalink( $post_id ) ),
					wp_get_attachment_image( $post_thumb_id, $post_thumb_size )
				);
			}

			$list_items_markup .= sprintf(
				'<div class="palamut-block-post-grid-text">'
			);

				$title = get_the_title( $post_id );

			if ( ! $title ) {
				$title = __( 'Untitled', 'atomic-blocks' );
			}

			if ( isset( $attributes['displayPostTitle'] ) && $attributes['displayPostTitle'] ) {
				$list_items_markup .= sprintf(
					'<h2 class="palamut-block-post-grid-title"><a href="%1$s" rel="bookmark">%2$s</a></h2>',
					esc_url( get_permalink( $post_id ) ),
					esc_html( $title )
				);
			}

				$list_items_markup .= sprintf(
					'<div class="palamut-block-post-grid-byline">'
				);

			if ( isset( $attributes['displayPostAuthor'] ) && $attributes['displayPostAuthor'] ) {
				$list_items_markup .= sprintf(
					'<div class="palamut-block-post-grid-author"><a class="palamut-text-link" href="%2$s">%1$s</a></div>',
					esc_html( get_the_author_meta( 'display_name', $post->post_author ) ),
					esc_html( get_author_posts_url( $post->post_author ) )
				);
			}

			if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
				$list_items_markup .= sprintf(
					'<time datetime="%1$s" class="palamut-block-post-grid-date">%2$s</time>',
					esc_attr( get_the_date( 'c', $post_id ) ),
					esc_html( get_the_date( '', $post_id ) )
				);
			}

				$list_items_markup .= sprintf(
					'</div>'
				);

				$list_items_markup .= sprintf(
					'<div class="palamut-block-post-grid-excerpt">'
				);

					$excerpt = apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $post_id, 'display' ) );

			if ( empty( $excerpt ) ) {
				$excerpt = apply_filters( 'the_excerpt', wp_trim_words( $post->post_content, 55 ) );
			}

			if ( ! $excerpt ) {
				$excerpt = null;
			}

			if ( isset( $attributes['displayPostExcerpt'] ) && $attributes['displayPostExcerpt'] ) {
				$list_items_markup .= wp_kses_post( $excerpt );
			}

			if ( isset( $attributes['displayPostLink'] ) && $attributes['displayPostLink'] ) {
				$list_items_markup .= sprintf(
					'<p><a class="palamut-block-post-grid-link palamut-text-link" href="%1$s" rel="bookmark">%2$s</a></p>',
					esc_url( get_permalink( $post_id ) ),
					esc_html( $attributes['readMoreText'] )
				);
			}

				$list_items_markup .= sprintf(
					'</div>'
				);

			$list_items_markup .= sprintf(
				'</div>'
			);

			$list_items_markup .= "</article>\n";
		}
	}

	$class = "palamut-block-post-grid align{$attributes['align']}";

	if ( isset( $attributes['className'] ) ) {
		$class .= ' ' . $attributes['className'];
	}

	$grid_class = 'palamut-post-grid-items';

	if ( isset( $attributes['postLayout'] ) && 'list' === $attributes['postLayout'] ) {
		$grid_class .= ' is-list';
	} else {
		$grid_class .= ' is-grid';
	}

	if ( isset( $attributes['columns'] ) && 'grid' === $attributes['postLayout'] ) {
		$grid_class .= ' columns-' . $attributes['columns'];
	}

	$block_content = sprintf(
		'<div class="%1$s"><div class="%2$s">%3$s</div></div>',
		esc_attr( $class ),
		esc_attr( $grid_class ),
		$list_items_markup
	);

	return $block_content;
}

/**
 * [palamut_get_image_src_landscape description]
 *
 * @method palamut_get_image_src_landscape
 *
 * @since
 *
 * @link
 *
 * @param  string $object     [description].
 * @param  string $field_name [description].
 * @param  string $request    [description].
 *
 * @return [type][description]
 */
function palamut_get_image_src_landscape( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src(
		$object['featured_media'],
		'palamut-block-post-grid-landscape',
		false
	);
	return $feat_img_array[0];
}

/**
 * [palamut_get_image_src_square description]
 *
 * @method palamut_get_image_src_square
 *
 * @since
 *
 * @link
 *
 * @param  [type] $object     [description].
 * @param  [type] $field_name [description].
 * @param  [type] $request    [description].
 *
 * @return [type] [description]
 */
function palamut_get_image_src_square( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src(
		$object['featured_media'],
		'palamut-block-post-grid-square',
		false
	);
	return $feat_img_array[0];
}

/**
 * [palamut_get_author_info description]
 *
 * @method palamut_get_author_info
 *
 * @since
 *
 * @link
 *
 * @param  [type] $object     [description].
 * @param  [type] $field_name [description].
 * @param  [type] $request    [description].
 *
 * @return array Author Data
 */
function palamut_get_author_info( $object, $field_name, $request ) {

	$author_data['display_name'] = get_the_author_meta( 'display_name', $object['author'] );

	$author_data['author_link'] = get_author_posts_url( $object['author'] );

	return $author_data;
}

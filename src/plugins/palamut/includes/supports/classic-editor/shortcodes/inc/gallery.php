<?php
/**
 * Gallery Shortcode
 *
 * A new approch for default WordPress Gallery feature
 *
 * @link https://codex.wordpress.org/Gallery_Shortcode
 *
 * @package Palamut
 *
 * @subpackage Theme Features
 * @category Shortcode
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! ( function_exists( 'palamut_add_gallery_settings' ) ) ) {
	/**
	 * [palamut_add_gallery_settings description]
	 *
	 * @method palamut_add_gallery_settings
	 *
	 * @since
	 *
	 * @link
	 */
	function palamut_add_gallery_settings() {
		?>
		<script type="text/html" id="tmpl-Palamut-gallery-setting">
			<h3>Palamut Theme Gallery Settings</h3>
			<label class="setting">
				<span><?php esc_html_e( 'Gallery Options', 'palamut' ); ?></span>
				<select data-setting="layout">
					<option value="default">Default Layout</option>
					<option value="slider">Palamut Slider</option>
					<option value="lightbox">Palamut Lightbox Gallery</option>
				</select>
			</label>
		</script>

		<script>
			jQuery(document).ready(function(){
				jQuery.extend(wp.media.gallery.defaults, { layout: 'default' });

				wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
					template: function(view){
					return wp.media.template('gallery-settings')(view)
							+ wp.media.template('Palamut-gallery-setting')(view);
					}
				});
			});
		</script>

		<?php
	}
	// Register it.
	add_action( 'print_media_templates', 'palamut_add_gallery_settings' );
}

if ( ! ( function_exists( 'palamut_post_gallery' ) ) ) {
	/**
	 * [palamut_post_gallery description]
	 *
	 * @method palamut_post_gallery
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $output [description].
	 * @param  [type] $attr   [description].
	 *
	 * @return [type]                       [description]
	 */
	function palamut_post_gallery( $output, $attr ) {

		global $post, $wp_locale;

		static $instance = 0;
		$instance++;

		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		extract(
			shortcode_atts(
				array(
					'order'      => 'ASC',
					'orderby'    => 'menu_order ID',
					'id'         => $post->ID,
					'itemtag'    => 'div',
					'icontag'    => 'dt',
					'captiontag' => 'dd',
					'columns'    => 3,
					'size'       => 'large',
					'include'    => '',
					'exclude'    => '',
					'layout'     => '',
				),
				$attr
			)
		);

		$id = intval( $id );
		if ( 'RAND' == $order ) {
			$orderby = 'none';
		}

		if ( ! empty( $include ) ) {
			$include      = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts(
				array(
					'include'        => $include,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby,
				)
			);

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[ $val->ID ] = $_attachments[ $key ];
			}
		} elseif ( ! empty( $exclude ) ) {
			$exclude     = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'exclude'        => $exclude,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby,
				)
			);
		} else {
			$attachments = get_children(
				array(
					'post_parent'    => $id,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby,
				)
			);
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			}
			return $output;
		}

		/**
		 * Return Lightbox Layout
		 */
		if ( $layout == 'lightbox' ) {

			$i      = 0;
			$l      = 0;
			$output = '<div class="tiles clearfix"><div class="items light-gallery">';

			foreach ( $attachments as $id => $attachment ) {
				$link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_url( $id, 'full', false, false ) : wp_get_attachment_url( $id, 'full', true, false );
				$i++;
				$l++;
				$titles = get_post( $id );

				if ( 1 == $l ) {
					$class = 'col-md-4';
				} elseif ( 2 == $l ) {
					$class = 'col-md-8';
				} else {
					$class = 'col-md-6';
				}

				if ( 4 == $l ) {
					$l = 0;
				}

				$output .= '
					<div class="item col-xs-12 col-sm-6 ' . esc_attr( $class ) . '">
						<figure class="overlay">
							<a class="lgitem background-image" href="' . esc_url( $link ) . '" data-sub-html="#caption' . esc_attr( $id ) . '">
								' . wp_get_attachment_image( $id, 'large' ) . '
							</a>
						</figure>
						<div id="caption' . esc_attr( $id ) . '" class="hidden">
							<h3>' . esc_html( $titles->post_title ) . '</h3>
							<p>' . esc_html( $titles->post_excerpt ) . '</p>
						</div>
					</div>
				';

			}

			$output .= '</div></div>';

			return $output;
		}

		/**
		 * Return Slider Layout
		 */
		if ( $layout == 'slider' ) {
			$output = '<div class="post-slider basic-slider owl-carousel">';
			foreach ( $attachments as $id => $attachment ) {
				$output .= '<div class="item">' . wp_get_attachment_image( $id, 'large' ) . '</div>';
			}
			$output .= '</div>';
			return $output;
		}

	}
	add_filter( 'post_gallery', 'palamut_post_gallery', 10, 2 );
}

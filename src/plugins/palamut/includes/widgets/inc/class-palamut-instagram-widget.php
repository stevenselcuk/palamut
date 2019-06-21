<?php
/**
 * Instagram Widget
 *
 * This widget displays latest Instagram photo based on instagram username or hashtag.
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

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
/**
 * [palamut_instagram_widget description]
 *
 * @method palamut_instagram_widget
 *
 * @since
 *
 * @link
 */
function palamut_instagram_widget_init() {
	register_widget( 'Palamut_Instagram_Widget' );
}

add_action( 'widgets_init', 'palamut_instagram_widget_init' );

/**
 * [palamut_Instagram_Widget description]
 */
class Palamut_Instagram_Widget extends WP_Widget {
	/**
	 * [__construct description]
	 *
	 * @method __construct
	 *
	 * @since
	 *
	 * @link
	 */
	public function __construct() {
		parent::__construct(
			'pala-instagram-feed',
			__( 'Palamut widgets: Instagram', 'palamut' ),
			array(
				'classname'                   => 'pala-instagram-feed',
				'description'                 => esc_html__( 'Displays your latest Instagram photos', 'palamut' ),
				'customize_selective_refresh' => true,
			)
		);
		add_action( 'wp_enqueue_scripts', array( &$this, 'instagram_widget_js' ), 11 );
	}
	/**
	 * [widget description]
	 *
	 * @method widget
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $args     [description].
	 * @param  [type] $instance [description].
	 */
	public function widget( $args, $instance ) {
		$title    = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$username = empty( $instance['username'] ) ? '' : $instance['username'];
		$limit    = empty( $instance['number'] ) ? 9 : $instance['number'];
		$size     = empty( $instance['size'] ) ? 'large' : $instance['size'];
		$target   = empty( $instance['target'] ) ? '_self' : $instance['target'];
		$link     = empty( $instance['link'] ) ? '' : $instance['link'];
		echo $args['before_widget'];// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		};
		do_action( 'palamut_instagram_widget_before_widget', $instance );
		if ( '' !== $username ) {
			$media_array = $this->scrape_instagram( $username );
			if ( is_wp_error( $media_array ) ) {
				echo wp_kses_post( $media_array->get_error_message() );
			} else {
				// filter for images only?
				$images_only = apply_filters( 'palamut_instagram_widget_images_only', false );
				if ( $images_only ) {
					$media_array = array_filter( $media_array, array( $this, 'images_only' ) );
				}
				// slice list down to required limit.
				$media_array = array_slice( $media_array, 0, $limit );
				// filters for custom classes.
				$ulclass  = apply_filters( 'palamut_instagram_widget_list_class', 'pala-instagram-widget instagram-widget-' . $size );
				?>
				<script>
				( function( $ ) {
					'use strict';
				$( document ).ready( function() {
					$( '.pala-instagram-widget' ).slick( {

					} );
				} );
				}( jQuery ) );
			</script>
				<div class="<?php echo esc_attr( $ulclass ); ?>">
				<?php
				foreach ( $media_array as $key => $item ) {
						echo '
						<div class="pala-insta-item">
							<a href="' . esc_url( $item['link'] ) . '" target="' . esc_attr( $target ) . '"  class="pala-insta-link" title="' . esc_attr( $item['description'] ) . '">
							<div style="background-image: url(' . esc_url( $item[ $size ] ) . ');" class="pala-insta-image">
									<p class="pala-insta-image__overlay">
										<p class="pala-insta-image__description">' . esc_attr( $item['description'] ) . '</p>
										</p>
								</div>
							</a>
						</div>
						';
				}
				?>
			</div>
				<?php
			}
		}
		$linkclass  = apply_filters( 'palamut_instagram_widget_link_class', 'clearfix' );
		$linkaclass = apply_filters( 'palamut_instagram_widget_linka_class', '' );
		switch ( substr( $username, 0, 1 ) ) {
			case '#':
				$url = '//instagram.com/explore/tags/' . str_replace( '#', '', $username );
				break;
			default:
				$url = '//instagram.com/' . str_replace( '@', '', $username );
				break;
		}
		if ( '' !== $link ) {
			?>
			<p class="<?php echo esc_attr( $linkclass ); ?>">
				<a href="<?php echo esc_url( trailingslashit( $url ) ); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>" class="pala-insta__followme" title="<?php echo esc_attr( $username ); ?>"> <?php echo wp_kses_post( $link ); ?> <i class="fab fa-instagram"></i>
				</a>
			</p>
			<?php
		}
		do_action( 'palamut_instagram_widget_after_widget', $instance );
		echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
	}
	/**
	 * [form description]
	 *
	 * @method form
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $instance [description].
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'    => __( 'Latest Photos', 'palamut' ),
				'username' => '',
				'size'     => 'large',
				'link'     => __( 'Follow me on ', 'palamut' ),
				'number'   => 9,
				'target'   => '_self',
			)
		);
		$title    = $instance['title'];
		$username = $instance['username'];
		$number   = absint( $instance['number'] );
		$size     = $instance['size'];
		$target   = $instance['target'];
		$link     = $instance['link'];
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'palamut' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( '@username or #tag', 'palamut' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of photos', 'palamut' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Photo size', 'palamut' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" class="widefat">
				<option value="thumbnail" <?php selected( 'thumbnail', $size ); ?>><?php esc_html_e( 'Thumbnail', 'palamut' ); ?></option>
				<option value="small" <?php selected( 'small', $size ); ?>><?php esc_html_e( 'Small', 'palamut' ); ?></option>
				<option value="large" <?php selected( 'large', $size ); ?>><?php esc_html_e( 'Large', 'palamut' ); ?></option>
			<option value="original" <?php selected( 'original', $size ); ?>><?php esc_html_e( 'Original', 'palamut' ); ?></option>
			</select>
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open links in', 'palamut' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
				<option value="_self" <?php selected( '_self', $target ); ?>><?php esc_html_e( 'Current window (_self)', 'palamut' ); ?></option>
				<option value="_blank" <?php selected( '_blank', $target ); ?>><?php esc_html_e( 'New window (_blank)', 'palamut' ); ?></option>
			</select>
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link text', 'palamut' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" /></label></p>
		<?php
	}
	/**
	 * [update description]
	 *
	 * @method update
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $new_instance [description].
	 * @param  [type] $old_instance [description].
	 *
	 * @return [type]               [description]
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
		$instance['number']   = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
		$instance['size']     = ( ( 'thumbnail' === $new_instance['size'] || 'large' === $new_instance['size'] || 'small' === $new_instance['size'] || 'original' === $new_instance['size'] ) ? $new_instance['size'] : 'large' );
		$instance['target']   = ( ( '_self' === $new_instance['target'] || '_blank' === $new_instance['target'] ) ? $new_instance['target'] : '_self' );
		$instance['link']     = strip_tags( $new_instance['link'] );
		return $instance;
	}
	/**
	 * [scrape_instagram description]
	 *
	 * @method scrape_instagram
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $username [description].
	 *
	 * @return [type]                     [description]
	 */
	public function scrape_instagram( $username ) {
		$username = trim( strtolower( $username ) );
		switch ( substr( $username, 0, 1 ) ) {
			case '#':
				$url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
				$transient_prefix = 'h';
				break;
			default:
				$url              = 'https://instagram.com/' . str_replace( '@', '', $username );
				$transient_prefix = 'u';
				break;
		}
		$instagram = get_transient( 'palamut_instagram_widget-2' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) );
		if ( false === $instagram ) {
			$remote = wp_remote_get( $url );
			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'palamut' ) );
			}
			if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'palamut' ) );
			}
			$shards      = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json  = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], true );
			if ( ! $insta_array ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'palamut' ) );
			}
			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'palamut' ) );
			}
			if ( ! is_array( $images ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'palamut' ) );
			}
			$instagram = array();
			foreach ( $images as $image ) {
				if ( true === $image['node']['is_video'] ) {
					$type = 'video';
				} else {
					$type = 'image';
				}
				$caption = __( 'Instagram Image', 'palamut' );
				if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
					$caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
				}
				$instagram[] = array(
					'description' => $caption,
					'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
					'time'        => $image['node']['taken_at_timestamp'],
					'comments'    => $image['node']['edge_media_to_comment']['count'],
					'likes'       => $image['node']['edge_liked_by']['count'],
					'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
					'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
					'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
					'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
					'type'        => $type,
				);
			}

			if ( ! empty( $instagram ) ) {
				set_transient( 'palamut_instagram_widget-2' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'palamut_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}
		if ( ! empty( $instagram ) ) {
			return $instagram;
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'palamut' ) );
		}
	}
	/**
	 * [images_only description]
	 *
	 * @method images_only
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $media_item [description].
	 *
	 * @return [type]                  [description]
	 */
	public function images_only( $media_item ) {
		if ( 'image' === $media_item['type'] ) {
			return true;
		}
		return false;
	}
	/**
	 * Register JS Sources
	 *
	 * @method instagram_widget_js
	 *
	 * @since
	 *
	 * @link
	 */
	public function instagram_widget_js() {

		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			wp_enqueue_script( 'slick', PALAMUT_PATH_URL . 'includes/widgets/assets/js/slick.min.js', array( 'jquery' ), '1.0.0', true );
		}
	}
}

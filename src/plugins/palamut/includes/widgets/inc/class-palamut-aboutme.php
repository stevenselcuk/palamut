<?php
/**
 * Document_title
 *
 * Document_desc
 *
 * @link N/A
 *
 * @package pkg.name
 *
 * @subpackage Theme Functions
 * @category Functions
 *
 * @version pkg.version
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

/**
 * Register The Widget.
 *
 * @method palamut_widget_about_init
 */
function palamut_widget_about_init() {
	register_widget( 'palamut_widget_aboutme' );
}
add_action( 'widgets_init', 'palamut_widget_about_init' );


/**
 * [Palamut_Widget_Aboutme description]
 */
class Palamut_Widget_Aboutme extends WP_Widget {

	/**
	 * Widget Settings.
	 *
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(
			'palamut-aboutme',
			__( 'Palamut widgets: About Me', 'palamut' ),
			array(
				'classname'                   => 'palamut-aboutme',
				'description'                 => esc_html__( 'Displays a information section about you', 'palamut' ),
				'customize_selective_refresh' => true,
			)
		);
	}
	/**
	 * Enqueue all the javascript.
	 */
	public function admin_setup() {
		global $pagenow;

		if ( 'widgets.php' !== $pagenow && 'customize.php' !== $pagenow ) {
			return;
		}

		wp_enqueue_media();
	}

	/**
	 * Widget Output
	 *
	 * @method widget
	 *
	 * @param  [type] $args
	 * @param  [type] $instance
	 *
	 * @return [type]
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		// ------
		echo '' . $before_widget;
		if ( $title != '' ) {
			echo '' . $before_title . $title . $after_title;
		}
		?>
			<div class="about-me">
				<?php if ( $instance['image'] ) : ?>
				<div class="about-me-img">
					<?php
					if ( $instance['image_id'] ) {
						$image_tmp = wp_get_attachment_image_src( $instance['image_id'], 'thumbnail' );
						$image_url = $image_tmp[0];
						if ( $image_url ) {
							echo '<img src="' . esc_url( $image_url ) . '" alt="about-me-image">';
						}
					} else {
						?>
					<img src="<?php echo esc_url( $instance['image'] ); ?>" alt="about-me-image">
					<?php } ?>
				</div>
				<?php endif; ?>
				<div class="content">
					<?php
					if ( $instance['content'] ) :
						echo apply_filters( 'widget_text', $instance['content'], $instance, $this );
					endif;
					?>
				</div>
				<?php
				if ( $instance['show_socials'] && function_exists( 'palamut_get_social_links' ) ) {
//					echo palamut_get_social_links();
				}
				?>
			</div>

		<?php
		echo '' . $after_widget;
		// ------
	}

	// Update
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['image']        = $new_instance['image'];
		$instance['image_id']     = $new_instance['image_id'];
		$instance['content']      = $new_instance['content'];
		$instance['show_socials'] = $new_instance['show_socials'];
		return $instance;
	}

	// Backend Form
	function form( $instance ) {

		$defaults = array(
			'title'        => '',
			'image'        => '',
			'image_id'     => '',
			'content'      => '',
			'show_socials' => 'true',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<script>
		jQuery(document ).ready( function(){
			function media_upload( button_class ) {
				var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
				 jQuery('body').on('click', button_class, function(e) {
					var button_id ='#'+jQuery(this).attr( 'id' );
					var button_id_s = jQuery(this).attr( 'id' ); 
					console.log(button_id); 
					var self = jQuery(button_id);
					var send_attachment_bkp = wp.media.editor.send.attachment;
					var button = jQuery(button_id);
					var id = button.attr( 'id' ).replace( '_button', '' );
					_custom_media = true;
		
					wp.media.editor.send.attachment = function(props, attachment ){
						if ( _custom_media ) {
							jQuery( button_id + '_media_id' ).val(attachment.id); 
							jQuery( button_id + '_media_url' ).val(attachment.url);
						} else {
							return _orig_send_attachment.apply( button_id, [props, attachment] );
						}
					}
					wp.media.editor.open(button);
					return false;
				});
			}
			media_upload( '.upload_image_button' );
		});
		</script>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Section Title', 'palamut' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php _e( 'Profile Photo', 'palamut' ); ?></label>
			<input type="text" class="widefat widget-image-input" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>_media_url" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" />
			<input type="hidden" class="widefat widget-image-id" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>_media_id" name="<?php echo esc_attr( $this->get_field_name( 'image_id' ) ); ?>" value="<?php echo esc_attr( $instance['image_id'] ); ?>" />
			<br><br>
			<a href="#" class="upload_image_button button button-ppalamutry" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php _e( 'Upload image', 'palamut-elements' ); ?></a>
		</p>
		<?php $show_socials = isset( $instance['show_socials'] ) ? (bool) $instance['show_socials'] : false; ?>
<!--		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_socials ); ?> id="<?php echo $this->get_field_id( 'show_socials' ); ?>" name="<?php echo $this->get_field_name( 'show_socials' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_socials' ); ?>"><?php _e( 'Show Social Links?' ); ?></label>
		</p>-->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php _e( 'About Me', 'palamut' ); ?></label>
			<textarea class="widefat" rows="10" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>"><?php echo esc_textarea( $instance['content'] ); ?></textarea>
		</p>
		<?php
	}
}

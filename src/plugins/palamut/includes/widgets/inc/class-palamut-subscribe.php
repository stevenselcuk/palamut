<?php


class palamut_widget_subscribe extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display block with subscribe button.', 'palamut') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'subscribe' );
		parent::__construct( 'subscribe', __('palamut-Subscribe', 'palamut'), $widget_ops, $control_ops );
		add_action('admin_enqueue_scripts', array($this, 'admin_setup'));
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
	}
	/**
	 * Enqueue all the javascript.
	 */
	public function admin_setup() {
		global $pagenow;

        if($pagenow !== 'widgets.php' && $pagenow !== 'customize.php') return;

		wp_enqueue_media();
        wp_enqueue_script(
			'about-me-widget',
			PALAMUT_PATH_URL.'js/about-me-widget.js',
			array(),
			1.0
		);
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

	}

	public function print_scripts() {
		?>
		<script>
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}

	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$bgcolor = ( ! empty( $instance['bgcolor'] ) ) ? $instance['bgcolor'] : '#fff';
		// ------
		echo ''.$before_widget;
		if ( $title !='' ) echo ''.$before_title . $title . $after_title;
		?>
			<div class="subscribe">
				<div class="bg-image">
						<?php if($instance['image']): ?>
						<img src="<?php echo esc_url($instance['image']); ?>" alt="subscribe image background">
					<?php endif; ?>
					<div class="overlay" style="background-color:<?php echo $bgcolor; ?>;"></div>
				</div>
				<div class="content">
					<?php if($instance['content']): 
						echo '<div class="description">'.apply_filters( 'widget_text', $instance['content'], $instance, $this ).'</div>';
					endif;
					if($instance['subscribe_button']){
						echo '<a href="'.esc_url($instance['subscribe_button']).'" class="button subscribe_button">'.esc_html__('Subscribe', 'palamut-elements').'</a>';
					} ?>
				</div>
			</div>

		<?php
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['image'] = $new_instance['image'];
		$instance['content'] = $new_instance['content'];
		$instance[ 'bgcolor' ] = strip_tags( $new_instance['bgcolor'] );
		$instance['subscribe_button'] = $new_instance['subscribe_button'];
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'image' => '', 'content' => '', 'bgcolor' => '', 'subscribe_button' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Image:','palamut'); ?></label>
			<input type="text" class="widefat widget-image-input" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_url" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>" />
			<br><br>
			<a href="#" class="upload_image_button button button-ppalamutry" id="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Upload image', 'palamut-elements'); ?></a>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'bgcolor' ); ?>"><?php _e( 'Overlay color' ); ?></label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'bgcolor' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'bgcolor' ); ?>" value="<?php echo esc_attr($instance['bgcolor']); ?>" data-default-color="#fff" />
		</p>
        <p>            
        	<label for="<?php echo $this->get_field_id( 'subscribe_button' ); ?>"><?php _e( 'Subscribe button url' ); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'subscribe_button' ); ?>" name="<?php echo $this->get_field_name( 'subscribe_button' ); ?>" value="<?php echo $instance['subscribe_button']; ?>"/>
        </p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php _e('Content:','palamut'); ?></label>
			<textarea class="widefat" rows="10" cols="20" id="<?php echo esc_attr($this->get_field_id('content')); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>"><?php echo esc_textarea($instance['content']); ?></textarea>
		</p>
		
    <?php }
}

// Add Widget
function palamut_widget_subscribe_init() {
	register_widget('palamut_widget_subscribe');
}
add_action('widgets_init', 'palamut_widget_subscribe_init');

?>
<?php


class palamut_widget_section_aboutme extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display about me section with your image, name, and description.', 'palamut-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sectionaboutme' );
		parent::__construct( 'sectionaboutme', __('Rima Section AboutMe', 'palamut-elements'), $widget_ops, $control_ops );
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
		extract(shortcode_atts( array(
			'id' => '',
	        'image' => '',
	        'image_id' => '',
	        'thumbsize' => 'full',
	        'section_bg_color' => '',
	        'title' => '',
	        'default_font' => '',
	        'title_font_family' => '',
	        'title_font_size' => '',
	        'text_color' => '',
	        'title_color' => '',
	        'text' => '',
	        'signature_image_id' => ''
        ), $instance ));
		if($title_font_family == 'default'){
			$title_font_family = '';
			$default_font = 'true';
		} else {
			$default_font = 'false';
		}
		// ------
		echo ''.$before_widget;

		echo do_shortcode('[palamutaboutmesection image="'.$image_id.'" thumbsize="'.$thumbsize.'" section_bg_color="'.$section_bg_color.'" title="'.$title.'" default_font="'.$default_font.'" title_font_family="'.$title_font_family.'" title_font_size="'.$title_font_size.'" text="'.$text.'" title_color="'.$title_color.'" text_color="'.$text_color.'" signature_image="'.$signature_image_id.'" id="'.$id.'"]');
		
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = $new_instance['title'];
		$instance['id'] = $new_instance['id'];
		$instance['image'] = $new_instance['image'];
		$instance['image_id'] = $new_instance['image_id'];
		$instance['thumbsize'] = $new_instance['thumbsize'];
		$instance['section_bg_color'] = $new_instance['section_bg_color'];
		$instance['signature_image_id'] = $new_instance['signature_image_id'];
		$instance['signature_image'] = $new_instance['signature_image'];
		$instance['title_font_family'] = $new_instance['title_font_family'];
		$instance['title_font_size'] = $new_instance['title_font_size'];
		$instance['text_color'] = $new_instance['text_color'];
		$instance['title_color'] = $new_instance['title_color'];
		$instance['text'] = $new_instance['text'];
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		$imageSizes = get_intermediate_image_sizes();
		$imageSizes[]= 'full';
		$google_fonts_vc = get_option('palamut_cached_google_fonts_vc');
		$suf = rand(0, 9999);
		$defaults = array('title' => '', 'image' => '', 'image_id' => '', 'signature_image' => '', 'signature_image_id' => '', 'thumbsize' => 'large', 'section_bg_color' => '', 'title_font_size' => '', 'title_font_family' => '', 'id' => $suf, 'text_color' => '', 'title_color' => '', 'text' => '' );
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<input type="hidden" class="widefat widget-image-id" id="<?php echo esc_attr($this->get_field_id('id')); ?>" name="<?php echo esc_attr($this->get_field_name('id')); ?>" value="<?php echo esc_attr($instance['id']); ?>" />
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Select image for your section:','palamut-elements'); ?></label>
			<input type="text" class="widefat widget-image-input" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_url" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>" />
			<input type="hidden" class="widefat widget-image-id" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_id" name="<?php echo esc_attr($this->get_field_name('image_id')); ?>" value="<?php echo esc_attr($instance['image_id']); ?>" />
			<br><br>
			<a href="#" class="upload_image_button button button-ppalamutry" id="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Upload image', 'palamut-elements'); ?></a>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('thumbsize')); ?>"><?php _e('Image size:','palamut-elements'); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'thumbsize' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'thumbsize' ) ); ?>" class="widefat">
				<?php
					foreach ( $imageSizes as $size) {
						printf(
							'<option value="%s"%s>%s</option>',
							esc_attr( $size ),
							selected( $size, $instance['thumbsize'], false ),
							$size
						);
					}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'section_bg_color' ); ?>"><?php _e( 'Section background color:' ); ?></label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'section_bg_color' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'section_bg_color' ); ?>" value="<?php echo esc_attr($instance['section_bg_color']); ?>" data-default-color="#eaf0f9" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','palamut-elements'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"/>
		</p>
		<p>            
        	<label for="<?php echo $this->get_field_id( 'title_font_size' ); ?>"><?php _e( 'Title font size. Do not set (px).' ); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title_font_size' ); ?>" name="<?php echo $this->get_field_name( 'title_font_size' ); ?>" value="<?php echo $instance['title_font_size']; ?>"/>
        </p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title_font_family')); ?>"><?php _e('Title font family:','palamut-elements'); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'title_font_family' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title_font_family' ) ); ?>" class="widefat">
				<option value="default"<?php echo selected('default', $instance['title_font_family'], false); ?>><?php esc_html_e('Default', 'palamut-elements'); ?></option>
				<?php
					foreach ( $google_fonts_vc as $font) {
						printf(
							'<option value="%s"%s>%s</option>',
							esc_attr( 'font_family:'.$font->font_family.'%3Aregular' ),
							selected( 'font_family:'.$font->font_family.'%3Aregular', $instance['title_font_family'], false ),
							$font->font_family
						);
					}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title_color' ); ?>"><?php _e( 'Title color:' ); ?></label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'title_color' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'title_color' ); ?>" value="<?php echo esc_attr($instance['title_color']); ?>" data-default-color="" />
		</p>
		<p>            
        	<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Section text:' ); ?></label>
            <textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo $instance['text']; ?></textarea>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'text_color' ); ?>"><?php _e( 'Text color:' ); ?></label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'text_color' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'text_color' ); ?>" value="<?php echo esc_attr($instance['text_color']); ?>" data-default-color="#ffffff" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('signature_image')); ?>"><?php _e('Select your signature image:','palamut-elements'); ?></label>
			<input type="text" class="widefat widget-image-input" id="<?php echo esc_attr($this->get_field_id('signature_image')); ?>_media_url" name="<?php echo esc_attr($this->get_field_name('signature_image')); ?>" value="<?php echo esc_attr($instance['signature_image']); ?>" />
			<input type="hidden" class="widefat widget-image-id" id="<?php echo esc_attr($this->get_field_id('signature_image')); ?>_media_id" name="<?php echo esc_attr($this->get_field_name('signature_image_id')); ?>" value="<?php echo esc_attr($instance['signature_image_id']); ?>" />
			<br><br>
			<a href="#" class="upload_image_button button button-ppalamutry" id="<?php echo esc_attr($this->get_field_id('signature_image')); ?>"><?php _e('Upload image', 'palamut-elements'); ?></a>
		</p>
        
		
    <?php }
}

// Add Widget
function palamut_widget_section_about_init() {
	register_widget('palamut_widget_section_aboutme');
}
add_action('widgets_init', 'palamut_widget_section_about_init');

?>
<?php


class palamut_widget_sliderposts extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => esc_html__('Display your posts as slider', 'palamut-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sliderposts' );
		parent::__construct( 'sliderposts', esc_html__('palamut-Slider Posts', 'palamut-elements'), $widget_ops, $control_ops );
		add_action('wp_enqueue_scripts', array($this, 'scripts_setup'));
	}

	public function scripts_setup() {
        wp_enqueue_script('owl-carousel');
        wp_enqueue_style('owl-carousel');
	}
	// Widget Output
	function widget($args, $instance) {
		$title = $number = $posts_ids = '';
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$number = $instance['number'];
		$post_ids = $instance['posts_ids'];
		$loop = '';

		if(isset($instance['loop']) && $instance['loop'] ){
			$loop = 'true';
		}
		
		if($post_ids != ''){
			$post_ids = str_replace(' ', '', $post_ids);
			$post_ids = explode(',', $post_ids);
		} else {
			$post_ids = array();
		}
		$rand_id = rand(1,999);
		echo $before_widget;

		if($title != '') {
			echo $before_title . $title . $after_title;
		}
		if( $loop == '' ){
			$loop = 'false';
		}
		$custom_script = '<script>jQuery(window).load(function(){
				"use strict";
				var owl = jQuery("#sliderposts'.esc_attr($rand_id).'").owlCarousel(
			    {
			        items: 1,
			        margin: 0,
			        dots: true,
			        nav: false,
			        autoplay: false,
			        responsiveClass:true,
			        loop: '.$loop.',';
			        if(is_rtl()){
						$custom_script .= 'rtl: true,';
					}
			        $custom_script .= 'smartSpeed: 450,
			        autoHeight: true,
			        themeClass: "owl-post-slider",
			        responsive:{
			            0:{
			                items:1,
			            },
			            1199:{
			                items:1
			            }
			        }
			    });
				owl.on(\'resized.owl.carousel\', function(event) {
				    var $this = jQuery(this);
				    $this.find(\'.owl-height\').css(\'height\', $this.find(\'.owl-item.active\').height() );
				});
			});</script>';
		?>
		<div id="sliderposts<?php echo esc_attr($rand_id); ?>" class="sliderposts">
			<?php
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $number,
				'order' => 'DESC',
				'orderby' => 'date',
				'ignore_sticky_posts' => true,
				'meta_query' => array(
			        array(
			         'key' => '_thumbnail_id',
			         'compare' => 'EXISTS'
			        ),
			    )
			);
			if($post_ids != ''){
				$args['post__in'] = $post_ids;
				$args['orderby'] = 'post__in';
			}
			$latestposts = new WP_Query($args);
			if($latestposts->have_posts()):
				while ( $latestposts->have_posts()): $latestposts->the_post();
				$out = '';
				global $post;
				$categories = get_the_category();
		        echo '<div class="slider-item">';
					if( has_post_thumbnail() ) {
						echo '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, 'palamut-masonry').'</a>';
						echo '<div class="post-more-overlay"><div class="post-more-overlay-inner">';
							if ( ! empty( $categories ) ) {
							    $category = '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
								echo '<div class="meta-categories">'.$category.'</div>';
							}
							echo '<h3><a href="'.esc_url(get_the_permalink()).'">'.esc_attr(get_the_title()).'</a></h3>';
						echo '</div></div>';
						echo '</figure>';
					}
				echo '</div>';
		        endwhile;		
			?>
			<?php endif; wp_reset_postdata();?>
			
		</div>
		<?php
			echo $custom_script;
			echo $after_widget;
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = $new_instance['number'];
		$instance['posts_ids'] = $new_instance['posts_ids'];
		$instance['loop'] = $new_instance['loop'];
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'number' => 3, 'posts_ids'=> '', 'loop'=>'');
		$instance = wp_parse_args((array) $instance, $defaults); 
		$loop = isset( $instance['loop'] ) ? (bool) $instance['loop'] : false;

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e("Title",'palamut-elements'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e("Number of items to show",'palamut-elements'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('posts_ids')); ?>"><?php esc_html_e("Posts IDs",'palamut-elements'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_ids')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_ids')); ?>" value="<?php echo esc_attr($instance['posts_ids']); ?>" />
			<span class="description"><?php esc_html_e("Enter posts IDs to display only those records (Note: separate values by commas (,)).",'palamut-elements'); ?></span>
		</p>
		<p>
			<input type="checkbox" class="checkbox"<?php checked( $loop ); ?> id="<?php echo $this->get_field_id('loop'); ?>" name="<?php echo $this->get_field_name('loop'); ?>"<?php checked( $loop ); ?> />
			<label for="<?php echo $this->get_field_id('loop'); ?>"><?php _e( 'Loop items' ); ?></label></p>
		</p>
	<?php
	}
}

// Add Widget
function palamut_widget_sliderposts_init() {
	register_widget('palamut_widget_sliderposts');
}
add_action('widgets_init', 'palamut_widget_sliderposts_init');

?>
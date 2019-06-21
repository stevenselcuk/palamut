<?php


class palamut_widget_grid_posts extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Show WordPress posts in grid layout. Used for widgetized page.', 'palamut-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'palamutgridposts' );
		parent::__construct( 'palamutgridposts', __('Rima Grid Posts', 'palamut-elements'), $widget_ops, $control_ops );
	}

	// Widget Output
	function widget($args, $instance) {
		extract($args);
		extract(shortcode_atts( array(
			'title' => '',
			'num' => '6',
			'columns' => 'span4',
			'cat_slug' => '',
			'post_ids' => '',
			'thumbsize' => 'large',
			'post__not_in' => '',
			'order' => 'DESC',
			'excerpt_count' => '14',
			'id' => '',
			'pagination' =>'false',
			'text_align' => 'textleft',
			'button_url' => '',
			'button_title' => ''
        ), $instance ));
		
		// ------
		echo ''.$before_widget;
		echo '<div class="container">';
		if($title != ''){
			echo '<div id="title-block" class="span12"><h2 class="title-widget">'.esc_html($title).'</h2>';
			if( $button_url != '' ){
				echo '<a href="'.esc_url($button_url).'" class="button button-subscribe">'.esc_html($button_title).'</a>';
			} 
			echo '</div>';
		}
		echo do_shortcode('[gridposts num="'.$num.'" columns="'.$columns.'" cat_slug="'.$cat_slug.'" post_ids="'.$post_ids.'" post__not_in="'.$post__not_in.'" order="'.$order.'" post_style="style_5" thumbsize="'.$thumbsize.'" excerpt_count="'.$excerpt_count.'" text_align="'.$text_align.'" show_sharebox="false" show_categories="false" show_timeread="true" show_comments="false" show_read_more="false" pagination="'.$pagination.'" ignore_featured="true" ignore_sticky_posts="true"]');
		echo '</div>';
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = $new_instance['title'];
		$instance['num'] = $new_instance['num'];
		$instance['columns'] = $new_instance['columns'];
		$instance['id'] = $new_instance['id'];
		$instance['thumbsize'] = $new_instance['thumbsize'];
		$instance['order'] = $new_instance['order'];
		$instance['cat_slug'] = $new_instance['cat_slug'];
		$instance['post_ids'] = $new_instance['post_ids'];
		$instance['post__not_in'] = $new_instance['post__not_in'];
		$instance['excerpt_count'] = $new_instance['excerpt_count'];
		$instance['pagination'] = $new_instance['pagination'];
		$instance['text_align'] = $new_instance['text_align'];
		$instance['button_url'] = $new_instance['button_url'];
		$instance['button_title'] = $new_instance['button_title'];
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		$imageSizes = get_intermediate_image_sizes();
		$imageSizes[]= 'full';
		$cols = array(
		   'span6' => __('Two', 'palamut-elements'),
		   'span4'=>__('Three', 'palamut-elements'),
		   'span3'=>__('Four', 'palamut-elements'),
		   'one_fifth'=>__('Five', 'palamut-elements'),
		   'span2'=>__('Six', 'palamut-elements'),
		);
		$aligns = array(
		   __('Left', 'palamut-elements')=>'textleft',
		   __('Center', 'palamut-elements')=>'textcenter',
		   __('Right', 'palamut-elements')=>'textright'
		);
		$pagination = array(
        	__('Load more','palamut-elements')=>'true',
        	__('Standard','palamut-elements')=>'standard',
        	__('Disable', 'palamut-elements')=>'false'
        );
		$suf = rand(0, 9999);
		$defaults = array('title' => '', 'num' => '6', 'columns' => 'span4', 'cat_slug' => '', 'post_ids' => '', 'thumbsize' => 'large', 'post__not_in' => '', 'order' => 'DESC', 'excerpt_count' => '14', 'id' => $suf, 'pagination' => 'false', 'text_align' => 'textleft', 'button_title' => 'subscribe', 'button_url' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<input type="hidden" class="widefat" id="<?php echo esc_attr($this->get_field_id('id')); ?>" name="<?php echo esc_attr($this->get_field_name('id')); ?>" value="<?php echo esc_attr($instance['id']); ?>" />
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Block title','palamut-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p> 
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('num')); ?>"><?php _e('Post count','palamut-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('num')); ?>" name="<?php echo esc_attr($this->get_field_name('num')); ?>" value="<?php echo esc_attr($instance['num']); ?>" />
			<div class="description"><?php esc_html_e("Enter number of posts to display (Note: Enter '-1' to display all posts).", 'palamut-elements'); ?></div>
		</p>        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('columns')); ?>"><?php _e('Posts per row','palamut-elements'); ?></label>
			<select name="<?php echo esc_attr($this->get_field_name('columns')); ?>" id="<?php echo esc_attr($this->get_field_id('columns')); ?>" class="widefat">
				<?php
					foreach ( $cols as $col => $value) {
						printf(
							'<option value="%s"%s>%s</option>',
							esc_attr( $col ),
							selected( $col, $instance['columns'], false ),
							$value
						);
					}
				?>
			</select>
			<div class="description"><?php esc_html_e("Select posts count per row.", 'palamut-elements'); ?></div>
		</p> 
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('cat_slug')); ?>"><?php _e('Category slug','palamut-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('cat_slug')); ?>" name="<?php echo esc_attr($this->get_field_name('cat_slug')); ?>" value="<?php echo esc_attr($instance['cat_slug']); ?>" />
			<div class="description"><?php esc_html_e("This help you to retrieve items from specific category. More than one separate by commas.", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post_ids')); ?>"><?php _e('Post IDs','palamut-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('post_ids')); ?>" name="<?php echo esc_attr($this->get_field_name('post_ids')); ?>" value="<?php echo esc_attr($instance['post_ids']); ?>" />
			<div class="description"><?php esc_html_e("Enter posts IDs to display only those records (Note: separate values by commas (,)).", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post__not_in')); ?>"><?php _e('Post IDs Exclude','palamut-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('post__not_in')); ?>" name="<?php echo esc_attr($this->get_field_name('post__not_in')); ?>" value="<?php echo esc_attr($instance['post__not_in']); ?>" />
			<div class="description"><?php esc_html_e("Enter posts IDs to exclude those records (Note: separate values by commas (,)).", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('order')); ?>"><?php _e('Sort order','palamut-elements'); ?></label>
			<select name="<?php echo esc_attr($this->get_field_name('order')); ?>" id="<?php echo esc_attr($this->get_field_id('order')); ?>" class="widefat">
				<option value="DESC" <?php echo selected( 'DESC', $instance['order'], false ); ?>><?php esc_html_e('Descending', 'palamut-elements'); ?></option>
				<option value="ASC" <?php echo selected( 'ASC', $instance['order'], false ); ?>><?php esc_html_e('Ascending', 'palamut-elements'); ?></option>
			</select>
			<div class="description"><?php esc_html_e("Select ascending or descending order.", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('thumbsize')); ?>"><?php _e('Image size','palamut-elements'); ?></label>
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
			<div class="description"><?php esc_html_e("Select your image size to use.", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('excerpt_count')); ?>"><?php _e('Post excerpt count','palamut-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('excerpt_count')); ?>" name="<?php echo esc_attr($this->get_field_name('excerpt_count')); ?>" value="<?php echo esc_attr($instance['excerpt_count']); ?>" />
			<div class="description"><?php esc_html_e("Enter number of words in post excerpt. 0 to hide it.", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('text_align')); ?>"><?php _e('Align elements','palamut-elements'); ?></label>
			<select name="<?php echo esc_attr($this->get_field_name('text_align')); ?>" id="<?php echo esc_attr($this->get_field_id('text_align')); ?>" class="widefat">
				<?php
					foreach ( $aligns as $align => $value) {
						printf(
							'<option value="%s"%s>%s</option>',
							esc_attr( $value ),
							selected( $value, $instance['text_align'], false ),
							$align
						);
					}
				?>
			</select>
			<div class="description"><?php esc_html_e("Select position for text, meta info, categories, etc.", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('pagination')); ?>"><?php _e('Pagination','palamut-elements'); ?></label>
			<select name="<?php echo esc_attr($this->get_field_name('pagination')); ?>" id="<?php echo esc_attr($this->get_field_id('pagination')); ?>" class="widefat">
				<?php
					foreach ( $pagination as $key => $value) {
						printf(
							'<option value="%s"%s>%s</option>',
							esc_attr( $value ),
							selected( $value, $instance['pagination'], false ),
							$key
						);
					}
				?>
			</select>
			<div class="description"><?php esc_html_e("Select pagination for posts.", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('button_title')); ?>"><?php _e('Button text','palamut-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('button_title')); ?>" name="<?php echo esc_attr($this->get_field_name('button_title')); ?>" value="<?php echo esc_attr($instance['button_title']); ?>" />
			<div class="description"><?php esc_html_e("Enter button title. This button located at the right of block title.", 'palamut-elements'); ?></div>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('button_url')); ?>"><?php _e('Button URL','palamut-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('button_url')); ?>" name="<?php echo esc_attr($this->get_field_name('button_url')); ?>" value="<?php echo esc_attr($instance['button_url']); ?>" />
			<div class="description"><?php esc_html_e("Enter button URL. This button located at the right of block title. Leave empty to disable button.", 'palamut-elements'); ?></div>
		</p> 
    <?php }
}

// Add Widget
function palamut_widget_grid_posts_init() {
	register_widget('palamut_widget_grid_posts');
}
add_action('widgets_init', 'palamut_widget_grid_posts_init');

?>
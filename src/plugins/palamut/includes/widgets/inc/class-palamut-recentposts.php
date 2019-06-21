<?php


class widget_palamut_latestposts extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display your posts', 'palamut-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'palamutlatestposts' );
		parent::__construct( 'palamutlatestposts', __('palamut-Recent Posts', 'palamut-elements'), $widget_ops, $control_ops );
	}
	// Widget Output
	function widget($args, $instance) {
		$title = $number = $order_by = $order = $excerpt_count = $layout = '';
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$number = $instance['number'];
		$order_by = $instance['order_by'];
		$order = $instance['order'];
		$excerpt_count = $instance['excerpt_count'];
		$layout = $instance['layout'];
		
		echo ''.$before_widget;

		if($title != '') {
			echo ''.$before_title . $title . $after_title;
		}
		?>
		<div class="latest-blog-lists">
			<?php
			$args = array(
				'post_type' => 'post',
				'post__not_in' => get_option( 'sticky_posts' ),
				'posts_per_page' => $number,
				'order' => $order,
				'orderby' => $order_by
			);
			$latestposts = new WP_Query($args);
			if($latestposts->have_posts()):
				switch ($layout) {
					case 'thumb':
						while ( $latestposts->have_posts()): $latestposts->the_post();
						$out = '';
						global $post;
				        $attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
				        $url = $attachment_url['0'];
				        $image = $url;
				        $out .= '<div class="latest-blog-list clearfix">';
				        $out .= '<div class="wrapper">';
				        if(has_post_thumbnail()){
				          $out .= '<figure class="latest-blog-item-img alignleft"><a href="'.get_the_permalink().'"><img src="'.esc_url($image).'" alt="'.esc_attr(the_title_attribute('echo=0')).'" /></a></figure>';
				        }
				        $out .= '<div class="meta-categories no-dots">'.get_the_category_list(', ').'</div>';
				        $out .= '<h4><a href="'.esc_url(get_permalink()).'" title="' . esc_attr(the_title_attribute('echo=0')) . '">'.esc_attr(the_title_attribute('echo=0')) .'</a></h4>';
				        $out .= '</div>';
				        if($excerpt_count > 0) {
					        $out .= '<div class="latest-blog-item-description">';
					        $out .= palamut_string_limit_words(get_the_excerpt(),$excerpt_count);
					        $out .= '</div>';
					    }
				        $out .= '</div>';
				        echo ''.$out;
				        endwhile;
						break;
					default:?>
					<ul class="list-latestposts">
						<?php while($latestposts->have_posts()): $latestposts->the_post(); ?>
						<li class="post-item">
							<?php 
					        	echo '<h4><a href="'.esc_url(get_permalink()).'" title="' . esc_attr(the_title_attribute('echo=0')) . '">'.esc_attr(the_title_attribute('echo=0')) .'</a></h4>';
					        	echo '<div class="post-meta">';
					        	echo '<div class="meta-date"><time datetime="'.get_the_date(DATE_W3C).'">'.get_the_time(get_option('date_format')).'</time></div>';
					        	echo '<div class="meta-read">'.palamut_calculate_reading_time().'</div>';
					        	echo '</div>';
					        	echo palamut_string_limit_words(get_the_excerpt(),$excerpt_count); 
				        	?>
				       </li>
						<?php endwhile;?>
					</ul> 
					<?php
						# code...
						break;
				}
			?>
			<?php endif; wp_reset_postdata();?>
			
		</div>
		<?php echo ''.$after_widget;
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = $new_instance['number'];
		$instance['order_by'] = $new_instance['order_by'];
		$instance['order'] = $new_instance['order'];
		$instance['excerpt_count'] = $new_instance['excerpt_count'];
		$instance['layout'] = $new_instance['layout'];
		
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		$selected1 = '';
		$selected2 = '';
		$selected3 = '';
		$selected4 = '';
		$selected5 = '';
		
		$defaults = array('title' => 'Latest posts', 'number' => 3, 'excerpt_count'=> 6, 'order_by' => 'date', 'order'=>'DESC', 'layout'=>'list');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e("Title",'palamut-elements'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<?php
			switch ($instance['layout']) {
				case 'list':
					$selected1 = 'selected="selected"';
					break;
				case 'thumb':
					$selected2 = 'selected="selected"';
					break;
				default:
					$selected1 = '';
					$selected2 = '';
					break;
			}
			?>
			<label for="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>"><?php esc_html_e("Layout",'palamut-elements'); ?>:</label>
			<select id="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name( 'layout' )); ?>">
			  <option value="list" <?php echo esc_attr($selected1); ?>><?php esc_html_e("Simple list",'palamut-elements'); ?></option>
			  <option value="thumb" <?php echo esc_attr($selected2); ?>><?php esc_html_e("Thumbnail & title",'palamut-elements'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e("Number of items to show",'palamut-elements'); ?>:</label>
			<input type="text" class="widefat" style="width: 35px;" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('excerpt_count')); ?>"><?php esc_html_e("How many words show?",'palamut-elements'); ?>:</label>
			<input type="text" class="widefat" style="width: 35px;" id="<?php echo esc_attr($this->get_field_id('excerpt_count')); ?>" name="<?php echo esc_attr($this->get_field_name('excerpt_count')); ?>" value="<?php echo esc_attr($instance['excerpt_count']); ?>" />
		</p>

		<p>
			<?php
			switch ($instance['order']) {
				case 'ASC':
					$selected1 = 'selected="selected"';
					$selected2 = '';
					break;
				case 'DESC':
					$selected2 = 'selected="selected"';
					$selected1 = '';
					break;
				default:
					$selected1 = '';
					$selected2 = '';
					break;
			}
			?>
			<label for="<?php echo esc_attr($this->get_field_id( 'order' )); ?>"><?php esc_html_e("Order",'palamut-elements'); ?>:</label>
			<select id="<?php echo esc_attr($this->get_field_id( 'order' )); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name( 'order' )); ?>">
			  <option value="ASC" <?php echo esc_attr($selected1); ?>><?php esc_html_e("Lowest to highest values",'palamut-elements'); ?></option>
			  <option value="DESC" <?php echo esc_attr($selected2); ?>><?php esc_html_e("Highest to lowest values",'palamut-elements'); ?></option>
			</select>
		</p>

		<p>
			<?php
			switch ($instance['order_by']) {
				case 'title':
					$selected1 = 'selected="selected"';
					break;
				case 'ID':
					$selected2 = 'selected="selected"';
					break;
				case 'date':
					$selected3 = 'selected="selected"';
					break;
				case 'modified':
					$selected4 = 'selected="selected"';
					break;
				case 'comment_count':
					$selected5 = 'selected="selected"';
					break;
				default:
					$selected1 = '';
					$selected2 = '';
					$selected3 = '';
					$selected4 = '';
					$selected5 = '';
					break;
			}
			?>
			<label for="<?php echo esc_attr($this->get_field_id( 'order_by' )); ?>"><?php esc_html_e("Order by",'palamut-elements'); ?>:</label>
			<select id="<?php echo esc_attr($this->get_field_id( 'order_by' )); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name( 'order_by' )); ?>">
			  <option value="title" <?php echo esc_attr($selected1); ?>><?php esc_html_e("Title",'palamut-elements'); ?></option>
			  <option value="ID" <?php echo esc_attr($selected2); ?>><?php esc_html_e("Post's ID",'palamut-elements'); ?></option>
			  <option value="date" <?php echo esc_attr($selected3); ?>><?php esc_html_e("Date",'palamut-elements'); ?></option>
			  <option value="modified" <?php echo esc_attr($selected4); ?>><?php esc_html_e("Modified date",'palamut-elements'); ?></option>
			  <option value="comment_count" <?php echo esc_attr($selected5); ?>><?php esc_html_e("Popular",'palamut-elements'); ?></option>
			</select>
		</p>
	<?php
	}
}

// Add Widget
function widget_palamut_latestposts_init() {
	register_widget('widget_palamut_latestposts');
}
add_action('widgets_init', 'widget_palamut_latestposts_init');

?>
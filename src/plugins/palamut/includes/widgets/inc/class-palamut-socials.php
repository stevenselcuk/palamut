<?php


class palamut_widget_socials extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display your Socials icons', 'palamut') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'socials' );
		parent::__construct( 'socials', __('palamut-Socials', 'palamut'), $widget_ops, $control_ops );
	}
	
	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$format = $instance['socials_style'];
		// ------
		echo ''.$before_widget;
		if ( $title != '' ) echo ''.$before_title . $title . $after_title;
		?>
		<div class="social-icons">
			<ul class="unstyled">
			<?php 
			$output='';
			if($format == 'text'){
				if($instance['facebook'] != "") { 
					$output .= '<li class="social-facebook"><a href="'.esc_url($instance['facebook']).'" target="_blank" title="'.__( 'Facebook', 'palamut').'">'.__( 'Facebook', 'palamut').'</a></li>';
				}
				if($instance['twitter'] != "") { 
					$output .= '<li class="social-twitter"><a href="'.esc_url($instance['twitter']).'" target="_blank" title="'.__( 'Twitter', 'palamut').'">'.__( 'Twitter', 'palamut').'</a></li>';
				} 	 
				if($instance['instagram'] != '') { 
					$output .= '<li class="social-instagram"><a href="'.esc_url($instance['instagram']).'" target="_blank" title="'.__( 'Instagram', 'palamut').'">'.__( 'Instagram', 'palamut').'</a></li>';
				}
				if($instance['bloglovin'] != "") { 
					$output .= '<li class="social-bloglovin"><a href="'.esc_url($instance['bloglovin']).'" target="_blank" title="'.__( 'Bloglovin', 'palamut').'">'.__( 'Bloglovin', 'palamut').'</a></li>';
				}
				if($instance['pinterest'] != "") { 
					$output .= '<li class="social-pinterest"><a href="'.esc_url($instance['pinterest']).'" target="_blank" title="'.__( 'Pinterest', 'palamut').'">'.__( 'Pinterest', 'palamut').'</a></li>';
				}
				if($instance['googleplus'] != "") { 
					$output .= '<li class="social-googleplus"><a href="'.esc_url($instance['googleplus']).'" target="_blank" title="'.__( 'Google plus', 'palamut').'">'.__( 'Google plus', 'palamut').'</a></li>';
				}
				if($instance['forrst'] != "") { 
					$output .= '<li class="social-forrst"><a href="'.esc_url($instance['forrst']).'" target="_blank" title="'.__( 'Forrst', 'palamut').'">'.__( 'Forrst', 'palamut').'</a></li>';
				}
				if($instance['dribbble'] != "") { 
					$output .= '<li class="social-dribbble"><a href="'.esc_url($instance['dribbble']).'" target="_blank" title="'.__( 'Dribbble', 'palamut').'">'.__( 'Dribbble', 'palamut').'</a></li>';
				}
				if($instance['flickr'] != "") { 
					$output .= '<li class="social-flickr"><a href="'.esc_url($instance['flickr']).'" target="_blank" title="'.__( 'Flickr', 'palamut').'">'.__( 'Flickr', 'palamut').'</a></li>';
				}
				if($instance['linkedin'] != "") { 
					$output .= '<li class="social-linkedin"><a href="'.esc_url($instance['linkedin']).'" target="_blank" title="'.__( 'LinkedIn', 'palamut').'">'.__( 'LinkedIn', 'palamut').'</a></li>';
				}
				if($instance['skype'] != "") { 
					$output .= '<li class="social-skype"><a href="skype:'.esc_attr($instance['skype']).'" title="'.__( 'Skype', 'palamut').'">'.__( 'Skype', 'palamut').'</a></li>';
				}
				if($instance['digg'] != "") { 
					$output .= '<li class="social-digg"><a href="'.esc_url($instance['digg']).'" target="_blank" title="'.__( 'Digg', 'palamut').'">'.__( 'Digg', 'palamut').'</a></li>';
				}
				if($instance['vimeo'] != "") { 
					$output .= '<li class="social-vimeo"><a href="'.esc_url($instance['vimeo']).'" target="_blank" title="'.__( 'Vimeo', 'palamut').'">'.__( 'Vimeo', 'palamut').'</a></li>';
				}
				if($instance['yahoo'] != "") { 
					$output .= '<li class="social-yahoo"><a href="'.esc_url($instance['yahoo']).'" target="_blank" title="'.__( 'Yahoo', 'palamut').'">'.__( 'Yahoo', 'palamut').'</a></li>';
				}
				if($instance['tumblr'] != "") { 
					$output .= '<li class="social-tumblr"><a href="'.esc_url($instance['tumblr']).'" target="_blank" title="'.__( 'Tumblr', 'palamut').'">'.__( 'Tumblr', 'palamut').'</a></li>';
				}
				if($instance['youtube'] != "") { 
					$output .= '<li class="social-youtube"><a href="'.esc_url($instance['youtube']).'" target="_blank" title="'.__( 'YouTube', 'palamut').'">'.__( 'YouTube', 'palamut').'</a></li>';
				}
				if($instance['deviantart'] != "") { 
					$output .= '<li class="social-deviantart"><a href="'.esc_url($instance['deviantart']).'" target="_blank" title="'.__( 'DeviantArt', 'palamut').'">'.__( 'DeviantArt', 'palamut').'</a></li>';
				}
				if($instance['behance'] != "") { 
					$output .= '<li class="social-behance"><a href="'.esc_url($instance['behance']).'" target="_blank" title="'.__( 'Behance', 'palamut').'">'.__( 'Behance', 'palamut').'</a></li>';
				}
				if($instance['delicious'] != "") { 
					$output .= '<li class="social-delicious"><a href="'.esc_url($instance['delicious']).'" target="_blank" title="'.__( 'Delicious', 'palamut').'">'.__( 'Delicious', 'palamut').'</a></li>';
				}
				$extra_icons = palamut_get_custom_social_icon();
				if( !empty($extra_icons) ){
					foreach ($extra_icons as $icon) {
						$name = str_replace(' ', '', $icon['name']);
						$output .= '<li class="social-'.esc_attr(strtolower($name)).'"><a href="'.esc_url($icon['url']).'" target="_blank" title="'.esc_attr(ucfirst($icon['name'])).'">'.esc_html(ucfirst($icon['name'])).'</a></li>';
					}
				}
			} elseif ($format == 'icon+text') {
				if($instance['facebook'] != "") { 
					$output .= '<li class="social-facebook"><a href="'.esc_url($instance['facebook']).'" target="_blank" title="'.__( 'Facebook', 'palamut').'"><i class="fa fa-facebook"></i><span>'.__( 'Facebook', 'palamut').'</span></a></li>';
				}
				if($instance['twitter'] != "") { 
					$output .= '<li class="social-twitter"><a href="'.esc_url($instance['twitter']).'" target="_blank" title="'.__( 'Twitter', 'palamut').'"><i class="fa fa-twitter"></i><span>'.__( 'Twitter', 'palamut').'</span></a></li>';
				} 	 
				if($instance['instagram'] != '') { 
					$output .= '<li class="social-instagram"><a href="'.esc_url($instance['instagram']).'" target="_blank" title="'.__( 'Instagram', 'palamut').'"><i class="fa fa-instagram"></i><span>'.__( 'Instagram', 'palamut').'</span></a></li>';
				}
				if($instance['bloglovin'] != "") { 
					$output .= '<li class="social-bloglovin"><a href="'.esc_url($instance['bloglovin']).'" target="_blank" title="'.__( 'Bloglovin', 'palamut').'"><i class="fa fa-plus"></i><span>'.__( 'Bloglovin', 'palamut').'</span></a></li>';
				}
				if($instance['pinterest'] != "") { 
					$output .= '<li class="social-pinterest"><a href="'.esc_url($instance['pinterest']).'" target="_blank" title="'.__( 'Pinterest', 'palamut').'"><i class="fa fa-pinterest-p"></i><span>'.__( 'Pinterest', 'palamut').'</span></a></li>';
				}
				if($instance['googleplus'] != "") { 
					$output .= '<li class="social-googleplus"><a href="'.esc_url($instance['googleplus']).'" target="_blank" title="'.__( 'Google plus', 'palamut').'"><i class="fa fa-google-plus"></i><span>'.__( 'Google plus', 'palamut').'</span></a></li>';
				}
				if($instance['forrst'] != "") { 
					$output .= '<li class="social-forrst"><a href="'.esc_url($instance['forrst']).'" target="_blank" title="'.__( 'Forrst', 'palamut').'"><i class="fa icon-forrst"></i><span>'.__( 'Forrst', 'palamut').'</span></a></li>';
				}
				if($instance['dribbble'] != "") { 
					$output .= '<li class="social-dribbble"><a href="'.esc_url($instance['dribbble']).'" target="_blank" title="'.__( 'Dribbble', 'palamut').'"><i class="fa fa-dribbble"></i><span>'.__( 'Dribbble', 'palamut').'</span></a></li>';
				}
				if($instance['flickr'] != "") { 
					$output .= '<li class="social-flickr"><a href="'.esc_url($instance['flickr']).'" target="_blank" title="'.__( 'Flickr', 'palamut').'"><i class="fa fa-flickr"></i><span>'.__( 'Flickr', 'palamut').'</span></a></li>';
				}
				if($instance['linkedin'] != "") { 
					$output .= '<li class="social-linkedin"><a href="'.esc_url($instance['linkedin']).'" target="_blank" title="'.__( 'LinkedIn', 'palamut').'"><i class="fa fa-linkedin"></i><span>'.__( 'LinkedIn', 'palamut').'</span></a></li>';
				}
				if($instance['skype'] != "") { 
					$output .= '<li class="social-skype"><a href="skype:'.esc_attr($instance['skype']).'" title="'.__( 'Skype', 'palamut').'"><i class="fa fa-skype"></i><span>'.__( 'Skype', 'palamut').'</span></a></li>';
				}
				if($instance['digg'] != "") { 
					$output .= '<li class="social-digg"><a href="'.esc_url($instance['digg']).'" target="_blank" title="'.__( 'Digg', 'palamut').'"><i class="fa fa-digg"></i><span>'.__( 'Digg', 'palamut').'</span></a></li>';
				}
				if($instance['vimeo'] != "") { 
					$output .= '<li class="social-vimeo"><a href="'.esc_url($instance['vimeo']).'" target="_blank" title="'.__( 'Vimeo', 'palamut').'"><i class="fa fa-vimeo"></i><span>'.__( 'Vimeo', 'palamut').'</span></a></li>';
				}
				if($instance['yahoo'] != "") { 
					$output .= '<li class="social-yahoo"><a href="'.esc_url($instance['yahoo']).'" target="_blank" title="'.__( 'Yahoo', 'palamut').'"><i class="fa fa-yahoo"></i><span>'.__( 'Yahoo', 'palamut').'</span></a></li>';
				}
				if($instance['tumblr'] != "") { 
					$output .= '<li class="social-tumblr"><a href="'.esc_url($instance['tumblr']).'" target="_blank" title="'.__( 'Tumblr', 'palamut').'"><i class="fa fa-tumblr"></i><span>'.__( 'Tumblr', 'palamut').'</span></a></li>';
				}
				if($instance['youtube'] != "") { 
					$output .= '<li class="social-youtube"><a href="'.esc_url($instance['youtube']).'" target="_blank" title="'.__( 'YouTube', 'palamut').'"><i class="fa fa-youtube"></i><span>'.__( 'YouTube', 'palamut').'</span></a></li>';
				}
				if($instance['deviantart'] != "") { 
					$output .= '<li class="social-deviantart"><a href="'.esc_url($instance['deviantart']).'" target="_blank" title="'.__( 'DeviantArt', 'palamut').'"><i class="fa fa-deviantart"></i><span>'.__( 'DeviantArt', 'palamut').'</span></a></li>';
				}
				if($instance['behance'] != "") { 
					$output .= '<li class="social-behance"><a href="'.esc_url($instance['behance']).'" target="_blank" title="'.__( 'Behance', 'palamut').'"><i class="fa fa-behance"></i><span>'.__( 'Behance', 'palamut').'</span></a></li>';
				}
				if($instance['delicious'] != "") { 
					$output .= '<li class="social-delicious"><a href="'.esc_url($instance['delicious']).'" target="_blank" title="'.__( 'Delicious', 'palamut').'"><i class="fa fa-delicious"></i><span>'.__( 'Delicious', 'palamut').'</span></a></li>';
				}
				$extra_icons = palamut_get_custom_social_icon();
				if( !empty($extra_icons) ){
					foreach ($extra_icons as $icon) {
						$name = str_replace(' ', '', $icon['name']);
						$output .= '<li class="social-'.esc_attr(strtolower($name)).'"><a href="'.esc_url($icon['url']).'" target="_blank" title="'.esc_attr(ucfirst($icon['name'])).'"><i class="'.esc_attr($icon['icon']).'"></i><span>'.esc_html(ucfirst($icon['name'])).'</span></a></li>';
					}
				}
			} else {
				if($instance['facebook'] != "") { 
					$output .= '<li class="social-facebook"><a href="'.esc_url($instance['facebook']).'" target="_blank" title="'.__( 'Facebook', 'palamut').'"><i class="fa fa-facebook"></i></a></li>';
				}
				if($instance['twitter'] != "") { 
					$output .= '<li class="social-twitter"><a href="'.esc_url($instance['twitter']).'" target="_blank" title="'.__( 'Twitter', 'palamut').'"><i class="fa fa-twitter"></i></a></li>';
				} 	 
				if($instance['instagram'] != '') { 
					$output .= '<li class="social-instagram"><a href="'.esc_url($instance['instagram']).'" target="_blank" title="'.__( 'Instagram', 'palamut').'"><i class="fa fa-instagram"></i></a></li>';
				}
				if($instance['bloglovin'] != "") { 
					$output .= '<li class="social-bloglovin"><a href="'.esc_url($instance['bloglovin']).'" target="_blank" title="'.__( 'Bloglovin', 'palamut').'"><i class="fa fa-plus"></i></a></li>';
				}
				if($instance['pinterest'] != "") { 
					$output .= '<li class="social-pinterest"><a href="'.esc_url($instance['pinterest']).'" target="_blank" title="'.__( 'Pinterest', 'palamut').'"><i class="fa fa-pinterest-p"></i></a></li>';
				}
				if($instance['googleplus'] != "") { 
					$output .= '<li class="social-googleplus"><a href="'.esc_url($instance['googleplus']).'" target="_blank" title="'.__( 'Google plus', 'palamut').'"><i class="fa fa-google-plus"></i></a></li>';
				}
				if($instance['forrst'] != "") { 
					$output .= '<li class="social-forrst"><a href="'.esc_url($instance['forrst']).'" target="_blank" title="'.__( 'Forrst', 'palamut').'"><i class="fa icon-forrst"></i></a></li>';
				}
				if($instance['dribbble'] != "") { 
					$output .= '<li class="social-dribbble"><a href="'.esc_url($instance['dribbble']).'" target="_blank" title="'.__( 'Dribbble', 'palamut').'"><i class="fa fa-dribbble"></i></a></li>';
				}
				if($instance['flickr'] != "") { 
					$output .= '<li class="social-flickr"><a href="'.esc_url($instance['flickr']).'" target="_blank" title="'.__( 'Flickr', 'palamut').'"><i class="fa fa-flickr"></i></a></li>';
				}
				if($instance['linkedin'] != "") { 
					$output .= '<li class="social-linkedin"><a href="'.esc_url($instance['linkedin']).'" target="_blank" title="'.__( 'LinkedIn', 'palamut').'"><i class="fa fa-linkedin"></i></a></li>';
				}
				if($instance['skype'] != "") { 
					$output .= '<li class="social-skype"><a href="skype:'.esc_attr($instance['skype']).'" title="'.__( 'Skype', 'palamut').'"><i class="fa fa-skype"></i></a></li>';
				}
				if($instance['digg'] != "") { 
					$output .= '<li class="social-digg"><a href="'.esc_url($instance['digg']).'" target="_blank" title="'.__( 'Digg', 'palamut').'"><i class="fa fa-digg"></i></a></li>';
				}
				if($instance['vimeo'] != "") { 
					$output .= '<li class="social-vimeo"><a href="'.esc_url($instance['vimeo']).'" target="_blank" title="'.__( 'Vimeo', 'palamut').'"><i class="fa fa-vimeo"></i></a></li>';
				}
				if($instance['yahoo'] != "") { 
					$output .= '<li class="social-yahoo"><a href="'.esc_url($instance['yahoo']).'" target="_blank" title="'.__( 'Yahoo', 'palamut').'"><i class="fa fa-yahoo"></i></a></li>';
				}
				if($instance['tumblr'] != "") { 
					$output .= '<li class="social-tumblr"><a href="'.esc_url($instance['tumblr']).'" target="_blank" title="'.__( 'Tumblr', 'palamut').'"><i class="fa fa-tumblr"></i></a></li>';
				}
				if($instance['youtube'] != "") { 
					$output .= '<li class="social-youtube"><a href="'.esc_url($instance['youtube']).'" target="_blank" title="'.__( 'YouTube', 'palamut').'"><i class="fa fa-youtube"></i></a></li>';
				}
				if($instance['deviantart'] != "") { 
					$output .= '<li class="social-deviantart"><a href="'.esc_url($instance['deviantart']).'" target="_blank" title="'.__( 'DeviantArt', 'palamut').'"><i class="fa fa-deviantart"></i></a></li>';
				}
				if($instance['behance'] != "") { 
					$output .= '<li class="social-behance"><a href="'.esc_url($instance['behance']).'" target="_blank" title="'.__( 'Behance', 'palamut').'"><i class="fa fa-behance"></i></a></li>';
				}
				if($instance['delicious'] != "") { 
					$output .= '<li class="social-delicious"><a href="'.esc_url($instance['delicious']).'" target="_blank" title="'.__( 'Delicious', 'palamut').'"><i class="fa fa-delicious"></i></a></li>';
				}
				$extra_icons = palamut_get_custom_social_icon();
				if( !empty($extra_icons) ){
					foreach ($extra_icons as $icon) {
						$name = str_replace(' ', '', $icon['name']);
						$output .= '<li class="social-'.esc_attr(strtolower($name)).'"><a href="'.esc_url($icon['url']).'" target="_blank" title="'.esc_attr(ucfirst($icon['name'])).'"><i class="'.esc_attr($icon['icon']).'"></i></a></li>';
					}
				}
			}
			echo ''.$output;
			?>
			</ul>
		</div>
		<?php
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = $new_instance['title'];
		$instance['socials_style'] = $new_instance['socials_style'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['twitter'] = $new_instance['twitter'];
		$instance['bloglovin'] = $new_instance['bloglovin'];
		$instance['pinterest'] = $new_instance['pinterest'];
		$instance['instagram'] = $new_instance['instagram'];
		$instance['googleplus'] = $new_instance['googleplus'];
		$instance['forrst'] = $new_instance['forrst'];
		$instance['dribbble'] = $new_instance['dribbble'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['linkedin'] = $new_instance['linkedin'];
		$instance['skype'] = $new_instance['skype'];
		$instance['digg'] = $new_instance['digg'];
		$instance['vimeo'] = $new_instance['vimeo'];
		$instance['yahoo'] = $new_instance['yahoo'];
		$instance['tumblr'] = $new_instance['tumblr'];
		$instance['youtube'] = $new_instance['youtube'];
		$instance['deviantart'] = $new_instance['deviantart'];
		$instance['behance'] = $new_instance['behance'];
		$instance['vk'] = $new_instance['vk'];
		$instance['delicious'] = $new_instance['delicious'];

		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'socials_style' => 'icons', 
			'facebook'=> '#', 
			'twitter'=>'#',
			'bloglovin'=>'', 
			'pinterest'=>'#', 
			'instagram'=>'#', 
			'googleplus'=>'', 
			'forrst'=>'', 
			'dribbble'=>'', 
			'flickr'=>'', 
			'linkedin'=>'', 
			'skype'=>'', 
			'digg'=>'', 
			'vimeo'=>'', 
			'yahoo'=>'', 
			'tumblr'=>'#', 
			'youtube'=>'', 
			'deviantart'=>'',
			'behance'=>'',
			'vk'=>'',
			'delicious'=>''
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
		<?php 
			$selected1 = $selected2 = $selected3 = '';

			if(isset($instance['socials_style'])){
				switch ($instance['socials_style']) {
					case '1':
						$selected1 = 'selected="selected"';
						break;
					case '2':
						$selected2 = 'selected="selected"';
						break;
					case '3':
						$selected3 = 'selected="selected"';
						break;
				}
			} ?>
			<label for="<?php echo esc_attr($this->get_field_id( 'socials_style' )); ?>">Display items as:</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'socials_style' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'socials_style' )); ?>">
				<option value="text" <?php echo esc_attr($selected1); ?>>Text</option>
				<option value="icon+text" <?php echo esc_attr($selected2); ?>>Icon+Text</option>
				<option value="icons" <?php echo esc_attr($selected2); ?>>Icons</option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php _e('Facebook url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" value="<?php echo esc_attr($instance['facebook']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php _e('Twitter url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" value="<?php echo esc_attr($instance['twitter']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('bloglovin')); ?>"><?php _e('Bloglovin profile url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('bloglovin')); ?>" name="<?php echo esc_attr($this->get_field_name('bloglovin')); ?>" value="<?php echo esc_attr($instance['bloglovin']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php _e('Pinterest url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" value="<?php echo esc_attr($instance['pinterest']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php _e('Instagram url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" value="<?php echo esc_attr($instance['instagram']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('googleplus')); ?>"><?php _e('Google plus url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('googleplus')); ?>" name="<?php echo esc_attr($this->get_field_name('googleplus')); ?>" value="<?php echo esc_attr($instance['googleplus']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('forrst')); ?>"><?php _e('Forrst url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('forrst')); ?>" name="<?php echo esc_attr($this->get_field_name('forrst')); ?>" value="<?php echo esc_attr($instance['forrst']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('dribbble')); ?>"><?php _e('Dribbble url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('dribbble')); ?>" name="<?php echo esc_attr($this->get_field_name('dribbble')); ?>" value="<?php echo esc_attr($instance['dribbble']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('flickr')); ?>"><?php _e('Flickr url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr')); ?>" value="<?php echo esc_attr($instance['flickr']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php _e('Linkedin url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" value="<?php echo esc_attr($instance['linkedin']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('skype')); ?>"><?php _e('Skype account:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('skype')); ?>" name="<?php echo esc_attr($this->get_field_name('skype')); ?>" value="<?php echo esc_attr($instance['skype']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('digg')); ?>"><?php _e('Digg url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('digg')); ?>" name="<?php echo esc_attr($this->get_field_name('digg')); ?>" value="<?php echo esc_attr($instance['digg']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('vimeo')); ?>"><?php _e('Vimeo url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('vimeo')); ?>" name="<?php echo esc_attr($this->get_field_name('vimeo')); ?>" value="<?php echo esc_attr($instance['vimeo']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('yahoo')); ?>"><?php _e('Yahoo url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('yahoo')); ?>" name="<?php echo esc_attr($this->get_field_name('yahoo')); ?>" value="<?php echo esc_attr($instance['yahoo']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tumblr')); ?>"><?php _e('Tumblr url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('tumblr')); ?>" name="<?php echo esc_attr($this->get_field_name('tumblr')); ?>" value="<?php echo esc_attr($instance['tumblr']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>"><?php _e('Youtube url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" value="<?php echo esc_attr($instance['youtube']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('deviantart')); ?>"><?php _e('Deviantart url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('deviantart')); ?>" name="<?php echo esc_attr($this->get_field_name('deviantart')); ?>" value="<?php echo esc_attr($instance['deviantart']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('behance')); ?>"><?php _e('Behance url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('behance')); ?>" name="<?php echo esc_attr($this->get_field_name('behance')); ?>" value="<?php echo esc_attr($instance['behance']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('vk')); ?>"><?php _e('VKontakte url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('vk')); ?>" name="<?php echo esc_attr($this->get_field_name('vk')); ?>" value="<?php echo esc_attr($instance['vk']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('delicious')); ?>"><?php _e('Delicious url:','palamut'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('delicious')); ?>" name="<?php echo esc_attr($this->get_field_name('delicious')); ?>" value="<?php echo esc_attr($instance['delicious']); ?>" />
		</p>
    <?php }
}

// Add Widget
function palamut_widget_socials_init() {
	register_widget('palamut_widget_socials');
}
add_action('widgets_init', 'palamut_widget_socials_init');

?>
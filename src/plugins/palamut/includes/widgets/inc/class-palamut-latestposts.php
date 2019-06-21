<?php
add_action('widgets_init','register_palamut_grid_post_posts_widget');
function register_palamut_grid_post_posts_widget(){
    register_widget('palamut_grid_posts_widget');
}

class palamut_grid_posts_widget extends WP_Widget{

    function __construct(){
        parent::__construct( 'palamut_grid_posts_widget','palamut-Mega Menu Posts',array('description' => 'Grid Posts widget to display in WP Mega Menu. Do not use it in your sidebar.'));
    }

    /*-------------------------------------------------------
     *				Front-end display of widget
     *-------------------------------------------------------*/
    function widget($args, $instance)
    {
        extract($args);
        $title = null;

        if ( ! empty($instance['title'])){
            $title = apply_filters('widget_title', $instance['title'] );
        }

        if ( ! empty($instance['count']) ) {
            $count 	= $instance['count'];
        } else {
            $count 	= 4;
        }
        if ( ! empty($instance['no_column']) ) {
            $no_column 	= $instance['no_column'];
        } else {
            $no_column 	= 'col4';
        }

        echo $args['before_widget'];

        $output = '';

        if ( $title )
            echo $args['before_title'] . esc_attr($title) . $args['after_title'];

        global $post;

        if ( ! empty( $instance['order_by']) && $instance['order_by'] == 'popular') {
            $args = array(
                'posts_per_page' 	=> esc_attr($count),
                'meta_key' 			=> 'wpmm_postgrid_views',
                'orderby' 			=> 'meta_value_num',
                'post_status' 		=> 'publish',
                'order' 			=> 'DESC',
                'ignore_sticky_posts' => true
            );
        } else {
            $args = array(
                'posts_per_page' 	=> esc_attr($count),
                'post_status' 		=> 'publish',
                'order' 			=> 'DESC',
                'paged' 			=> 1,
                'ignore_sticky_posts' => true
            );
        }

        if( ! empty($instance['show_cat']) && $instance['show_cat'] == 'on' ){

            if( !empty($instance['category']) ){
                $output .='<div class="wpmm-vertical-tabs">';
                $output .='<div class="wpmm-vertical-tabs-nav">';
                $output .='<ul class="wpmm-tab-btns">';
                $i = 1;
                foreach ( $instance['category'] as $value ) {
                    $catName = __('All','palamut-elements');
                    if( $value != 'allpost' ){
                        $catObj = get_category_by_slug( $value );
                        $catName = $catObj->name;
                        $catLink = get_category_link($catObj->term_id);
                    }
                    if( $i==1 ){
                        $output .='<li class="active"><a href="'.get_permalink( get_option( 'page_for_posts' ) ).'">'.$catName.'</a></li>';
                    }else{
                        $output .='<li class=""><a href="'.$catLink.'">'.$catName.'</a></li>';
                    }
                    $i++;
                }
                $output .='</ul>';
                $output .='</div>';
                $output .='<div class="wpmm-vertical-tabs-content">';
                $output .='<div class="wpmm-tab-content">';
                $i = 1;
                foreach ( $instance['category'] as $value ) {
                    if( $value ){
                        $cat_data = array();
                        $cat_data['relation'] = 'AND';
                        if( 'allpost' != $value ){
                            $cat_data[] = array(
                                'taxonomy' 	=> 'category',
                                'field' 	=> 'slug',
                                'terms' 	=> $value
                            );
                        }
                        $args['tax_query'] = $cat_data;
                    }
                    $data = new WP_Query( $args );
                    $output .='<div class="wpmm-tab-pane '.(($i==1)?"active":"").'">';
                    if( $data->have_posts()){

                        $output .='<div class="wpmm-grid-post-addons wpmm-grid-post-row">';
                        while ( $data->have_posts() ) {
                            $data->the_post();
                            $output .='<div class="wpmm-grid-post '.esc_attr($no_column).'">';
                            $output .='<div class="wpmm-grid-post-content">';

                            if ( has_post_thumbnail() ) {
                                $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
                                $image ='style="background: url('.esc_url($img[0]).') no-repeat;background-size: cover;"';

                            }else {
                                $image ='style="background: #333;"';
                            }

                            $output .='<div class="wpmm-grid-post-img-wrap">';

	                        if (has_post_thumbnail(get_the_ID())){
		                        $output .='<a href="'.get_permalink(get_the_ID()).'">';
		                        $output .='<div class="wpmm-grid-post-img" '.$image.'>';
		                        $output .= '</div>';
		                        $output .= '</a>';
	                        }
                            $output .= '</div>';//wpmm-grid-post-img-wrap
                            $output .= '<h4 class="grid-post-title"><a href="'.get_permalink().'">'. get_the_title() .'</a></h4>';
                            if( $instance['show_date'] == 'on' ){
                                $output .= '<div class="meta-date">'.get_the_date().'</div>';
                            }
                            $output .= '</div>'; //.wpmm-grid-post-content
                            $output .= '</div>'; //.wpmm-grid-post
                        }
                        wp_reset_postdata();
                        $output .= '</div>'; //wpmm-grid-post-addons

                        if( $instance['show_nav'] == 'on' ){
                            $output .= '<span data-showcat="'.$instance['show_date'].'" data-type="post" data-category="'.$value.'" data-current="1" ata-oderby="'.$instance["order_by"].'" data-oderby="'.$instance["order_by"].'" data-column="'.$no_column.'"  data-total="'.$data->max_num_pages.'" class="dashicons dashicons-arrow-left-alt2 wpmm-left wpmm-gridcontrol-left disablebtn"></span>';
                            $var = ($data->max_num_pages == 1)? 'disablebtn' : '';
                            $output .= '<span data-showcat="'.$instance['show_date'].'" data-type="post" data-category="'.$value.'"  data-current="1" data-oderby="'.$instance["order_by"].'" data-column="'.$no_column.'"  data-total="'.$data->max_num_pages.'" class="dashicons dashicons-arrow-right-alt2 wpmm-right wpmm-gridcontrol-right '.$var.'"></span>';
                        }
                    }
                    $output .='</div>';
                    $i++;
                }


                $output .='</div>';
                $output .='</div>';
                $output .='</div>';
            }

        } else {
            if( ! empty($instance['category']) ){
                $cat_data = array();
                $cat_data['relation'] = 'AND';
                if( !in_array( 'allpost', $instance['category'] ) ){
                    $cat_data[] = array(
                        'taxonomy' 	=> 'category',
                        'field' 	=> 'slug',
                        'terms' 	=> $instance['category']
                    );
                }
                $args['tax_query'] = $cat_data;
            }
            $data = new WP_Query( $args );

            if( $data->have_posts()){
                $output .='<div class="wpmm-grid-post-addons wpmm-grid-post-row">';
                while ( $data->have_posts() ) {
                    $data->the_post();
                    $output .='<div class="wpmm-grid-post '.esc_attr($no_column).'">';
                    $output .='<div class="wpmm-grid-post-content">';

                    if ( has_post_thumbnail() ) {
                        $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large-thumb' );
                        $image ='style="background: url('.esc_url($img[0]).') no-repeat;background-size: cover;"';

                    }else {
                        $image ='style="background: #333;"';
                    }

                    $output .='<div class="wpmm-grid-post-img-wrap">';

                    if (has_post_thumbnail(get_the_ID())){
		                $output .='<a href="'.get_permalink(get_the_ID()).'">';
		                $output .='<div class="wpmm-grid-post-img" '.$image.'>';
		                $output .= '</div>';
		                $output .= '</a>';
	                }
                    $output .= '</div>';//wpmm-grid-post-img-wrap

                    $output .= '<h4 class="grid-post-title"><a href="'.get_permalink().'">'. get_the_title() .'</a></h4>';
                    if( ! empty($instance['show_date'] ) && $instance['show_date'] == 'on' ){
                        $output .= '<div class="meta-date">'.get_the_date().'</div>';
                    }
                    $output .= '</div>'; //.wpmm-grid-post-content
                    $output .= '</div>'; //.wpmm-grid-post
                }
                wp_reset_postdata();
                $output .= '</div>'; //wpmm-grid-post-addons

                if( ! empty($instance['show_nav']) && $instance['show_nav'] == 'on' ){
                    $data_category = '';
                    if ( ! empty($instance['category'])){
                        $data_category = implode(',',$instance['category']);
                    }
                    $output .= '<span data-showcat="'.$instance['show_date'].'" data-type="post" data-category="'.$data_category.'" data-current="1" ata-oderby="'.$instance["order_by"].'" data-oderby="'.$instance["order_by"].'" data-column="'.$no_column.'"  data-total="'.$data->max_num_pages.'" class="dashicons dashicons-arrow-left-alt2 wpmm-left wpmm-gridcontrol-left disablebtn"></span>';
                    $var = ($data->max_num_pages == 1)? 'disablebtn' : '';
                    $output .= '<span data-showcat="'.$instance['show_date'].'" data-type="post" data-category="'.$data_category.'"  data-current="1" data-oderby="'.$instance["order_by"].'" data-column="'.$no_column.'"  data-total="'.$data->max_num_pages.'" class="dashicons dashicons-arrow-right-alt2 wpmm-right wpmm-gridcontrol-right '.$var.'"></span>';
                }
            }
        }

        echo $output;
        echo ! empty($args['after_widget']) ? $args['after_widget'] : '';
    }

    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;

        $instance['title'] 			= strip_tags( $new_instance['title'] );
        $instance['no_column'] 		= strip_tags( $new_instance['no_column'] );
        $instance['order_by'] 		= strip_tags( $new_instance['order_by'] );
        $instance['count'] 			= strip_tags( $new_instance['count'] );
        $instance['category'] 		=  $new_instance['category'];
        $instance['show_cat'] 		= strip_tags( $new_instance['show_cat'] );
        $instance['show_nav'] 		= strip_tags( $new_instance['show_nav'] );
        $instance['show_date'] 	= strip_tags( $new_instance['show_date'] );

        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            'title' 		=> 'Latest Posts',
            'no_column' 	=> 'col4',
            'order_by' 		=> 'latest',
            'count' 		=> 4,
            'category'		=> 'allpost',
            'show_cat'		=> false,
            'show_nav'		=> false,
            'show_date'	=> true
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Widget Title', 'palamut-elements'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php esc_html_e('Ordered By', 'palamut-elements'); ?></label>
            <?php
            $options = array(
                'popular' 	=> 'Popular',
                'latest' 	=> 'Latest',
            );
            if(isset($instance['order_by'])) $order_by = $instance['order_by'];
            ?>
            <select class="widefat" id="<?php echo $this->get_field_id( 'order_by' ); ?>" name="<?php echo $this->get_field_name( 'order_by' ); ?>">
                <?php
                $op = '<option value="%s"%s>%s</option>';
                foreach ($options as $key=>$value ) {
                    if ($order_by === $key) {
                        printf($op, $key, ' selected="selected"', $value);
                    } else {
                        printf($op, $key, '', $value);
                    }
                }
                ?>
            </select>
        </p>


        <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e('Select Category', 'palamut-elements'); ?></label>
            <?php
            $options = array();
            $options['allpost'] = 'All';
            $query1 = get_terms( 'category' );
            if( $query1 ){
                foreach ( $query1 as $post ) {
                    $options[ $post->slug ] = $post->name;
                }
            }
            if(!empty($instance['category'])){
                $category = $instance['category'];
            } else {
                $category = array( 'allpost' );
            }
            ?>
            <select multiple class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>[]">
                <?php
                $op = '<option value="%s"%s>%s</option>';
                foreach ($options as $key=>$value ) {
                    if (in_array($key,$category)) {
                        printf($op, $key, ' selected="selected"', $value);
                    } else {
                        printf($op, $key, '', $value);
                    }
                }
                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'no_column' ); ?>"><?php esc_html_e('Number of Column', 'palamut-elements'); ?></label>
            <?php
            $options = array(
                'col1' 	=> 'Column 1',
                'col2' 	=> 'Column 2',
                'col3'	=> 'Column 3',
                'col4'	=> 'Column 4',
                'col5'	=> 'Column 5',
            );
            if(isset($instance['no_column'])) $no_column = $instance['no_column'];
            ?>
            <select class="widefat" id="<?php echo $this->get_field_id( 'no_column' ); ?>" name="<?php echo $this->get_field_name( 'no_column' ); ?>">
                <?php
                $op = '<option value="%s"%s>%s</option>';

                foreach ($options as $key=>$value ) {
                    if ($no_column === $key) {
                        printf($op, $key, ' selected="selected"', $value);
                    } else {
                        printf($op, $key, '', $value);
                    }
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php esc_html_e('Post Count', 'palamut-elements'); ?></label>
            <input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:100%;" />
        </p>

        <?php $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false; ?>
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show Date on the Post?' ); ?></label>
        </p>

        <?php $show_nav = isset( $instance['show_nav'] ) ? (bool) $instance['show_nav'] : false; ?>
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $show_nav ); ?> id="<?php echo $this->get_field_id( 'show_nav' ); ?>" name="<?php echo $this->get_field_name( 'show_nav' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_nav' ); ?>"><?php _e( 'Show Navigation on the Post?' ); ?></label>
        </p>

        <?php $show_cat = isset( $instance['show_cat'] ) ? (bool) $instance['show_cat'] : false; ?>
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $show_cat ); ?> id="<?php echo $this->get_field_id( 'show_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_cat' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_cat' ); ?>"><?php _e( 'Show Left Category on the Widget?' ); ?></label>
        </p>

        <?php
    }
}
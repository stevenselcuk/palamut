<?php
/**
 * { Document title }
 *
 * { Document descriptions will be add. }
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
 * [palamut_featured_post_widget_init description]
 *
 * @method palamut_featured_post_widget_init
 *
 * @since
 *
 * @link
 *
 * @return [type]                            [description]
 */
function palamut_featured_post_widget_init() {
	register_widget( 'Palamut_Featured_Post_Widget' );
}

add_action( 'widgets_init', 'palamut_featured_post_widget_init' );

/**
 * [Palamut_Featured_Post_Widget description]
 */
class Palamut_Featured_Post_Widget extends WP_Widget {

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
			'palamut-featured-post',
			__( 'Palamut widgets: Featured Post', 'palamut' ),
			array(
				'classname'                   => 'palamut-featured-post',
				'description'                 => esc_html__( 'Display a your featured post', 'palamut' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	function widget( $args, $instance ) {

		// Our variables from the widget settings.
		extract( $args );

		$promote_post_id    = $instance['promote_post_id'];
		$promote_image_size = ! empty( $instance['promote_image_size'] ) ? $instance['promote_image_size'] : 'landscape';

		echo $before_widget; // XSS OK

		// Display the widget title
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // XSS OK
		}

		if ( strpos( $promote_post_id, ',' ) === false ) {
			$promote_post_id = array( $promote_post_id );
		} else {
			$promote_post_id = explode( ',', $promote_post_id );
		}

		$args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'post__in'       => $promote_post_id,
			'paged'          => 1,
			'posts_per_page' => 1,
		);
		// Loop posts
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :

			$image_size = palamut_grve_get_image_size( $promote_image_size );

			$palamut_grve_empty_image_url = get_template_directory_uri() . '/images/transparent/' . $image_size . '.png';

			while ( $query->have_posts() ) :
				$query->the_post();

				$palamut_grve_link   = get_permalink();
				$palamut_grve_target = '_self';

				if ( 'link' == get_post_format() ) {
					$palamut_grve_link = get_post_meta( get_the_ID(), '_palamut_grve_post_link_url', true );
					$new_window       = get_post_meta( get_the_ID(), '_palamut_grve_post_link_new_window', true );
					if ( empty( $palamut_grve_link ) ) {
						$palamut_grve_link = get_permalink();
					}

					if ( ! empty( $new_window ) ) {
						$palamut_grve_target = '_blank';
					}
				}

				?>
			<a href="<?php echo esc_url( $palamut_grve_link ); ?>" target="<?php echo esc_attr( $palamut_grve_target ); ?>" title="<?php the_title_attribute(); ?>">
				<div class="grve-media grve-image-hover grve-gradient-overlay">
					<?php if ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail( $image_size ); ?>
					<?php } else { ?>
						<img width="80" height="80" src="<?php echo esc_url( $palamut_grve_empty_image_url ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
					<?php } ?>
					<div class="grve-promote-content">
						<div class="grve-promote-date grve-small-text"><?php echo esc_html( get_the_date() ); ?></div>
						<div class="grve-title grve-link-text"><?php the_title(); ?></div>
					</div>
					<div class="grve-post-meta-wrapper">
						<ul class="grve-post-meta">
							<li class="grve-small-text grve-post-author"><i class="grve-icon-user"></i>
								<span><?php echo get_the_author(); ?></span>
							</li>
							<li class="grve-small-text grve-post-comments"><i class="grve-icon-comment"></i>
								<span><?php comments_number( '0', '1', '%' ); ?></span>
							</li>
						</ul>
					</div>
				</div>
			</a>

				<?php
		endwhile;
		else :
		endif;

		wp_reset_postdata();

		echo $after_widget; // XSS OK
	}

	// Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags from title and name to remove HTML
		$instance['title']              = strip_tags( $new_instance['title'] );
		$instance['promote_post_id']    = strip_tags( $new_instance['promote_post_id'] );
		$instance['promote_image_size'] = strip_tags( $new_instance['promote_image_size'] );

		return $instance;
	}


	function form( $instance ) {

		// Set up some default widget settings.
		$defaults = array(
			'title'              => '',
			'promote_post_id'    => '',
			'promote_image_size' => 'landscape',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>


		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'palamut' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'promote_post_id' ) ); ?>"><?php echo esc_html__( 'Post ID:', 'palamut' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'promote_post_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'promote_post_id' ) ); ?>" value="<?php echo esc_attr( $instance['promote_post_id'] ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'promote_image_size' ) ); ?>"><?php echo esc_html__( 'Image Size:', 'palamut' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'promote_image_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'promote_image_size' ) ); ?>" style="width:100%;">
				<option value="landscape" <?php selected( 'landscape', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Landscape Small Crop', 'palamut' ); ?></option>
				<option value="portrait" <?php selected( 'portrait', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Portrait Small Crop', 'palamut' ); ?></option>
				<option value="square" <?php selected( 'square', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Square Small Crop', 'palamut' ); ?></option>
				<option value="large" <?php selected( 'large', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Resize ( Large )', 'palamut' ); ?></option>
				<option value="medium_large" <?php selected( 'medium_large', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Resize ( Medium Large )', 'palamut' ); ?></option>
				<option value="medium" <?php selected( 'medium', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Resize ( Medium )', 'palamut' ); ?></option>
			</select>
		</p>

		<?php
	}
}

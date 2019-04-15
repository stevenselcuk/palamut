<?php
/**
 * Facebook Page Box Widget
 *
 * This widget displays Facebook Page Like & Feed Box
 *
 * @link to be defined
 *
 * @package pdwname
 *
 * @subpackage Theme Features
 * @category Widgets
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
 * [palamut_facebook_widgets description]
 *
 * @method palamut_facebook_widgets
 *
 * @since
 *
 * @link
 */
function palamut_facebook_widgets_init() {
	register_widget( 'Palamut_Facebook_Widget' );
}

add_action( 'widgets_init', 'palamut_facebook_widgets_init' );

/**
 * [palamut_Facebook_Widget description]
 */
class Palamut_Facebook_Widget extends WP_Widget {

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
			'palamut-facebook-box',
			__( 'Palamut widgets: Facebook', 'palamut' ),
			array(
				'classname'                   => 'palamut-facebook-box',
				'description'                 => esc_html__( 'Displays your Facebook Page Box', 'palamut' ),
				'customize_selective_refresh' => true,
			)
		);
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
		extract( $args );

		$title        = apply_filters( 'widget_title', $instance['title'] );
		$page_url     = $instance['page_url'];
		$width        = $instance['width'];
		$color_scheme = $instance['color_scheme'];
		$show_faces   = isset( $instance['show_faces'] ) ? 'true' : 'false';
		$show_stream  = isset( $instance['show_stream'] ) ? 'true' : 'false';
		$show_header  = isset( $instance['show_header'] ) ? 'true' : 'false';
		$height       = '65';

		if ( 'true' === $show_faces ) {
			$height = '250';
		}

		if ( 'true' === $show_stream ) {
			$height = '600';
		}

		if ( 'true' === $show_header ) {
			$height = '600';
		}

		echo wp_kses( $before_widget, allowed_html() );
		?>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<div class="facebook-page-box">
		<?php
		if ( ! empty( $title ) ) {
			echo wp_kses( $before_title . $title . $after_title, allowed_html() );
		};

		if ( $page_url ) :
			?>

		<div class="fb-page"
			data-href="<?php echo esc_url( $page_url ); ?>"
			data-hide-cover="<?php echo esc_attr( $show_header ); ?>"
			data-show-facepile="<?php echo esc_attr( $show_faces ); ?>"
			data-show-posts="<?php echo esc_attr( $show_stream ); ?>"
			data-width="<?php echo esc_attr( $width ); ?>">
			<div class="fb-xfbml-parse-ignore">
				<blockquote cite="https://www.facebook.com/facebook">
					<a href="<?php echo esc_url( $page_url ); ?>">Facebook</a>
				</blockquote>
			</div>
		</div>

			<?php endif; ?>
		</div>

		<?php
		echo wp_kses( $after_widget, allowed_html() );
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
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['page_url']     = $new_instance['page_url'];
		$instance['width']        = $new_instance['width'];
		$instance['color_scheme'] = $new_instance['color_scheme'];
		$instance['show_faces']   = $new_instance['show_faces'];
		$instance['how_stream']   = isset( $new_instance['show_stream'] ) ? $new_instance['show_stream'] : '';
		$instance['show_header']  = isset( $new_instance['show_header'] ) ? $new_instance['show_header'] : '';

		return $instance;
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
		$defaults = array(
			'title'        => 'Find us on Facebook',
			'page_url'     => '',
			'width'        => '300',
			'color_scheme' => 'light',
			'show_faces'   => 'on',
			'show_stream'  => true,
			'show_header'  => true,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>">Facebook Page URL:</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>" placeholder="https://facebook.com/yourpage" name="<?php echo esc_attr( $this->get_field_name( 'page_url' ) ); ?>" value="<?php echo esc_attr( $instance['page_url'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>">Width:</label>
			<input class="widefat" style="width: 50px;" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'color_scheme' ) ); ?>">Color Scheme:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'color_scheme' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_scheme' ) ); ?>" class="widefat" style="width:100%;">
				<option
				<?php
				if ( 'light' === $instance['color_scheme'] ) {
					echo 'selected="selected"';}
				?>
				>light</option>
				<option
				<?php
				if ( 'dark' === $instance['color_scheme'] ) {
					echo 'selected="selected"';}
				?>
				>dark</option>
			</select>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_faces'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_faces' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>">Show faces</label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_stream'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_stream' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>">Show stream</label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_header'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_header' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_header' ) ); ?>">Hide facebook header</label>
		</p>
		<?php
	}
}

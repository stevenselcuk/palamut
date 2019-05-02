<?php
/**
 * Mailchimp Subscribe Now! Box
 *
 * This widget displays a subscribing box for Mailchimp.
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

/**
 * [palamut_mailchimp_widget_init description]
 *
 * @method palamut_mailchimp_widget_init
 *
 * @since
 *
 * @link
 */
function palamut_mailchimp_widget_init() {
	register_widget( 'Palamut_Mailchimp_Widget' );
}

add_action( 'widgets_init', 'palamut_mailchimp_widget_init' );

/**
 * [Palamut_Mailchimp_Widget description]
 */
class Palamut_Mailchimp_Widget extends WP_Widget {
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
			'palamut-mailchimp-subscribe-box',
			__( 'Palamut widgets: Mailchimp Subscribe Box', 'palamut' ),
			array(
				'classname'                   => 'palamut-mailchimp-subscribe-box',
				'description'                 => esc_html__( 'This widget displays a subscribing box for Mailchimp.', 'palamut' ),
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
		$allowed_tags    = array(
			'div' => array(
				'class' => array(),
				'id'    => array(),
			),
			'h5'  => array(
				'class' => array(),
				'id'    => array(),
			),
			'h2'  => array(
				'class' => array(),
				'id'    => array(),
			),
		);
		$title           = isset( $instance['title'] ) ? $instance['title'] : '';
		$subtitle        = isset( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$placeholder_txt = isset( $instance['placeholder_txt'] ) ? $instance['placeholder_txt'] : '';
		$action_url      = isset( $instance['action_url'] ) ? $instance['action_url'] : '';

		wp_enqueue_style( 'simple-line-icons' );

		echo wp_kses( $args['before_widget'], $allowed_tags ); ?>
			<i class="icon-envelope-letter icons"></i>
			<?php
			if ( $title ) {
				echo wp_kses( $args['before_title'], $allowed_tags );
				echo esc_html( $title );
				echo wp_kses( $args['after_title'], $allowed_tags );
			}
			echo ( $subtitle ) ? '<p>' . esc_html( $subtitle ) . '</p>' : '';
			?>
			<form action="<?php echo esc_url( $action_url ); ?>" class="mailchimp" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" novalidate>
				<div class="input-group subcribes">
					<input type="email" name="EMAIL" class="form-control memail" placeholder="<?php echo esc_attr( $placeholder_txt ); ?>">
					<span class="input-group-btn">
						<button class="btn btn-submit btn-animated-none" type="submit"><i class="far fa-envelope"></i></button>
					</span>
				</div>
			</form>
		<?php echo wp_kses( $args['after_widget'], $allowed_tags ); ?>
		<?php
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

		$instance              = wp_parse_args(
			$instance,
			array(
				'title'           => 'Sign Up For Newsletter',
				'subtitle'        => 'To Receive Updates',
				'placeholder_txt' => 'Your Email. . .',
				'action_url'      => '',
			)
		);
		$title_value           = esc_attr( $instance['title'] );
		$subtitle_value        = esc_attr( $instance['subtitle'] );
		$placeholder_txt_value = esc_attr( $instance['placeholder_txt'] );
		$action_url_value      = esc_attr( $instance['action_url'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" placeholder="Get update!" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>">Subtitle:</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" placeholder="Subscribe now..." name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" value="<?php echo esc_attr( $instance['subtitle'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'placeholder_txt' ) ); ?>">Placeholder:</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr( $this->get_field_id( 'placeholder_txt' ) ); ?>" placeholder="yourmail@yourmail.com" name="<?php echo esc_attr( $this->get_field_name( 'placeholder_txt' ) ); ?>" value="<?php echo esc_attr( $instance['placeholder_txt'] ); ?>"  />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'action_url' ) ); ?>">Mailchimp Newsletter Form Action URL: (<a target="_blank" href="https://mailchimp.com/help/host-your-own-signup-forms/">See how</a>)</label>
			<input class="widefat" style="width: 100%;" id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>" placeholder="http://your-mailchimp-action-url.com" name="<?php echo esc_attr( $this->get_field_name( 'action_url' ) ); ?>" value="<?php echo esc_attr( $instance['action_url'] ); ?>" />
		</p>
		<?php
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
		$instance                    = $old_instance;
		$instance['title']           = $new_instance['title'];
		$instance['subtitle']        = $new_instance['subtitle'];
		$instance['action_url']      = $new_instance['action_url'];
		$instance['placeholder_txt'] = $new_instance['placeholder_txt'];
		return $instance;
	}
}

<?php
/**
 * Twitter Widget
 *
 * This widget displays latest tweets.
 *
 * @uses /modules/TwitterOAuth
 * @uses /modules/OAuth
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
 * [palamut_twitter_widget_init description]
 *
 * @method palamut_twitter_widget_init
 *
 * @since
 *
 * @link
 */
function palamut_twitter_widget_init() {
	register_widget( 'palamut_Twitter_Widget' );
}

add_action( 'widgets_init', 'palamut_twitter_widget_init' );

/**
 * [palamut_Twitter_Widget description]
 */
class Palamut_Twitter_Widget extends WP_Widget {
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
			'palamut-twitter-feed',
			__( 'Palamut widgets: Twitter', 'palamut' ),
			array(
				'classname'                   => 'palamut-twitter-feed',
				'description'                 => esc_html__( 'Displays your latest tweets', 'palamut' ),
				'customize_selective_refresh' => true,
			)
		);
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
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'               => esc_html__( 'Latest Tweets', 'palamut' ),
				'count'               => '5',
				'username'            => '',
				'exclude_replies'     => '1',
				'time'                => '1',
				'display_avatar'      => '1',
				'consumer_key'        => '',
				'consumer_secret'     => '',
				'access_token'        => '',
				'access_token_secret' => '',
			)
		);

		$title               = empty( $instance['title'] ) ? '' : strip_tags( $instance['title'] );
		$consumer_key        = empty( $instance['consumer_key'] ) ? '' : strip_tags( $instance['consumer_key'] );
		$consumer_secret     = empty( $instance['consumer_secret'] ) ? '' : strip_tags( $instance['consumer_secret'] );
		$access_token        = empty( $instance['access_token'] ) ? '' : strip_tags( $instance['access_token'] );
		$access_token_secret = empty( $instance['access_token_secret'] ) ? '' : strip_tags( $instance['access_token_secret'] );
		$count               = empty( $instance['count'] ) ? '' : strip_tags( $instance['count'] );
		$username            = empty( $instance['username'] ) ? '' : strip_tags( $instance['username'] );
		$exclude_replies     = empty( $instance['exclude_replies'] ) ? 0 : 1;
		$time                = empty( $instance['time'] ) ? 0 : 1;
		$display_avatar      = empty( $instance['display_avatar'] ) ? 0 : 1;?>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'palamut' ); ?>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>"><?php esc_html_e( 'Consumer Key:', 'palamut' ); ?>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_key' ) ); ?>"
			type="text" value="<?php echo esc_attr( $consumer_key ); ?>" /></label></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>"><?php esc_html_e( 'Consumer Secret:', 'palamut' ); ?>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_secret' ) ); ?>"
			type="text" value="<?php echo esc_attr( $consumer_secret ); ?>" /></label></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>"><?php esc_html_e( 'Access Token:', 'palamut' ); ?>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>"
			type="text" value="<?php echo esc_attr( $access_token ); ?>" /></label></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>"><?php esc_html_e( 'Access Token Secret:', 'palamut' ); ?>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token_secret' ) ); ?>"
			type="text" value="<?php echo esc_attr( $access_token_secret ); ?>" /></label></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Enter your twitter username:', 'palamut' ); ?>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>"
			type="text" value="<?php echo esc_attr( $username ); ?>" /></label></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'How many entries do you want to show:', 'palamut' ); ?>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>">
				<?php
				for ( $i = 1; $i <= 20; $i++ ) :
						$selected = ( $count == $i ) ? "selected='selected'" : '';
					?>
					<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $i ); ?>"><?php echo esc_attr( $i ); ?></option>
				<?php endfor; ?>
			</select></label></p>

		<p><input type="checkbox"  id="<?php echo esc_attr( $this->get_field_id( 'exclude_replies' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_replies' ) ); ?>"
			<?php checked( $exclude_replies ); ?> /> <label for="<?php echo esc_attr( $this->get_field_id( 'exclude_replies' ) ); ?>"><?php esc_html_e( 'Exclude @replies', 'palamut' ); ?></label></p>

		<p><input type="checkbox"  id="<?php echo esc_attr( $this->get_field_id( 'time' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'time' ) ); ?>"
			<?php checked( $time ); ?> /> <label for="<?php echo esc_attr( $this->get_field_id( 'time' ) ); ?>"><?php esc_html_e( 'Show time of tweet', 'palamut' ); ?></label></p>

		<p><input type="checkbox"  id="<?php echo esc_attr( $this->get_field_id( 'display_avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_avatar' ) ); ?>"
				<?php checked( $display_avatar ); ?> /> <label for="<?php echo esc_attr( $this->get_field_id( 'display_avatar' ) ); ?>"><?php esc_html_e( 'Show user avatar', 'palamut' ); ?></label></p>
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
		$instance                        = $old_instance;
		$instance['title']               = strip_tags( $new_instance['title'] );
		$instance['consumer_key']        = strip_tags( $new_instance['consumer_key'] );
		$instance['consumer_secret']     = strip_tags( $new_instance['consumer_secret'] );
		$instance['access_token']        = strip_tags( $new_instance['access_token'] );
		$instance['access_token_secret'] = strip_tags( $new_instance['access_token_secret'] );
		$instance['count']               = strip_tags( $new_instance['count'] );
		$instance['username']            = strip_tags( $new_instance['username'] );
		$instance['exclude_replies']     = empty( $new_instance['exclude_replies'] ) ? 0 : 1;
		$instance['time']                = empty( $new_instance['time'] ) ? 0 : 1;
		$instance['display_avatar']      = empty( $new_instance['display_avatar'] ) ? 0 : 1;
		return $instance;
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
			$title               = empty( $instance['title'] ) ? '' : strip_tags( $instance['title'] );
			$consumer_key        = empty( $instance['consumer_key'] ) ? '' : strip_tags( $instance['consumer_key'] );
			$consumer_secret     = empty( $instance['consumer_secret'] ) ? '' : strip_tags( $instance['consumer_secret'] );
			$access_token        = empty( $instance['access_token'] ) ? '' : strip_tags( $instance['access_token'] );
			$access_token_secret = empty( $instance['access_token_secret'] ) ? '' : strip_tags( $instance['access_token_secret'] );
			$count               = empty( $instance['count'] ) ? '' : strip_tags( $instance['count'] );
			$username            = empty( $instance['username'] ) ? '' : strip_tags( $instance['username'] );
			$exclude_replies     = empty( $instance['exclude_replies'] ) ? false : true;
			$time                = empty( $instance['time'] ) ? false : true;
			$display_avatar      = empty( $instance['display_avatar'] ) ? false : true;

		echo wp_kses( $before_widget, allowed_html() );

		if ( ! empty( $title ) ) {
			echo wp_kses( $before_title . $title . $after_title, allowed_html() );
		};

		if ( $username && $consumer_key && $consumer_secret && $access_token && $access_token_secret && $count ) {

				$trans_name = 'list_tweets';
				$cache_time = 10;
				require_once PALAMUT_PATH . 'includes/vendors/twitteroauth.php';
					$twitter_connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );
					$twitter_data       = $twitter_connection->get(
						'statuses/user_timeline',
						array(
							'screen_name'     => $username,
							'count'           => $count,
							'exclude_replies' => $exclude_replies,
						)
					);

			if ( 200 !== $twitter_connection->http_code ) {
				$twitter_data = get_transient( $trans_name );
			}

				set_transient( $trans_name, $twitter_data, 60 * 10 );
				$twitter = get_transient( $trans_name );

				echo "<ul class='palamut-tweet-list'>";
			if ( $twitter && is_array( $twitter ) ) {
				foreach ( $twitter as $tweet ) :

					$latest_tweet = $tweet->text;
					$regex_url    = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
					if ( preg_match( $regex_url, $latest_tweet, $url ) ) {
						$latest_tweet = preg_replace( $regex_url, '<a href="' . $url[0] . '" rel="nofollow">' . $url[0] . '</a>', $latest_tweet );
					}
					$twitter_time = strtotime( $tweet->created_at );
					$twitter_time = ! empty( $tweet->utc_offset ) ? $twitter_time + ( $tweet->utc_offset ) : $twitter_time;
					$time_ago     = date_i18n( get_option( 'date_format' ), $twitter_time );

					echo '<li class="single-tweet">';
					if ( $display_avatar ) {
						echo '<span class="tweet-thumb"><a href="http://twitter.com/' . esc_attr( $username ) . '" title="' . esc_attr( $username ) . '"><img src="' . esc_url( $tweet->user->profile_image_url ) . '" alt="' . esc_attr( $username ) . '" /></a></span>';
					}

							echo '<span class="tweet-text">' . wp_kses( $latest_tweet, allowed_html() ) . '</span>';

					if ( $time ) {
						echo '<span class="tweet-time">' . wp_kses( $time_ago, allowed_html() ) . '</span>';
					}
							echo '</li>';

					endforeach;
			} else {
				echo '<li>' . esc_html__( 'No public Tweets or wrong credentials', 'palamut' ) . '</li>';
			}
				echo '</ul>';
		}
		echo wp_kses( $after_widget, allowed_html() );
	}
}

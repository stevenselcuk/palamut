<?php
/**
 * Icon Bucket
 *
 * It creates good SVG icon experience
 *
 * @package palamutname
 *
 * @subpackage Classes
 * @category UI
 *
 * @version palamutversion
 * @since 1.0.1
 *
 * @author palamutauthor
 * @copyright palamutcopyright
 * @license palamutlicense
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Donut Icon Bucket Class
 */
class Palamut_Icon_Bucket {
	/**
	 * Declaration of prefix_Icon_Bucket Instance
	 *
	 * @var object
	 */
	public static $instance = null;

	/**
	 * Return an instance of prefix_Icon_Bucket
	 *
	 * @return    object    prefix_Icon_Bucket
	 */
	public static function instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	/**
	 * The Magic Method for building prefix_Icon_Bucket
	 *
	 * @method __construct
	 *
	 * @since 1.0.2
	 */
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'add_svg_sprite' ), 9999 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'prefix_social_nav_icons' ), 10, 4 );
	}

	/**
	 * Add SVG sprite to footer
	 */
	public static function add_svg_sprite() {
		// Define SVG sprite file.
		$svg_icons = get_theme_file_path( '/assets/img/sprite.svg' );

		// If it exists, include it.
		if ( file_exists( $svg_icons ) ) {
			require_once $svg_icons;
		}
	}

	/**
	 * Return SVG markup.
	 * Based on the function from Twenty Seventeen.
	 *
	 * @param array $args {
	 *     Parameters needed to display an SVG.
	 *
	 *     @type string $icon  Required SVG icon filename.
	 *     @type string $title Optional SVG title.
	 *     @type string $desc  Optional SVG description.
	 * }
	 * @return string SVG markup.
	 */
	public function get( $args = array() ) {
		// Make sure $args are an array.
		if ( empty( $args ) ) {
			return __( 'Please define default parameters in the form of an array.', 'textdomain' );
		}

		// Define an icon.
		if ( false === array_key_exists( 'icon', $args ) ) {
			return __( 'Please define an SVG icon filename.', 'textdomain' );
		}

		// Set defaults.
		$defaults = array(
			'icon'     => '',
			'title'    => '',
			'desc'     => '',
			'fallback' => false,
		);

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		// Set aria hidden.
		$aria_hidden = ' aria-hidden="true"';

		// Set ARIA.
		$aria_labelledby = '';

		/*
		 * palamut doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
		 *
		 * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
		 *
		 * Example 1 with title: <?php echo prefix_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
		 *
		 * Example 2 with title and description: <?php echo prefix_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
		 *
		 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
		 */
		if ( $args['title'] ) {
			$aria_hidden     = '';
			$unique_id       = uniqid();
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

			if ( $args['desc'] ) {
				$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
			}
		}

		// Begin SVG markup.
		$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

		// Display the title.
		if ( $args['title'] ) {
			$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

			// Display the desc only if the title is already set.
			if ( $args['desc'] ) {
				$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
			}
		}

		/*
		 * Display the icon.
		 *
		 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
		 *
		 * See https://core.trac.wordpress.org/ticket/38387.
		 */
		$svg .= ' <use href="#' . esc_html( $args['icon'] ) . '" xlink:href="#' . esc_html( $args['icon'] ) . '"></use> ';

		// Add some markup to use as a fallback for browsers that do not support SVGs.
		if ( $args['fallback'] ) {
			$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
		}

		$svg .= '</svg>';

		return $svg;
	}

	/**
	 * Adds icons to 'social' nav menu.
	 *
	 * @param  string  $item_output The menu item output.
	 * @param  WP_Post $item        Menu item object.
	 * @param  int     $depth       Depth of the menu.
	 * @param  array   $args        wp_nav_menu() arguments.
	 * @return string  $item_output The menu item output with social icon.
	 */
	public function prefix_social_nav_icons( $item_output, $item, $depth, $args ) {
		// Get supported social icons.
		$social_icons = $this->prefix_social_network_icons();

		// Change SVG icon inside social links menu if there is supported URL.
		if ( 'social' === $args->theme_location ) {
			foreach ( $social_icons as $attr => $value ) {
				if ( false !== strpos( $item_output, $attr ) ) {
					$item_output = str_replace( $args->link_after, '</span>' . $this->get( array( 'icon' => esc_attr( $value ) ) ), $item_output );
				}
			}
		}

		return $item_output;
	}

	/**
	 * Returns an array of supported social links (URL and icon name).
	 *
	 * @return array $social_links_icons
	 */
	private static function prefix_social_network_icons() {

		$social_links_icons = array(
			'behance.net'     => 'behance',
			'codepen.io'      => 'codepen',
			'dribbble.com'    => 'dribbble',
			'facebook.com'    => 'facebook',
			'/feed'           => 'rss',
			'flickr.com'      => 'flickr',
			'plus.google.com' => 'google',
			'github.com'      => 'github',
			'instagram.com'   => 'instagram',
			'linkedin.com'    => 'linkedin',
			'mailto:'         => 'email',
			'medium.com'      => 'medium',
			'pinterest.com'   => 'pinterest',
			'quora.com'       => 'quora',
			'reddit.com'      => 'reddit',
			'snapchat.com'    => 'snapchat-ghost',
			'soundcloud.com'  => 'soundcloud',
			'slack.com'       => 'slack',
			'spotify.com'     => 'spotify',
			'stumbleupon.com' => 'stumbleupon',
			'twitch.tv'       => 'twitch',
			'twitter.com'     => 'twitter',
			'vimeo.com'       => 'vimeo',
			'youtube.com'     => 'youtube',
		);

		return apply_filters( 'prefix_social_network_icons', $social_links_icons );
	}

}

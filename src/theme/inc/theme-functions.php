<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package palamut
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'palamut_allowed_html' ) ) {
	/**
	 * It gives you back allowed tags. Kinda shorthand for boring wp_kses thing.
	 *
	 * @method palamut_allowed_html()
	 *
	 * @since 1.0
	 *
	 * @return array Allowed html tags.
	 */
	function palamut_allowed_html() {
		$allowed_tags = array(
			'a'          => array(
				'class'  => array(),
				'href'   => array(),
				'rel'    => array(),
				'title'  => array(),
				'target' => array(),
			),
			'abbr'       => array(
				'title' => array(),
			),
			'iframe'     => array(
				'src' => array(),
			),
			'b'          => array(),
			'br'         => array(),
			'blockquote' => array(
				'cite' => array(),
			),
			'cite'       => array(
				'title' => array(),
			),
			'code'       => array(),
			'del'        => array(
				'datetime' => array(),
				'title'    => array(),
			),
			'dd'         => array(),
			'div'        => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'dl'         => array(),
			'dt'         => array(),
			'em'         => array(),
			'h1'         => array(),
			'h2'         => array(),
			'h3'         => array(),
			'h4'         => array(),
			'h5'         => array(),
			'h6'         => array(),
			'i'          => array(
				'class' => array(),
			),
			'img'        => array(
				'alt'    => array(),
				'class'  => array(),
				'height' => array(),
				'src'    => array(),
				'width'  => array(),
			),
			'li'         => array(
				'class' => array(),
			),
			'ol'         => array(
				'class' => array(),
			),
			'p'          => array(
				'class' => array(),
			),
			'q'          => array(
				'cite'  => array(),
				'title' => array(),
			),
			'span'       => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'strike'     => array(),
			'strong'     => array(),
			'ul'         => array(
				'class' => array(),
			),
		);

		return $allowed_tags;
	}
}


 /**
  * [palamut_svg_allowed_html description]
  *
  * @method palamut_svg_allowed_html
  *
  * @since
  *
  * @link
  *
  * @see
  *
  * @return [type]
  */
function palamut_clean_svg() {
	return apply_filters(
		'palamut_svg_allowed_html',
		array(
			'svg' => array(
				'class'       => array(),
				'aria-hidden' => array(),
				'role'        => array(),
			),
			'use' => array(
				'xlink:href' => array(),
			),
		)
	);

}

 /**
  * [palamut_gimme description]
  *
  * @method palamut_gimme
  *
  * @since
  *
  * @link
  *
  * @param  string $name Which option that we want?.
  * @param  string $default_value A fallback if something is wrong.
  *
  * @return [type]
  */
function palamut_gimme( $name = null, $default_value = null ) {

	if ( null === $name ) {
		return $default_value ? $default_value : null;
	}

	$value = null;

	if ( null === $value || 'default' === $value && class_exists( 'Palamut_Customizer' ) ) {
			$value = Palamut_Customizer::get( $name, $default_value );
	}
	/**
	 * What if there is no BestMan? Ugly theme? Nope.
	 *
	 * Try theme palamuttheme_defaults
	 *
	 * @see palamuttheme_defaults
	 */
	if ( null === $value ) {
		$value = palamut_theme_defaults( $name );
	}
		 /**
		* Still no luck? let's look user given value.
		*
		* @var $value
		* @var $default_value
		*/
	if ( null === $value && null !== $default_value ) {
		$value = $default_value;
	}
	return $value;
}


/**
 * [dude_icons description]
 *
 * @method dude_icons
 *
 * @since
 *
 * @link
 *
 * @see classes/class-dude-icon-bucket.php
 *
 * @return [type]
 */
function palamut_icons() {
	return Palamut_Icon_Bucket::instance();
}


if ( ! function_exists( 'palamut_add_body_class' ) ) {
	/**
	 * Adds classes to <body> tag
	 *
	 * @method palamut_add_body_class
	 *
	 * @param array $classes is an array of all body classes.
	 *
	 * @return array $classes add calculated class to body element
	 */
	function palamut_add_body_class( $classes ) {
		$classes[] = 'clearfix';

		if ( is_customize_preview() ) {
			$classes[] = 'is-customize-preview';
		}

		if ( palamut_gimme( 'is-header-sticky' ) ) {
			$classes[] = 'has-sticky-header';
		}

		if ( palamut_gimme( 'boxed-page' ) ) {
			$classes[] = 'is-boxed';
		}

		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		if ( is_single() && has_post_thumbnail() || is_page() && has_post_thumbnail() ) {
			$classes[] = 'has-featured-image';
		}
		if ( palamut_gimme( 'show_search' ) ) {
			$classes[] = palamut_gimme( 'search_type' );
		}
		if ( is_singular() && has_blocks() ) {
			$classes[] = 'has-gutenberg-blocks';
		}
		if ( is_singular() ) {
			$classes[] = 'single';
		}
		if ( is_front_page() ) {
			$classes[] = 'front-page';
		}
		return $classes;
	}
}

add_filter( 'body_class', 'palamut_add_body_class' );

if ( ! function_exists( 'palamut_add_post_classes' ) ) {
	/**
	 * Adds additional classes the post
	 *
	 * @method palamut_add_post_classes
	 *
	 * @since 1.0.2
	 *
	 * @param  array $classes All classes we need to add post.
	 */
	function palamut_add_post_classes( $classes ) {
		if ( is_singular() || is_single() ) {
			$classes[] = 'single-post';
		}

		if ( is_front_page() && is_home() ) {
			$classes[] = 'default-loop';
		}

		if ( is_home() ) {
			$classes[] = 'blog-loop';
		}

		$classes[] = 'entry';

		return $classes;
	}
}
add_filter( 'post_class', 'palamut_add_post_classes', 10, 3 );

if ( ! function_exists( 'palamut_excerpt_more' ) ) {
	/**
	 * It modifies [...]
	 *
	 * @method palamut_excerpt_more
	 *
	 * @since 1.0.0
	 *
	 * @link
	 *
	 * @param  string $more WP Standard.
	 *
	 * @return string Changed exceprt more string
	 */
	function palamut_excerpt_more( $more ) {
		return '...';
	}
}
add_filter( 'excerpt_more', 'palamut_excerpt_more' );

add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'the_excerpt', 'do_shortcode' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function palamut_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'palamut_pingback_header' );

if ( ! function_exists( 'palamut_site_logo' ) ) {
	/**
	 * Gives you back site Logo (or site title)
	 *
	 * @method palamut_site_logo
	 *
	 * @since 1.0
	 *
	 * @link
	 *
	 * @see component/header
	 *
	 * @return void
	 */
	function palamut_site_logo() {

		if ( has_custom_logo() ) {
				echo '<div class="site-logo">';
				the_custom_logo();
				echo '</div>';
		} else {
			if ( is_front_page() && is_home() ) :
				?>
		<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><h1 itemprop='name'><?php bloginfo( 'name' ); ?></h1></a>
		<?php else : ?>
		<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><p itemprop='name'><?php bloginfo( 'name' ); ?></p></a>
		<?php
			endif;
if ( display_header_text() ) {
	$description = get_bloginfo( 'description', 'display' );
	if ( $description || is_customize_preview() ) :
		?>
		<p class="site-description"><?php echo esc_html( $description ); ?></p>
		<?php
		endif;
}
		}
	}
}

if ( ! function_exists( 'palamut_get_pagination' ) ) {
	/**
	 * Navigation on loops
	 *
	 * @method palamut_get_pagination()
	 *
	 * @since 1.0.0
	 *
	 * @link
	 */
	function palamut_get_pagination() {
		// return before too late...
		global $wp_query;
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		$pagination_type = palamut_gimme( 'pagination_type', palamut_theme_defaults( 'pagination_type' ) );
		if ( 'paginated' === $pagination_type ) :
			the_posts_pagination(
				array(
					'mid_size'           => 2,
					'prev_text'          => wp_kses( palamut_icons()->get( array( 'icon' => 'back' ) ), palamut_clean_svg() ) . __( 'Prev', 'palamut' ),
					'next_text'          => __( 'Next', 'palamut' ) . wp_kses( palamut_icons()->get( array( 'icon' => 'next-1' ) ), palamut_clean_svg() ),
					'screen_reader_text' => __( 'Posts Navigation', 'palamut' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'palamut' ) . ' </span>',
				)
			);
		else :
			?>
	<div class="nav-links">
		<span class="screen-reader-text"><?php esc_html__( 'Posts Navigation', 'palamut' ); ?></span>
		<span class="nav-prev"><?php previous_posts_link( is_search() ? esc_html__( 'Previous posts', 'palamut' ) : esc_html__( 'Newest posts', 'palamut' ) ); ?></span>
		<span class="nav-next"><?php next_posts_link( is_search() ? esc_html__( 'Next posts', 'palamut' ) : esc_html__( 'Older posts', 'palamut' ), $wp_query->max_num_pages ); ?></span>
	</div>
			<?php
		endif;
	}
}

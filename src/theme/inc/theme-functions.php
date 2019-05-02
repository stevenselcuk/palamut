<?php
/**
 * Document_title
 *
 * Document_desc
 *
 * @link N/A
 *
 * @package pkg.name
 *
 * @subpackage Theme Functions
 * @category Functions
 *
 * @version pkg.version
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'prefix_add_body_class' ) ) {
	/**
	 * Adds classes to <body> tag
	 *
	 * @method prefix_add_body_class
	 *
	 * @param array $classes is an array of all body classes.
	 *
	 * @return array $classes add calculated class to body element
	 */
	function prefix_add_body_class( $classes ) {
		global $is_lynx, $is_gecko, $is_ie, $is_opera, $is_ns4, $is_safari, $is_chrome, $is_iphone;

		if ( $is_lynx ) {
			$classes[] = 'lynx';
		} elseif ( $is_gecko ) {
			$classes[] = 'gecko';
		} elseif ( $is_opera ) {
			$classes[] = 'opera';
		} elseif ( $is_ns4 ) {
			$classes[] = 'ns4';
		} elseif ( $is_safari ) {
			$classes[] = 'safari';
		} elseif ( $is_chrome ) {
			$classes[] = 'chrome';
		} elseif ( $is_ie ) {
			$classes[] = 'ie';
			if ( preg_match( '/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) ) {
				$classes[] = 'ie' . $browser_version[1];
			}
		} else {
			$classes[] = 'unknown';
		}

		if ( $is_iphone ) {
			$classes[] = 'iphone';
		}

		$classes[] = 'clearfix';

		if ( is_customize_preview() ) {
			$classes[] = 'is-customize-preview';
		}

		if ( true === prefix_gimme( 'is-header-sticky', false ) ) {
			// $classes[] = 'has-sticky-header';
		}

		if ( prefix_gimme( 'boxed-page' ) ) {
			$classes[] = 'is-boxed';
		}

		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		if ( is_single() && has_post_thumbnail() || is_page() && has_post_thumbnail() ) {
			$classes[] = 'has-featured-image';
		}
		if ( prefix_gimme( 'show_search' ) ) {
			$classes[] = prefix_gimme( 'search_type' );
		}
		if ( is_singular() && has_blocks() && ! class_exists( 'Classic_Editor' ) ) {
			$classes[] = 'gutenberg-editor';
		} else {
			$classes[] = 'classic-editor';
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

add_filter( 'body_class', 'prefix_add_body_class' );

if ( ! function_exists( 'prefix_add_post_classes' ) ) {
	/**
	 * Adds additional classes the post
	 *
	 * @method prefix_add_post_classes
	 *
	 * @since 1.0.2
	 *
	 * @param  array $classes All classes we need to add post.
	 */
	function prefix_add_post_classes( $classes ) {
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
add_filter( 'post_class', 'prefix_add_post_classes', 10, 3 );

if ( ! function_exists( 'prefix_excerpt_more' ) ) {
	/**
	 * It modifies [...]
	 *
	 * @method prefix_excerpt_more
	 *
	 * @since 1.0.0
	 *
	 * @link
	 *
	 * @param  string $more WP Standard.
	 *
	 * @return string Changed exceprt more string
	 */
	function prefix_excerpt_more( $more ) {
		return '...';
	}
}
add_filter( 'excerpt_more', 'prefix_excerpt_more' );

add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'the_excerpt', 'do_shortcode' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function prefix_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'prefix_pingback_header' );

if ( ! function_exists( 'prefix_site_logo' ) ) {
	/**
	 * Gives you back site Logo (or site title)
	 *
	 * @method prefix_site_logo
	 *
	 * @since 1.0
	 *
	 * @link
	 *
	 * @see component/header
	 *
	 * @return void
	 */
	function prefix_site_logo() {

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

if ( ! function_exists( 'prefix_get_pagination' ) ) {
	/**
	 * Navigation on loops
	 *
	 * @method prefix_get_pagination()
	 *
	 * @since 1.0.0
	 *
	 * @link
	 */
	function prefix_get_pagination() {
		// return before too late...
		global $wp_query;
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		$pagination_type = prefix_gimme( 'pagination_type', prefix_theme_defaults( 'pagination_type' ) );
		if ( 'paginated' === $pagination_type ) :
			the_posts_pagination(
				array(
					'mid_size'           => 2,
					'prev_text'          => wp_kses( prefix_icons()->get( array( 'icon' => 'back' ) ), prefix_clean_svg() ) . __( 'Prev', 'textdomain' ),
					'next_text'          => __( 'Next', 'textdomain' ) . wp_kses( prefix_icons()->get( array( 'icon' => 'next-1' ) ), prefix_clean_svg() ),
					'screen_reader_text' => __( 'Posts Navigation', 'textdomain' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'textdomain' ) . ' </span>',
				)
			);
		else :
			?>
	<div class="nav-links">
		<span class="screen-reader-text"><?php esc_html__( 'Posts Navigation', 'textdomain' ); ?></span>
		<span class="nav-prev"><?php previous_posts_link( is_search() ? esc_html__( 'Previous posts', 'textdomain' ) : esc_html__( 'Newest posts', 'textdomain' ) ); ?></span>
		<span class="nav-next"><?php next_posts_link( is_search() ? esc_html__( 'Next posts', 'textdomain' ) : esc_html__( 'Older posts', 'textdomain' ), $wp_query->max_num_pages ); ?></span>
	</div>
			<?php
		endif;
	}
}

/**
 * Adds a custom template for the block editor for the post type.
 */
function prefix_add_template_to_posts() {

	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$post_type_object = get_post_type_object( 'post' );

	$post_type_object->template = array(
		array(
			'core/image',
			array(
				'align' => 'wide',
			),
		),
		array( 'core/paragraph' ),
	);
}
add_action( 'init', 'prefix_add_template_to_posts' );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function prefix_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template', 'prefix_front_page_template' );


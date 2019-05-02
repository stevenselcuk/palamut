<?php
/**
 * Template Name: Full Width
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

get_header(); ?>

	<main class="nm-page-full">
		<?php
		while ( have_posts() ) :
			the_post();
			?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" itemid="<?php echo esc_url( get_the_permalink() ); ?>" content="<?php echo esc_attr( get_the_title() ); ?>">

			<header class="entry-header">

			<?php do_action( 'palamut_page_header_start' ); ?>

			<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} elseif ( is_front_page() && is_home() ) {
				the_title( '<h3 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			} else {
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
			?>
			<?php do_action( 'palamut_page_header_end' ); ?>
		</header>

			<main class="entry-content" itemprop="articleBody">

				<?php do_action( 'palamut_page_main_start' ); ?>

				<?php
				the_content(
					sprintf(
						/* translators: %s: Name of current post */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'palamut' ),
						get_the_title()
					)
				);
				wp_link_pages(
					array(
						'before'      => '<div class="page-links">' . __( 'Pages:', 'palamut' ),
						'after'       => '</div>',
						'link_before' => '<span class="page-number">',
						'link_after'  => '</span>',
					)
				);
				?>

				<?php do_action( 'palamut_page_main_end' ); ?>

			</main><!--.entry-content-->

		<?php endif; ?>

			<footer class="entry-footer">

			<?php do_action( 'palamut_page_footer_start' ); ?>

			<?php palamut_entry_footer(); ?>

			<?php do_action( 'palamut_page_footer_end' ); ?>

			</footer><!--.entry-footer-->

		</article>


			<?php endwhile; ?>

	</main>

			<?php get_footer(); ?>

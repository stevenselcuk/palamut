<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package palamut
 */

get_header();
?>

	<main id="content" class="site-content page" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

		<?php
		while ( have_posts() ) :

			the_post();

			if ( is_singular( 'portfolio' ) ) {
				get_template_part( 'components/content', 'portfolio' );
			} elseif ( is_singular( 'page' ) ) {
				get_template_part( 'components/content', 'page' );
			} else {
				get_template_part( 'components/content', get_post_type() );
			}

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #content -->


<?php
get_sidebar();
get_footer();

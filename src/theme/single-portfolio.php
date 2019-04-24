<?php
/**
 * The template for displaying all single portfolio items
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package palamut
 */

get_header();
?>

	<main id="content" class="site-content portfolio-single" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

		<?php
		while ( have_posts() ) :

			the_post();

			get_template_part( 'components/cpts/portfolio/portfolio', 'single' );

			the_post_navigation();

		endwhile; // End of the loop.
		?>

	</main><!-- #content -->


<?php
get_sidebar();
get_footer();

<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package palamut
 */


?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" itemid="<?php echo esc_url( get_the_permalink() ); ?>" content="<?php echo esc_attr( get_the_title() ); ?>">
	<!-- Start .entry-header-->
	<header class="entry-header">
		<?php
		do_action( 'palamut_post_header_start' );

		if ( is_singular() ) :

			the_title( '<h1 class="entry-title">', '</h1>' );

		else :

			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		endif;

		do_action( 'palamut_post_header_end' );

		if ( 'post' === get_post_type() ) :
			?>
			<!-- Start: .entry-meta -->
			<div class="entry-meta">
				<?php
				do_action( 'palamut_post_meta' );
				palamut_posted_on();
				palamut_posted_by();
				?>
			</div>
			<!-- End: .entry-meta -->
		<?php endif; ?>
	</header>
	<!-- End: .entry-header -->

	<?php palamut_post_thumbnail(); ?>

	<!-- Start: .entry-content -->
	<main class="entry-content">
		<?php
		if ( is_singular() ) :

			do_action( 'palamut_post_content_start' );

			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'palamut' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'palamut' ),
					'after'  => '</div>',
				)
			);

			do_action( 'palamut_post_content_start' );

	else :

		do_action( 'palamut_post_excerpt_start' );

		the_excerpt();

		do_action( 'palamut_post_excerpt_end' );

	endif;
	?>
	</main>
	<!-- End: .entry-content -->
	<!-- Start: .entry-footer -->
	<footer class="entry-footer">

		<?php
		do_action( 'palamut_post_footer_start' );
		palamut_entry_footer();
		do_action( 'palamut_post_footer_end' );
		?>

	</footer>
	<!-- End: .entry-footer -->

</article>
<!-- #post-<?php the_ID(); ?> -->

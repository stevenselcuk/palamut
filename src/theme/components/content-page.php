<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package palamut
 */

?>

<article id="page-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" itemid="<?php echo esc_url( get_the_permalink() ); ?>" content="<?php echo esc_attr( get_the_title() ); ?>">

	<?php

	do_action( 'palamut_page_header_start' );

	if ( 'on' !== get_post_meta( get_the_ID(), 'palamut_page_hide_page_title', true ) || is_front_page() && is_home() ) :

		?>
	<!-- Start: .entry-header -->
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<!-- End: .entry-header -->

		<?php

	endif;

	do_action( 'palamut_page_header_end' );

	?>

	<?php palamut_post_thumbnail(); ?>
	<!-- Start: .entry-content -->
	<main class="entry-content" itemprop="articleBody">
		<?php

		do_action( 'palamut_page_content_start' );

		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'palamut' ),
				'after'  => '</div>',
			)
		);
		do_action( 'palamut_page_content_end' );

		?>

	</main>
	<!-- End: .entry-content -->
	<!-- Start: .entry-footer -->
		<footer class="entry-footer">
			<?php
			if ( get_edit_post_link() ) :
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'palamut' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
			endif;
			?>

		</footer>
		<!-- End: .entry-footer -->

</article><!-- #page-<?php the_ID(); ?> -->

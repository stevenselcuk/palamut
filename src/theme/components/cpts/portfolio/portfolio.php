<?php
/**
 * { Document title }
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
 // Get user selected layout option.
 $layout = get_theme_mod( 'portfolio_layout', 'classic' );
 // Create Loop Arguments.
 $args = array(
	 'numberposts'    => '',
	 'posts_per_page' => -1,
	 // 'meta_query'     => array( array( 'key' => '_thumbnail_id' ) ),
	 'order'          => 'ASC',
	 'orderby'        => 'menu_order',
	 'post_type'      => 'portfolio',
	 'post_status'    => 'publish',
 );
 // Create an WP_Query object.
 $portfolio_query = new WP_Query( $args );
	?>
	 <!-- Start: #main -->
	 <main id="content" class="site-content portfolio-loop <?php echo esc_attr( $layout ); ?>" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
		<?php
		if ( $portfolio_query->have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				 <header>
					 <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				 </header>
				<?php
			endif;

			/* Start the Portfolio Loop */
			while ( $portfolio_query->have_posts() ) :

				$portfolio_query->the_post();

				/*
				  * Include the Post-Type-specific template for the content.
				  * If you want to override this in a child theme, then include a file
				  * called portfolio-___.php (where ___ is theme spesific option) and that will be used instead.
				  */
				get_template_part( 'components/cpts/portfolio/portfolio', 'loop' );

			endwhile;

			palamut_get_pagination();

		else :

			get_template_part( 'components/content', 'none' );

		endif;
		?>

		 </main>
		 <!-- End: #main -->

<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package palamut
 */

?>

		<?php if ( palamut_gimme( 'show-footer', false ) ) : ?>
		<!-- Start: #colophon -->
		<footer id="colophon" class="site-footer classic-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

			<?php do_action( 'palamut_footer_start' ); ?>

			<!-- Start: .footer-widgets-->
			<div class="footer-widgets row justify-around clearfix">

				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-sidebar small-12 phone-12 tablet-12 laptop-6 desktop-6">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="footer-sidebar small-12 phone-12 tablet-12 laptop-6 desktop-6">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php endif; ?>

			</div>
			<!-- End: .footer-widgets-->

			<?php do_action( 'palamut_footer_end' ); ?>

		</footer>
		<!-- #colophon -->

		<?php endif; ?>

		<!-- Start: .site-info -->
		<?php if ( palamut_gimme( 'show-bottombar', true ) ) : ?>

		<section class="site-info clearfix">

		<p class="copyright">
			<?php echo wp_kses( palamut_gimme( 'copyright-text', palamut_theme_strings( 'copyright-text' ) ), palamut_allowed_html() ); ?>
		</p>
			<?php
			if ( has_nav_menu( 'social' ) ) :
				wp_nav_menu(
					array(
						'theme_location'  => 'social',
						'menu_class'      => 'social-menu',
						'container'       => 'nav',
						'container_class' => 'footer-social-menu',
						'fallback_cb'     => false,
						'depth'           => 1,
						'link_before'     => '<span class="screen-reader-text">',
						'link_after'      => '</span>' . palamut_icons()->get( array( 'icon' => 'plus' ) ),
					)
				);
			endif;
			?>

		</section>
		<!-- End: .site-info -->

	<?php endif; ?>

		<?php do_action( 'palamut_site_end' ); ?>

	</div>
	<!-- End: #page -->

	<?php get_sidebar( 'mobile' ); ?>

	<?php wp_footer(); ?>

	</body>
</html>

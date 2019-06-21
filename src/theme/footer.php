<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pkg.name
 *
 * @subpackage Theme Functions
 * @category Functions
 *
 * @version pkg.license
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

?>
	</div>
	<!-- End: #page -->
		<!-- Start: #colophon -->
		<footer id="colophon" class="site-footer classic-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

			<?php do_action( 'prefix_footer_start' ); ?>

			<?php do_action( 'prefix_footer' ); ?>

			<?php do_action( 'prefix_footer_end' ); ?>

		</footer>
		<!-- #colophon -->

		<?php do_action( 'prefix_site_end' ); ?>

	<?php wp_footer(); ?>

	</body>
</html>

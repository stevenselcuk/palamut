<?php
/**
 * Mobile Sidebar
 *
 * Includes offcanvas mobile navigations (and sometimes sidebar)
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
 * @author pkg.author
 * @copyright pdwcopyright
 * @license pdwlicense
 */

$is_active = ( ! is_active_sidebar( 'sidebar-1' ) ) ? 'no-widget-area' : 'has-widget-area'; ?>

<aside id="secondary" class="offcanvas-sidebar <?php echo esc_attr( $is_active ); ?>">

	<!-- Start: .hamburger-->
	<button class="offcanvas-close">
		<?php echo wp_kses( prefix_icons()->get( array( 'icon' => 'cancel' ) ), prefix_clean_svg() ); ?>
	</button>
	<!-- End: .hamburger-->

	<?php do_action( 'prefix_mobile_sidebar_start' ); ?>

	<div class="sidebar--section">

		<div class="sidebar--section-inner">

			<nav id="mobile-nav" class="mobile-navigation" aria-label="<?php esc_attr_e( 'Mobile Menu', 'textdomain' ); ?>">

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_class'     => 'mobile-menu',
						'depth'          => '0',
						'link_before'    => '<span>',
						'link_after'     => '</span>',
						'fallback_cb'    => 'Palamut_Mobile_Navwalker::fallback',
						'walker'         => new Palamut_Mobile_Navwalker(),
					)
				);
				?>
			</nav>

		</div>

	</div>

	<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
		<div class="sidebar--section widget-area">
			<div class="sidebar--section-inner">
				<?php dynamic_sidebar( 'sidebar' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php do_action( 'prefix_mobile_sidebar_end' ); ?>

</aside>

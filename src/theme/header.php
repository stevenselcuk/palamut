<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package palamut
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site" itemscope="itemscope" itemtype="https://schema.org/WebPage">

	<?php do_action( 'palamut_site_start' ); ?>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'palamut' ); ?></a>

	<!-- Start: .site-header -->
	<header id="masthead" class="site-header header-classic clearfix" itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
		<div class="header-container">

			<!-- Start: .site-branding -->
			<div class="site-branding" itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<?php palamut_site_logo(); ?>
			</div>
			<!-- End: .site-branding -->

		<?php
		if ( has_nav_menu( 'menu-1' ) ) :
			?>
			<!-- Start: #main-nav -->
			<nav id="primary-nav" class="site-navigation" aria-label="<?php esc_attr_e( 'Header Menu', 'palamut' ); ?>" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"
				role="navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_class'     => 'primary-menu',
						'depth'          => 2,
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
			<!-- End: #main-nav -->

			<!-- Start: .hamburger-->
			<button class="hamburger">
				<div></div>
				<div></div>
				<div></div>
			</button>
			<!-- End: .hamburger-->

		<?php endif; ?>
		<?php
		if ( palamut_gimme( 'show-search' ) ) :
			get_search_form();
		endif;
		?>
		</div>
	</header>
	<!-- End: .site-header -->
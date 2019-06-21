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
 * @author pkg.author
 * @copyright pdwcopyright
 * @license pdwlicense
 */

if ( prefix_is_woocommerce_activated() ) :
	add_action( 'prefix_site_end', 'prefix_woocommerce_minicart' );
	add_action( 'prefix_site_end', 'prefix_woocommerce_minibar' );
endif;

// Add Footer Widget Area.
add_action( 'prefix_footer', 'prefix_footer_widgets' );
// Add bottom bar colophon component.
add_action( 'prefix_site_end', 'prefix_site_info' );
// Add mobile menu.
add_action( 'prefix_site_end', 'prefix_mobile_menu' );



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

if ( palamut_is_woocommerce_activated() ) :
	add_action( 'palamut_site_end', 'palamut_woocommerce_minicart' );
	add_action( 'palamut_site_end', 'palamut_woocommerce_minibar' );
endif;

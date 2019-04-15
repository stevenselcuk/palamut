<?php
/**
 * Custom Post Type : Portfolio Init.
 *
 * No Desc.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * CPT Loader
 *
 * @method palamut_load_portfolio_cpt
 *
 * @since 1.0.2
 */
function palamut_load_portfolio_cpt() {
	$cpt_files = glob( dirname( __FILE__ ) . '/inc/*.php' );
	if ( ! empty( $cpt_files ) ) {
		foreach ( $cpt_files as $file ) {
			require_once $file;
		}
	}
}

add_action( 'plugins_loaded', 'palamut_load_portfolio_cpt', 9999 );

/**
 * Enables block editor support for the Portfolio Post Type plugin.
 *
 * @param array $args Existing arguments.
 *
 * @return array Amended arguments.
 */
function palamut_portfolio_cpt_args( array $args ) {

	$args['show_in_rest'] = true;

	return $args;
}
add_action( 'portfolioposttype_args', 'palamut_portfolio_cpt_args' );


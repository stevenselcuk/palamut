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
 * [palamut_taxonomy_filter_portfolio description]
 *
 * @method palamut_taxonomy_filter_portfolio
 *
 * @since
 *
 * @link
 */
function palamut_taxonomy_filter_portfolio() {
	global $typenow;

	if ( 'portfolio' === $typenow ) {
		$filters = array( 'portfolio-types' );

		foreach ( $filters as $tax_slug ) {
			$tax_obj  = get_taxonomy( $tax_slug );
			$tax_name = $tax_obj->labels->name;
			$terms    = get_terms( $tax_slug );

			echo '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';

				echo '<option value="">' . esc_html__( 'All', 'palamut' ) . ' ' . esc_html( $tax_name ) . '</option>';

			foreach ( $terms as $term ) {
				echo '<option value=' . $term->slug, $_GET[ $tax_slug ] == $term->slug ? ' selected="selected"' : '','>' . esc_html( $term->name ) . ' (' . esc_html( $term->count ) . ')</option>';
			}

			echo '</select>';
		}
	}
}

add_action( 'restrict_manage_posts', 'palamut_taxonomy_filter_portfolio' );



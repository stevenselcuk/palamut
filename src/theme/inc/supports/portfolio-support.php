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

/**
 * [prefix_portfolio_class description]
 *
 * @method prefix_portfolio_class
 *
 * @since
 *
 * @link
 *
 * @see
 *
 * @param  [type]                  $portolio_classes
 *
 * @return [type]
 */
function prefix_portfolio_class( $portolio_classes ) {
	$portolio_classes= array();
	if ( is_customize_preview() ) {
		$portolio_classes[] = 'is-customize-preview';
	}
	if ( is_singular() ) {
		$portolio_classes[] = 'single-project';
	} else {
		$portolio_classes[] = 'portfolio-loop';
	}

	return $portolio_classes;
}

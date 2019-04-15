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

/**
 * [palamut_is_front description]
 *
 * @method palamut_is_front
 *
 * @since
 *
 * @link
 *
 * @see
 *
 * @return boolean
 */
function palamut_is_front() {
	if ( ( ! is_home() ) && ( is_front_page() ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * [palamut_is_blog description]
 *
 * @method palamut_is_blog
 *
 * @since
 *
 * @link
 *
 * @see
 *
 * @return boolean
 */
function palamut_is_blog() {
	if ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) || ( is_search() ) ) {
		return true;
	} else {
		return false;
	}
}

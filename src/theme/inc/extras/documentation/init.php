<?php
/**
 * Document_title
 *
 * Document_desc
 *
 * @link N/A
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

if ( ! function_exists( 'prefix_documentation' ) ) :
	/**
	 * [prefix_documentation description]
	 *
	 * @method prefix_documentation
	 *
	 * @return [type]
	 */
	function prefix_documentation() {

		require __PRE_THEME_DIR . '/inc/extras/documentation/class-palamut-docs.php';

		if ( ! class_exists( 'Palamut_Docs' ) ) {
			return;
		}

		global $pagenow;

		// No inline-docs on the post editing screens, as Gutenberg causes issues.
		if ( 'post.php' === $pagenow || 'post-new.php' === $pagenow && function_exists( 'register_block_type' ) ) {
			return;
		}

		$markdown_url = 'https://raw.githubusercontent.com/themebeans/theme-docs/master/ava/readme.md';

		$huh = new Palamut_Docs();
		$huh->init( $markdown_url );
	}
endif;
add_action( 'admin_init', 'prefix_documentation' );

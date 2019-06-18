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
 * @version pkg.version
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

if ( ! function_exists( 'prefix_site_info' ) ) :
	/**
	 * Conditionally display the content based on the Customizer.
	 *
	 * Create your own prefix_site_info() to override in a child theme.
	 */
	function prefix_site_info() {
		/*
			* Set the variables derived from the Customizer.
			*/
		$show_copyright  = prefix_gimme( 'colophon_copyright', prefix_theme_defaults( 'colophon_copyright' ) );
		$copyright_text  = prefix_gimme( 'copyright_text', prefix_theme_strings( 'copyright_text' ) );
		$show_theme_info = prefix_gimme( 'colophon_theme_info', prefix_theme_defaults( 'show_theme_info' ) );

		/*
			* Check if the copyright or theme info is visible. If so, proceed.
			*/
		if ( true === $show_copyright ) :

			echo '<div class="site-info">';

			/*
				* Check if the Copyright option is selected in the Customizer.
				* Let's also display it in the Customizer, so we don't have to do a page refresh.
				*/
			if ( $show_copyright || is_customize_preview() ) :

				/**
				 * Only display if the option is selected in the Customizer.
				 */
				$visibility = ( false === $show_copyright ) ? ' hidden ' : '';

				echo '<span class="site-copyright' . esc_attr( $visibility ) . '">';

					/*
						* Copyright Year.
						*/
					printf(
						'<span class="%1s" itemscope itemtype="http://schema.org/copyrightYear">&copy; %2s </span>',
						esc_attr( 'copyright-year' ),
						esc_html( date( 'Y' ) )
					);

					/*
					 * Format an array of allowed HTML tags and attributes for the $copyrighttext value.
					 *
					 * @link https://codex.wordpress.org/Function_Reference/wp_kses
					 */
					$allowed_html_array = array(
						'a'      => array(
							'href'  => array(),
							'title' => array(),
						),
						'br'     => array(),
						'cite'   => array(),
						'em'     => array(),
						'strong' => array(),
					);

				/*
					* Check if the Copyright option is selected in the Customizer.
					*/
				if ( $copyright_text || is_customize_preview() ) {
					printf(
						'<span class="%1s" itemscope itemtype="http://schema.org/copyrightHolder">%2s</span>',
						esc_attr( 'copyright-text' ),
						wp_kses( $copyright_text, $allowed_html_array )
					);
				}

				echo '</span>';

			endif;

			/*
				* Check if the Theme Info option is selected in the Customizer.
				* Let's also display it in the Customizer, so we don't have to do a page refresh.
				*/
			if ( $show_theme_info || is_customize_preview() ) :
				/**
				 * Only display if the option is selected in the Customizer.
				 */
				$visibility = ( false === $show_theme_info ) ? ' hidden ' : '';

				/*
					* Format an array of allowed HTML tags and attributes for the $copyrighttext value.
					*
					* @link https://codex.wordpress.org/Function_Reference/wp_kses
					*/
				$allowed_html_array = array(
					'a'    => array(
						'href'  => array(),
						'title' => array(),
					),
					'span' => array(
						'class' => array(),
					),
				);

				/* translators: 'Year, Permalink, Name' */
				printf(
					wp_kses( __( '<span class="%1$1s%2$2s"><a href="%3$3s">Proudly Powered by %4$4s</a></span>', 'textdomain' ), $allowed_html_array ),
					esc_attr( 'site-theme' ),
					esc_attr( $visibility ),
					esc_url( 'https://tabbycat.co/themes/palamut/' ),
					esc_html( 'Palamut' ) // Let's not translate the theme name.
				);

			endif;

			echo '</div>';

		endif;

	}
endif;

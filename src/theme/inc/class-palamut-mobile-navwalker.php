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

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Palamut_Mobile_Navwalker' ) ) :

	/**
	 * [Dude_Mobile_Navwalker description]
	 */
	class Palamut_Mobile_Navwalker extends Walker_Nav_Menu {

		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a menu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'edit_theme_options' ) ) {
				/* Get Arguments. */
				$container       = $args['container'];
				$container_id    = $args['container_id'];
				$container_class = $args['container_class'];
				$menu_class      = $args['menu_class'];
				$menu_id         = $args['menu_id'];
				// initialize var to store fallback html.
				$fallback_output = '';
				if ( $container ) {
					$fallback_output .= '<' . esc_attr( $container );
					if ( $container_id ) {
						$fallback_output .= ' id="' . esc_attr( $container_id ) . '"';
					}
					if ( $container_class ) {
						$fallback_output .= ' class="' . esc_attr( $container_class ) . '"';
					}
					$fallback_output .= '>';
				}
				$fallback_output .= '<ul';
				if ( $menu_id ) {
					$fallback_output .= ' id="' . esc_attr( $menu_id ) . '"'; }
				if ( $menu_class ) {
					$fallback_output .= ' class="' . esc_attr( $menu_class ) . '"'; }
				$fallback_output .= '>';
				$fallback_output .= '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="' . esc_attr__( 'Add a menu', 'donut' ) . '">' . esc_html__( 'Add a menu', 'donut' ) . '</a></li>';
				$fallback_output .= '</ul>';
				if ( $container ) {
					$fallback_output .= '</' . esc_attr( $container ) . '>';
				}
				// if $args has 'echo' key and it's true echo, otherwise return.
				if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
					echo $fallback_output; // WPCS: XSS OK.
				} else {
					return $fallback_output;
				}
			}
		}


		function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}
			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "\n" . $indent . '<ul class="sub_menu">' . "\n";
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "$indent</ul>\n";
		}

		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$sub    = '';
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );

			if ( $depth >= 0 && $args->has_children ) :
				$sub = ' has_sub';
			endif;

			$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			$anchor = '';
			if ( '' !== $item->anchor ) {
				$anchor = '#' . esc_attr( $item->anchor );
			}

			$active = '';
			if ( '' === $item->anchor && ( ( 0 === $item->current && $depth ) || ( 0 === $item->current_item_ancestor && $depth ) ) ) :
				$active = 'dude-active-item';
			endif;

			$output .= $indent . '<li id="mobile-menu-item-' . $item->ID . '" class="' . $class_names . ' ' . $active . $sub . '">';

			$current_a = '';

			// Attributes.
			$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
			$attributes .= ' href="' . esc_attr( $item->url ) . $anchor . '"';

			if ( ( 0 === $item->current && $depth ) || ( 0 === $item->current_item_ancestor && $depth ) ) :
				$current_a .= ' current ';
			endif;
			if ( esc_attr( $item->url ) === '#' ) {
				$current_a .= ' dude-mobile-no-link';
			}

			$attributes .= ' class="' . $current_a . '"';
			$item_output = $args->before;
			if ( '' === $item->hide ) {
				if ( '' === $item->nolink ) {
					$item_output .= '<a' . $attributes . '>';
				} else {
					$item_output .= '<h6>';
				}
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
				$item_output .= $args->link_after;
				if ( '' === $item->nolink ) {
					$item_output .= '</a>';
				} else {
					$item_output .= '</h6>';
				}

				if ( $args->has_children ) {
					$item_output .= '<span class="mobil-nav-arrow">' . palamut_icons()->get( array( 'icon' => 'next-1 ' ) ) . '</span>';
				}
			}
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
endif;


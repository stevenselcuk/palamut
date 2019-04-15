<?php
/**
 * palamut Theme Customizer
 *
 * @package palamut
 */
 // Exit if accessed directly.
 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function palamut_customize_register( $wp_customize ) {

}
add_action( 'customize_register', 'palamut_customize_register', 12 );


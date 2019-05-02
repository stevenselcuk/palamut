<?php
/**
 * Theme Customizer functionality
 *
 * @package     Palamut Admin
 * @link        https://palamut.com/
 */

/**
 * Register the control types that we're using as JpalamutScript controls.
 *
 * @param WP_Customize_Manager $wp_customize the Customizer object.
 */
function prefix_register_control_types( $wp_customize ) {

	if ( class_exists( 'Palamut_Toggle_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Toggle_Control' );
	}

	if ( class_exists( 'Palamut_Title_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Title_Control' );
	}

	if ( class_exists( 'Palamut_Range_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Range_Control' );
	}

	if ( class_exists( 'Palamut_Layout_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_Layout_Control' );
	}

	if ( class_exists( 'Palamut_License_Control' ) ) {
		$wp_customize->register_control_type( 'Palamut_License_Control' );
	}
}

add_action( 'customize_register', 'prefix_register_control_types', 11 );

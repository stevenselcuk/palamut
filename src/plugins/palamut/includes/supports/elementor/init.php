<?php
/**
 * Elementor Widgets
 *
 * Shortcodes & Widget For Elementor
 *
 * @see https://developers.elementor.com
 *
 * @package Palamut
 *
 * @subpackage Supports
 * @category Theme Features
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

add_action( 'elementor/elements/categories_registered', 'register_palamut_category', 1 );
add_action( 'elementor/widgets/widgets_registered', 'register_widgets' );

/**
 * [register_palamut_category description]
 *
 * @method register_palamut_category
 *
 * @since
 *
 * @link
 */
function register_palamut_category() {
	\Elementor\Plugin::instance()->elements_manager->add_category(
		'palamut',
		array(
			'title' => __( 'Palamut Elements', 'palamut' ),
		),
		1
	);
}

/**
 * Autopilot for registering widget classes
 *
 * @method register_widgets
 *
 * @since 1.0.1
 *
 * @link
 */
function register_widgets() {
	if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
		if ( class_exists( 'Elementor\Plugin' ) ) {

			if ( is_callable( 'Elementor\Plugin', 'instance' ) ) {

				$elementor = \Elementor\Plugin::instance();
				if ( isset( $elementor->widgets_manager ) ) {
					if ( method_exists( $elementor->widgets_manager, 'register_widget_type' ) ) {
						$pala_widgets = array(
							'grid-posts',
						);
						foreach ( $pala_widgets as $widget_filename ) {
							$template_file = PALAMUT_PATH . '/includes/supports/elementor/inc/class-widget-palamut-' . $widget_filename . '.php';
							if ( $template_file && is_readable( $template_file ) ) {
								$class_name = str_replace( '-', '_', $widget_filename );
								$class_name = 'Elementor\Widget_Palamut_' . $class_name;
								include $template_file;
								\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
							}
						}
					}
				}
			}
		}
	}
}

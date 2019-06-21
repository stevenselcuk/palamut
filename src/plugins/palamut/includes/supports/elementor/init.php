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

defined( 'ABSPATH' ) || exit;

add_action( 'elementor/elements/categories_registered', 'register_palamut_category', 1 );
add_action( 'elementor/widgets/widgets_registered', 'register_widgets' );
add_action( 'elementor/frontend/before_enqueue_scripts', 'enqueue_elementor_scripts' );
add_action( 'wp_enqueue_scripts', 'enqueue_elementor_styles' );
add_action( 'elementor/editor/after_enqueue_styles', 'enqueue_elementor_styles' );

/**
 * [enqueue_elementor_scripts description]
 *
 * @method enqueue_elementor_scripts
 *
 * @return [type]
 */
function enqueue_elementor_scripts() {
	wp_enqueue_script( 'pala-elementor', PALAMUT_PATH_URL . '/includes/supports/elementor/assets/js/main.js', array( 'jquery', 'elementor-frontend' ), '1.0', true );
}

/**
 * [enqueue_elementor_styles description]
 *
 * @method enqueue_elementor_styles
 *
 * @return [type]
 */
function enqueue_elementor_styles() {
	wp_enqueue_style( 'pala-elementor', PALAMUT_PATH_URL . '/includes/supports/elementor/assets/css/main.css', array(), '1.0', 'all' );
}

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
		'palamut-elements',
		array(
			'title' => __( 'Palamut Elements', 'palamut' ),
			'icon'  => 'fa fa-plug',
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
							'funfact',
						);
						foreach ( $pala_widgets as $widget_filename ) {
							$template_file = PALAMUT_PATH . '/includes/supports/elementor/inc/class-palamut-' . $widget_filename . '.php';
							if ( $template_file && is_readable( $template_file ) ) {
								$class_name = str_replace( '-', '_', $widget_filename );
								$class_name = 'Elementor\Palamut_' . $class_name;
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

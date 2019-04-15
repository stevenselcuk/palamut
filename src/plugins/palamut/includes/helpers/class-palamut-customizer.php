<?php
/**
 * Palamut Customizer
 *
 * Increases usability of Kirki & WP Customizer API
 *
 * @uses Kirki (Located at /vendors)
 *
 * @see http://aristath.github.io/kirki/
 *
 * @package Palamut
 *
 * @subpackage Customizer
 * @category Core Functions
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
/**
 * [palamut_Customizer description]
 */
class Palamut_Customizer {
	/**
	 * Customizer settings
	 *
	 * @var array
	 */
	public $customizer_config = array();
	/**
	 * Declaration of palamut_Customizer Instance
	 *
	 * @var object
	 */
	public static $instance = null;
	/**
	 * Return an instance of palamut_Customizer
	 *
	 * @return    object    palamut_Customizer
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * The Magic Method for building palamut_Customizer
	 *
	 * @method __construct
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		require_once PALAMUT_PATH . 'includes/vendors/kirki/kirki.php';
		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}
		// Some kirki extensions.
		// require_once PALAMUT_PATH . 'includes/extensions/kirki-extensions/init.php';
		add_action( 'init', array( $this, 'register' ) );
		add_filter( 'kirki_telemetry', '__return_false' );
	}
	/**
	 * [register description]
	 *
	 * @method register
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $customizer_config [description].
	 */
	public function register( $customizer_config ) {
		$this->config = $customizer_config;
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'],
				array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}
				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}
	/**
	 * [get description]
	 *
	 * @method get
	 *
	 * @since
	 *
	 * @link
	 *
	 * @param  [type] $name [description].
	 *
	 * @return [type]       [description]
	 */
	public static function get( $name = null ) {
		$value = null;
		if ( null === $value || 'default' === $value ) {
			if ( class_exists( 'Kirki' ) ) {
				$value = Kirki::get_option( $name );
			} else {
				$value = get_theme_mod( $name, null );
			}
		}
		return $value;
	}
}

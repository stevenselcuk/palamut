<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Thesaas for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

/**
 * Palamut_register_required_plugins
 */
function palamut_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => 'Palamut for themename',
			'slug'               => 'palamut',
			'source'             => get_template_directory() . '/inc/plugins/trunk/palamut.zip',
			'required'           => true,
			'version'            => '1.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'     => esc_html__( 'WP Term Order', 'palamut' ),
			'slug'     => 'wp-term-order',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'palamut-tgmpa',
		'default_path' => '',
		'menu'         => 'palamut-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
		'strings'      => array(
			'page_title' => esc_html__( 'Palamut Recommended Plugins', 'palamut' ),
			'menu_title' => esc_html__( 'Install Plugins', 'palamut' ),
		),
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'palamut_register_required_plugins' );

/**
 * [palamut_activated_plugin description]
 *
 * @method palamut_activated_plugin
 *
 * @since
 *
 * @link
 *
 * @param  [type] $plugin No Desc.
 *
 * @return void
 */
function palamut_activated_plugin( $plugin ) {
	// Check if PVC constant is defined, use it to get PVC path anc compare to activated plugin.
	// if ( defined( 'POST_VIEWS_COUNTER_PATH' ) && plugin_basename( POST_VIEWS_COUNTER_PATH . 'post-views-counter.php' ) === $plugin ) {
		// Get display options.
		// $display_options = get_option( 'post_views_counter_settings_display' );
		// Set position value.
		// $display_options['position'] = 'manual';
		// Update options.
		// update_option( 'post_views_counter_settings_display', $display_options );
	// }.
}
add_action( 'activated_plugin', 'palamut_activated_plugin' );

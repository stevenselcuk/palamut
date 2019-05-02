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

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

/**
 * Palamut_register_required_plugins
 */
function prefix_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => 'Palamut for themename',
			'slug'               => 'textdomain',
			'source'             => get_template_directory() . '/inc/plugins/trunk/palamut.zip',
			'required'           => true,
			'version'            => '1.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'     => esc_html__( 'WooCommerce', 'textdomain' ),
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'WP Term Order', 'textdomain' ),
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
			'page_title' => esc_html__( 'Palamut Recommended Plugins', 'textdomain' ),
			'menu_title' => esc_html__( 'Install Plugins', 'textdomain' ),
		),
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'prefix_register_required_plugins' );

/**
 * [prefix_activated_plugin description]
 *
 * @method prefix_activated_plugin
 *
 * @since 1.0
 *
 * @param  [type] $plugin No Desc.
 *
 * @return void
 */
function prefix_activated_plugin( $plugin ) {
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
add_action( 'activated_plugin', 'prefix_activated_plugin' );

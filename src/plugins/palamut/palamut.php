<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://hevalandsteven.com
 * @since             1.0.0
 * @package           Palamut
 *
 * @wordpress-plugin
 * Plugin Name:       Palamut
 * Plugin URI:        palamut
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Steven J. Selcuk
 * Author URI:        https://hevalandsteven.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       palamut
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin Name
 */
define( 'PALAMUT_NAME', 'Palamut' );
/**
 * Friend Theme Name
 */
define( 'PALAMUT_THEME_NAME', wp_get_theme()->get( 'Name' ) );
/**
 * Currently plugin version.
 */
define( 'PALAMUT_VERSION', '1.0.0' );
/**
 * Plugin Path
 */
define( 'PALAMUT_PATH', plugin_dir_path( __FILE__ ) );
/**
 * Plugin URL
 */
define( 'PALAMUT_PATH_URL', plugin_dir_url( __FILE__ ) );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-palamut-activator.php
 */
function activate_palamut() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-palamut-activator.php';
	Palamut_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-palamut-deactivator.php
 */
function deactivate_palamut() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-palamut-deactivator.php';
	Palamut_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_palamut' );
register_deactivation_hook( __FILE__, 'deactivate_palamut' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-palamut.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_palamut() {

	$plugin = new Palamut();
	$plugin->run();

}
run_palamut();

/**
 * A Shorthand allowed tags array for using wpkses
 *
 * @method palamut_allowed_html()
 *
 * @since 1.0.0
 *
 * @return array Allowed tags
 */
function allowed_html() {
	return apply_filters(
		'palamut_allowed_html',
		array(
			'div'    => array( 'class' => array() ),
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
				'href'   => array(),
				'class'  => array(),
			),
			'span'   => array( 'class' => array() ),
			'h2'     => array(
				'class' => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array( 'class' => array() ),
			'i'      => array( 'class' => array() ),
			'img'    => array(
				'class' => array(),
				'title' => array(),
				'src'   => array(),
				'href'  => array(),
			),
			'time'   => array(
				'class'    => array(),
				'datetime' => array(),
			),
		)
	);
}

function category_list( $cat ) {
	$query_args = array(
		'orderby'    => 'ID',
		'order'      => 'DESC',
		'hide_empty' => 1,
		'taxonomy'   => $cat,
	);

	$categories = get_categories( $query_args );
	$options    = array( esc_html__( '0', 'palamut' ) => 'All Category' );
	if ( is_array( $categories ) && count( $categories ) > 0 ) {
		foreach ( $categories as $cat ) {
			$options[ $cat->term_id ] = $cat->name;
		}
		return $options;
	}
}

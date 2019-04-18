<?php
/**
 *  Demo Importer
 *
 * Theme spesific ready to take-off demos
 *
 * @uses OCDI
 *
 * @see https://github.com/proteusthemes/one-click-demo-import
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

add_action( 'pt-ocdi/after_import', 'palamut_theme_ocdi_after_import_setup' );
add_filter( 'pt-ocdi/plugin_page_title', 'palamut_theme_ocdi_page_title' );
add_filter( 'pt-ocdi/plugin_intro_text', 'palamut_theme_ocdi_plugin_intro_text' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
/**
 * Page Title
 */
function palamut_theme_ocdi_page_title() {
	return '<h1>' . esc_html__( 'Palamut Demos', 'palamut' ) . '</h1>';
}

/**
 * Intro Text
 *
 * @param string $default_text Default Intro Text.
 */
function palamut_theme_ocdi_plugin_intro_text( $default_text ) {
	ob_start(); ?>
	<div class="about-description">
		<p><?php esc_html_e( 'Clicking the Import Demo Data button will import demo posts, pages, categories, comments, tags and widgets.', 'palamut' ); ?></p>
		<p>
		<?php
		echo sprintf(
			wp_kses(
				// Translators: Demo import screen Intro text.
				__( 'You may switch between different Demos in the <a href="%s">Customize</a> section.', 'palamut' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			),
			esc_url( admin_url( 'customize.php' ) )
		);
		?>
		</p>
	</div>
	<?php
	return $default_text = ob_get_clean();
}

/**
 * [palamut_theme_ocdi_import_files description]
 *
 * @method palamut_theme_ocdi_import_files
 *
 * @since
 *
 * @link
 *
 * @return [type]                      [description]
 */
function palamut_theme_ocdi_import_files() {
	return array(
		array(
			'import_file_name'           => esc_html__( 'Palamut Light', 'palamut' ),
			'import_file_url'            => esc_url( PALAMUT_PATH_URL . 'includes/demos/options/light/content.xml' ),
			'import_widget_file_url'     => esc_url( PALAMUT_PATH_URL . 'includes/demos/options/light/widgets.wie' ),
			'import_customizer_file_url' => esc_url( PALAMUT_PATH_URL . 'includes/demos/options/light/customizer.dat' ),
			'import_preview_image_url'   => esc_url( PALAMUT_PATH_URL . 'includes/demos/options/light/screenshot.png' ),
			'import_notice'              => esc_html__( 'Before importing demo data you must have to install required plugins', 'palamut' ),
	 // 'preview_url'                => esc_url( 'http://palamut.softhopper.net' ),
		),
		array(
			'import_file_name'           => esc_html__( 'Palamut Dark', 'palamut' ),
			'import_file_url'            => esc_url( PALAMUT_PATH_URL . 'includes/demos/options/dark/content.xml' ),
			'import_widget_file_url'     => esc_url( PALAMUT_PATH_URL . 'includes/demos/options/dark/widgets.wie' ),
			'import_customizer_file_url' => esc_url( PALAMUT_PATH_URL . 'includes/demos/options/dark/customizer.dat' ),
			'import_preview_image_url'   => esc_url( PALAMUT_PATH_URL . 'includes/demos/options/dark/screenshot.png' ),
			'import_notice'              => esc_html__( 'Before importing demo data you must have to install required plugins', 'palamut' ),
	 // 'preview_url'                => esc_url( 'http://palamut.softhopper.net/dark' ),
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'palamut_theme_ocdi_import_files' );

/**
 * [palamut_theme_ocdi_after_import_setup description]
 *
 * @method palamut_theme_ocdi_after_import_setup
 *
 * @since
 *
 * @link
 *
 * @param  [type] $selected_import [description].
 */
function palamut_theme_ocdi_after_import_setup( $selected_import ) {

	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

	set_theme_mod(
		'nav_menu_locations',
		array(
			'primary-menu' => $main_menu->term_id,
		)
	);

	if ( 'Palamut Light Version' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'Home Light' );
		$blog_page_id  = get_page_by_title( 'Blog' );
	} elseif ( 'Palamut Dark Version' === $selected_import['import_file_name'] ) {
		$front_page_id = get_page_by_title( 'Home Dark' );
		$blog_page_id  = get_page_by_title( 'Blog' );
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'palamut_theme_ocdi_after_import_setup' );

/**
 * [palamut_theme_ocdi_plugin_page_setup description]
 *
 * @method palamut_theme_ocdi_plugin_page_setup
 *
 * @since
 *
 * @link
 *
 * @param  [type] $default_settings [description].
 *
 * @return [type]                                             [description]
 */
function palamut_theme_ocdi_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'Palamut Demo Importer', 'palamut' );
	$default_settings['menu_title']  = esc_html__( 'Palamut Demos', 'palamut' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'palamut-importer';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'palamut_theme_ocdi_plugin_page_setup' );

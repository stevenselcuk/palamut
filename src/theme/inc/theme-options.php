<?php
/**
 * Palamut Theme Options
 *
 * Initial Customizer Build with Pdw_Customizer Class
 *
 * @link to be defined
 *
 * @package pdwname
 *
 * @subpackage Core
 * @category Customizer
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

if ( class_exists( 'Palamut_Customizer' ) ) :
	/**
	 * Returns the main instance of Pdw_Customizer to prevent the need to use globals.
	 *
	 * @method palamut_customize()->do_stuff
	 *
	 * @uses Palamut/Bestman_Customizer
	 *
	 * @since 1.0.2
	 */
	function palamut_customize() {
		return Palamut_Customizer::instance();
	}

	/*
	* Register it
	*/
	palamut_customize()->register( palamut_theme_options() );
endif;
/**
 * [palamut_theme_options description]
 *
 * @method palamut_theme_options
 *
 * @since
 *
 * @return array  $customizer_config Theme spesific customizer fields,panels & sections
 */
function palamut_theme_options() {
	global $customizer_config;
	$priority = 1;
	if ( ! $customizer_config ) {
		$customizer_config = apply_filters(
			'palamut_theme_options',
			array(
				// Register : Customizer.
				'theme'    => PALA_THEME_NAME,
				// Registering our Panel.
				'panels'   => array(
					'general'                => array(
						'title'    => esc_html__( 'General Settings', 'palamut' ),
						'priority' => $priority++,
					),

					'typography'             => array(
						'title'    => esc_html__( 'Typography Settings', 'palamut' ),
						'priority' => $priority++,
					),

					'layout'                 => array(
						'title'    => esc_html__( 'Layout Settings', 'palamut' ),
						'priority' => $priority++,
					),

					'palamut_theme_settings' => array(
						'title'    => PALA_THEME_NAME . esc_html__( ' Settings', 'palamut' ),
						'priority' => $priority++,
					),

				),
				// Theme Option Sections.
				'sections' => array(

					'navigation_typography' => array(
						'title'      => esc_html__( 'Navigation Typography', 'palamut' ),
						'priority'   => $priority++,
						'capability' => 'edit_theme_options',
						'panel'      => 'typography',
					),

					'heading_typography'    => array(
						'title'      => esc_html__( 'Heading Typography', 'palamut' ),
						'priority'   => $priority++,
						'capability' => 'edit_theme_options',
						'panel'      => 'typography',
					),

					'body_typography'       => array(
						'title'      => esc_html__( 'Body Typography', 'palamut' ),
						'priority'   => $priority++,
						'capability' => 'edit_theme_options',
						'panel'      => 'typography',
					),

					'header_section'        => array(
						'title'       => esc_html__( 'Header', 'palamut' ),
						'description' => 'You can change your header menu settings in here...',
						'priority'    => $priority++,
						'capability'  => 'edit_theme_options',
						'panel'       => 'layout',
					),
					'content_section'       => array(
						'title'       => esc_html__( 'Content', 'palamut' ),
						'description' => '',
						'priority'    => $priority++,
						'capability'  => 'edit_theme_options',
						'panel'       => 'layout',
					),
					'footer_section'        => array(
						'title'       => esc_html__( 'Footer', 'palamut' ),
						'description' => '',
						'priority'    => $priority++,
						'capability'  => 'edit_theme_options',
						'panel'       => 'layout',
					),
				),
				// Option Fields.
				'fields'   => array(

					// Backend location: (Native).
					'heading_typography_settings'    => array(
						'type'        => 'typography',
						'settings'    => 'heading_typography_settings',
						'label'       => esc_html__( 'Heading Typography', 'palamut' ),
						'description' => esc_html__( 'You can change font family and color in here.', 'palamut' ),
						'section'     => 'heading_typography',
						'default'     => array(
							'font-family' => 'Roboto',
							'variant'     => '800',
						),
						'choices'     => [
							'google' => [ 'popularity', 50 ],
						],
						'output'      => [
							[
								'choice'   => 'font-family',
								'element'  => ':root',
								'property' => '--heading-fontfamily',
							],
						],
					),

					'heading_color'                  => array(
						'type'     => 'color-palette',
						'settings' => 'palette_setting',
						'label'    => esc_html__( 'Heading Color', 'palamut' ),
						'section'  => 'heading_typography',
						'default'  => '#20201F',
						'choices'  => array(
							'colors' => array( '#20201F', '#000000', '#6515DD', '#3E09A2', '#4AFBDC', '#FFBE33', '#F838DF', '#60FDB0', '#2E3032', '#858585' ),
							'style'  => 'round',
							'size'   => 32,
						),
						'output'   => [
							[
								'choice'   => 'color',
								'element'  => ':root',
								'property' => '--heading-color',
							],
						],
					),

					'body-typography-settings'       => array(
						'type'        => 'typography',
						'settings'    => 'body-typography-settings',
						'label'       => esc_html__( 'Content Typography', 'palamut' ),
						'description' => esc_html__( 'You can change font family and color in here.', 'palamut' ),
						'section'     => 'body_typography',
						'default'     => array(
							'font-family' => 'Roboto',
							'variant'     => '800',
						),
						'choices'     => [
							'google' => [ 'popularity', 50 ],
						],
						'output'      => [
							[
								'choice'   => 'font-family',
								'element'  => ':root',
								'property' => '--body-text-fontfamily',
							],
						],
					),

					'body-text-color'                => array(
						'type'     => 'color-palette',
						'settings' => 'body-text-color',
						'label'    => esc_html__( 'Content Text Color', 'palamut' ),
						'section'  => 'body_typography',
						'default'  => '#0F2442',
						'choices'  => array(
							'colors' => array( '#002A41', '#000000', '#D6D5CF', '#22262D', '#17181C', '#1F232A', '#414042', '#7A7C7F', '#ECECEC', '#B1BFCB' ),
							'style'  => 'round',
							'size'   => 32,
						),
						'output'   => [
							[
								'choice'   => 'color',
								'element'  => ':root',
								'property' => '--body-text-color',
							],
						],
					),

					// Backend location: (Native).
					// Adjust Site Logo Size.
					'site-logo-size'                 => array(
						'type'            => 'slider',
						'settings'        => 'site-logo-width',
						'label'           => esc_html__( 'Logo Size (px)', 'palamut' ),
						'tooltip'         => esc_html__( 'You can adjust your logo width (in px)', 'palamut' ),
						'section'         => 'header_section',
						'priority'        => 3,
						'transport'       => 'postMessage',
						'default'         => 100,
						'active_callback' => 'palamut_has_custom_logo',
						'choices'         => [
							'min'  => 32,
							'max'  => 200,
							'step' => 1,
						],
						'css_vars'        => array(
							array( '--site-logo-height', '$px' ),
						),
					),

					// Adjust Site Title Font Size.
					'site-title-fontsize'            => array(
						'type'            => 'slider',
						'settings'        => 'site-title-fontsize',
						'label'           => esc_html__( 'Site Title Font Size (px)', 'palamut' ),
						'tooltip'         => esc_html__( 'You can change your site title font size (in px)', 'palamut' ),
						'section'         => 'header_section',
						'priority'        => 6,
						'transport'       => 'postMessage',
						'default'         => 42,
						'active_callback' => function() {
							if ( ! has_custom_logo() ) :
									return true;
							endif;
						},
						'choices'         => [
							'min'  => 18,
							'max'  => 65,
							'step' => 1,
						],
						'css_vars'        => array(
							array( '--site-title-fontsize', '$px' ),
						),
					),

					// Backend location: (Native).
					'header-width'                   => array(
						'type'      => 'slider',
						'settings'  => 'header-width',
						'label'     => esc_html__( 'Header Width (px)', 'palamut' ),
						'tooltip'   => esc_html__( 'You can change your page width (in px)', 'palamut' ),
						'section'   => 'header_section',
						'priority'  => $priority++,
						'transport' => 'postMessage',
						'default'   => 1100,
						'choices'   => [
							'min'  => 600,
							'max'  => 1800,
							'step' => 20,
						],
						'css_vars'  => array(
							array( '--header-width', '$px' ),
						),
					),

					'navigation-typography-settings' => array(
						'type'        => 'typography',
						'settings'    => 'navigation-typography-settings',
						'label'       => esc_html__( 'Menu Typography', 'palamut' ),
						'description' => esc_html__( 'You can change font family and color in here.', 'palamut' ),
						'section'     => 'header_section',
						'default'     => array(
							'font-family' => 'Roboto',
							'variant'     => '800',
						),
						'choices'     => [
							'google' => [ 'popularity', 50 ],
						],
						'output'      => [
							[
								'choice'   => 'font-family',
								'element'  => ':root',
								'property' => '--menu-item-fontfamily',
							],
						],
					),

					'menu-item-text-color'           => array(
						'type'     => 'color-palette',
						'settings' => 'menu-item-text-color',
						'label'    => esc_html__( 'Menu Item Text Color', 'palamut' ),
						'section'  => 'header_section',
						'default'  => '#6515DD',
						'choices'  => array(
							'colors' => array( '#6515DD', '#60FDB0', '#000000', '#D6D5CF', '#22262D', '#17181C', '#1F232A', '#414042', '#7A7C7F', '#ECECEC', '#B1BFCB' ),
							'style'  => 'round',
							'size'   => 32,
						),
						'output'   => [
							[
								'choice'   => 'color',
								'element'  => ':root',
								'property' => '--menu-item-fontcolor',
							],
						],
					),

					'menu-item-hover-text-color'     => array(
						'type'     => 'color-palette',
						'settings' => 'menu-item-hover-text-color',
						'label'    => esc_html__( 'Menu Item Hover Text Color', 'palamut' ),
						'section'  => 'header_section',
						'default'  => '#60FDB0',
						'choices'  => array(
							'colors' => array(  '#6515DD', '#60FDB0', '#000000', '#D6D5CF', '#22262D', '#17181C', '#1F232A', '#414042', '#7A7C7F', '#ECECEC', '#B1BFCB' ),
							'style'  => 'round',
							'size'   => 32,
						),
						'output'   => [
							[
								'choice'   => 'color',
								'element'  => ':root',
								'property' => '--menu-item-fontcolor__hover',
							],
						],
					),

					'header-bg-color'                => array(
						'type'     => 'color-palette',
						'settings' => 'header-bg-color',
						'label'    => esc_html__( 'Header Background Color', 'palamut' ),
						'section'  => 'header_section',
						'default'  => '#0F2442',
						'choices'  => array(
							'colors' => array( '#F4F5EF', '#D6D5CF', '#22262D', '#17181C', '#1F232A', '#414042', '#7A7C7F', '#ECECEC', '#B1BFCB' ),
							'style'  => 'round',
							'size'   => 32,
						),
						'output'   => [
							[
								'choice'   => 'color',
								'element'  => ':root',
								'property' => '--header-bg-color',
							],
						],
					),

					// Adjust Site Title Font Size.
					'menu-item-fontsize'             => array(
						'type'      => 'slider',
						'settings'  => 'menu-item-fontsize',
						'label'     => esc_html__( 'Menu Item Font Size (px)', 'palamut' ),
						'tooltip'   => esc_html__( 'You can change your menu item font size (in px)', 'palamut' ),
						'section'   => 'header_section',
						'priority'  => $priority++,
						'transport' => 'postMessage',
						'default'   => 14,
						'choices'   => [
							'min'  => 8,
							'max'  => 24,
							'step' => 1,
						],
						'css_vars'  => array(
							array( '--menu-item-fontsize', '$px' ),
						),
					),

					'show-search'                    => array(
						'type'     => 'toggle',
						'settings' => 'show-search',
						'label'    => esc_html__( 'Show Search From', 'palamut' ),
						'tooltip'  => esc_html__( 'or dont show...', 'palamut' ),
						'section'  => 'header_section',
						'priority' => $priority++,
						'default'  => false,
					),

					'boxed-page'                     => array(
						'type'     => 'toggle',
						'settings' => 'boxed-page',
						'label'    => esc_html__( 'Enable boxed page', 'palamut' ),
						'tooltip'  => esc_html__( 'or full page', 'palamut' ),
						'section'  => 'content_section',
						'priority' => $priority++,
						'default'  => false,
					),

					'page-width'                     => array(
						'type'            => 'slider',
						'settings'        => 'page-width',
						'label'           => esc_html__( 'Page Width (px)', 'palamut' ),
						'tooltip'         => esc_html__( 'You can change your page width (in px)', 'palamut' ),
						'section'         => 'content_section',
						'priority'        => $priority++,
						'transport'       => 'postMessage',
						'default'         => 740,
						'active_callback' => array(
							array(
								'setting'  => 'boxed-page',
								'operator' => '==',
								'value'    => true,
							),
						),
						'choices'         => [
							'min'  => 600,
							'max'  => 1200,
							'step' => 20,
						],
						'css_vars'        => array(
							array( '--content-width', '$px' ),
						),
					),

					'is-header-sticky'               => array(
						'type'      => 'toggle',
						'settings'  => 'is-header-sticky',
						'label'     => esc_html__( 'Sticky Header', 'palamut' ),
						'tooltip'   => esc_html__( 'or not?', 'palamut' ),
						'section'   => 'header_section',
						'priority'  => $priority++,
						'default'   => false,
						'transport' => 'refresh',
					),

					'show-footer'                    => array(
						'type'      => 'toggle',
						'settings'  => 'show-footer',
						'label'     => esc_html__( 'Show footer section', 'palamut' ),
						'tooltip'   => esc_html__( 'If there is a active widget, overrides this option.', 'palamut' ),
						'section'   => 'footer_section',
						'priority'  => $priority++,
						'default'   => true,
						'transport' => 'refresh',
					),

					'show-bottombar'                 => array(
						'type'      => 'toggle',
						'settings'  => 'show-bottombar',
						'label'     => esc_html__( 'Show bottombar section', 'palamut' ),
						'tooltip'   => esc_html__( 'or not?', 'palamut' ),
						'section'   => 'footer_section',
						'priority'  => $priority++,
						'default'   => true,
						'transport' => 'refresh',
					),

					'copyright-text'                 => array(
						'type'            => 'editor',
						'settings'        => 'copyright-text',
						'label'           => esc_html__( 'Copyright Text', 'palamut' ),
						'tooltip'         => esc_html__( 'Default is Year All right reserved.', 'palamut' ),
						'section'         => 'footer_section',
						'priority'        => $priority++,
						'transport'       => 'auto',
						'default'         => 'Copyright &copy; All rights reserved.',
						'active_callback' => array(
							array(
								'setting'  => 'show-bottombar',
								'operator' => '==',
								'value'    => true,
							),
						),
					),
				),
			)
		);
	}
	return $customizer_config;
}


/**
 * [palamut_wp_customizer_modifier description]
 *
 * @method palamut_wp_customizer_modifier
 *
 * @since
 *
 * @link
 *
 * @param  object $wp_customize You know it! It's a celebrity. Like grumpy cat.
 */
function palamut_wp_customizer_modifier( $wp_customize ) {
	global  $wp_customize;
	$wp_customize->get_section( 'title_tagline' )->panel        = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel    = 'general';
	$wp_customize->get_section( 'background_image' )->panel     = 'general';
	$wp_customize->get_section( 'colors' )->panel               = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel    = 'general';
	$wp_customize->get_section( 'header_image' )->panel         = 'general';
	$wp_customize->get_control( 'custom_logo' )->priority       = 'postMessage';
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_control( 'site_icon' )->priority         = 1;
	$wp_customize->get_control( 'custom_logo' )->priority       = 2;
	$wp_customize->get_control( 'blog_name' )->priority         = 4;
	$wp_customize->get_section( 'title_tagline' )->title        = esc_html__( 'Site Logo and Favicon', 'palamut' );
	$wp_customize->selective_refresh->add_partial(
		'blogname',
		array(
			'selector'        => '.site-title a',
			'settings'        => array( 'blogname' ),
			'render_callback' => 'palamut_customize_partial_blogname',
		)
	);
}
add_action( 'customize_register', 'palamut_wp_customizer_modifier' );
/**
 * Pdw-framework Styling Options
 *
 * @method palamut_palamut_customizer_modifier
 *
 * @since 1.0.2
 *
 * @link https://aristath.github.io/palamut/docs/modules/customizer-styling.html
 *
 * @param  array $config The palamut styling config.
 */
function palamut_customizer_modifier( $config ) {
		return wp_parse_args(
			array(
				// 'logo_image'     => PALA_THEME_DIR_URL . '/assets/img/customizer.png',
													'description' => PALA_THEME_NAME . ' ver. ' . PALA_THEME_VERSION,
				// 'color_accent'   => '#00F2A5',
				// 'color_back'     => '#252525',
					'disable_loader' => true,
			),
			$config
		);
}
add_filter( 'kirki/config', 'palamut_customizer_modifier' );

/**
 * [palamut_has_custom_logo description]
 *
 * @method palamut_has_custom_logo
 *
 * @since
 *
 * @link
 *
 * @see
 *
 * @return boolean
 */
function palamut_has_custom_logo() {
	if ( has_custom_logo() ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @see palamut_customize_register()
 *
 * @return void
 */
function palamut_customize_partial_blogname() {
	bloginfo( 'name' );
}

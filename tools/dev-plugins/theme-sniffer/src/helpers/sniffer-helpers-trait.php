<?php
/**
 * The helpers trait file
 *
 * @since   1.0.0
 * @package Theme_Sniffer\Helpers
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Helpers;

use Theme_Sniffer\Api\Template_Tags_Request;
use Theme_Sniffer\Exception\No_Themes_Present;

/**
 * Sniffer helpers trait
 *
 * This trait contains some helper methods
 */
trait Sniffer_Helpers {
	/**
	 * Returns standards
	 *
	 * Includes a 'theme_sniffer_add_standards' filter, so that user can add their own standard. The standard has to be added
	 * in the composer before bundling the plugin.
	 *
	 * @since 1.0.0 Added filter so that user can add their own standards. Moved to a trait.
	 * @since 0.1.3
	 *
	 * @return array Standards details.
	 */
	public function get_wpcs_standards() : array {
		$standards = [
			'wordpress-theme' => [
				'label'       => 'WPThemeReview',
				'description' => esc_html__( 'Ruleset for WordPress theme review requirements (Required)', 'theme-sniffer' ),
				'default'     => 1,
			],
			'wordpress-core'  => [
				'label'       => 'WordPress-Core',
				'description' => esc_html__( 'Main ruleset for WordPress core coding standards (Optional)', 'theme-sniffer' ),
				'default'     => 0,
			],
			'wordpress-extra' => [
				'label'       => 'WordPress-Extra',
				'description' => esc_html__( 'Extended ruleset for recommended best practices (Optional)', 'theme-sniffer' ),
				'default'     => 0,
			],
			'wordpress-docs'  => [
				'label'       => 'WordPress-Docs',
				'description' => esc_html__( 'Additional ruleset for WordPress inline documentation standards (Optional)', 'theme-sniffer' ),
				'default'     => 0,
			],
			'wordpress-vip'   => [
				'label'       => 'WordPress-VIP',
				'description' => esc_html__( 'Extended ruleset for WordPress VIP coding requirements (Optional)', 'theme-sniffer' ),
				'default'     => 0,
			],
		];

		if ( has_filter( 'theme_sniffer_add_standards' ) ) {
			$standards = apply_filters( 'theme_sniffer_add_standards', $standards );
		}

		return $standards;
	}

	/**
	 * Return all the active themes
	 *
	 * @since  1.0.0 Moved to a trait.
	 *
	 * @throws Api_Response_Error If API is down.
	 * @return array Array of active themes.
	 */
	public function get_active_themes() : array {
		$all_themes   = wp_get_themes();
		$active_theme = ( wp_get_theme() )->get( 'Name' );

		if ( empty( $all_themes ) ) {
			throw No_Themes_Present::message(
				esc_html__( 'No themes present in the themes directory.', 'theme-sniffer' )
			);
		}

		$themes = [];
		foreach ( $all_themes as $theme_slug => $theme ) {
			$theme_name    = $theme->get( 'Name' );
			$theme_version = $theme->get( 'Version' );

			if ( $theme_name === $active_theme ) {
				$theme_name = "(Active) $theme_name";
			}

			$themes[ $theme_slug ] = "$theme_name - v$theme_version";

		}

		return $themes;
	}

	/**
	 * Returns PHP versions.
	 *
	 * @since 1.0.0 Added PHP 7.x versions. Moved to a trait.
	 * @since 0.1.3
	 *
	 * @return array PHP versions.
	 */
	public function get_php_versions() : array {
		return [
			'5.2',
			'5.3',
			'5.4',
			'5.5',
			'5.6',
			'7.0',
			'7.1',
			'7.2',
			'7.3',
		];
	}

	/**
	 * Returns theme tags.
	 *
	 * @since 1.0.0 Moved to a trait and refactored to use tags from API.
	 * @since 0.1.3
	 *
	 * @return array Theme tags array.
	 */
	public function get_theme_tags() : array {

		return get_transient( Template_Tags_Request::TEMPLATE_TRANSIENT );
	}

	/**
	 * Helper method that returns the default stnadard
	 *
	 * @since 1.0.0
	 * @return string Name of the default standard.
	 */
	public function get_default_standard() : string {
		return 'WPThemeReview';
	}

	/**
	 * Helper method to get a list of required headers
	 *
	 * @since 1.0.0
	 * @return array List of required headers.
	 */
	public function get_required_headers() {
		return [
			'Name',
			'Description',
			'Author',
			'Version',
			'License',
			'License URI',
			'TextDomain',
		];
	}
}

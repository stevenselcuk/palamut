<?php
/**
 * Requests service for getting template tags
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Api
 */

namespace Theme_Sniffer\Api;

use Theme_Sniffer\Core\Service;
use Theme_Sniffer\Exception;

/**
 * Class that will handle getting template tags and setting them in a transient.
 */
class Template_Tags_Request implements Service {
	/**
	 * URL of template tags API
	 */
	const TEMPLATE_API_URL = 'https://api.wordpress.org/themes/info/1.1/?action=feature_list';

	const TEMPLATE_TRANSIENT = 'template_tags';

	/**
	 * Register the service.
	 */
	public function register() {
		add_action( 'init', [ $this, 'check_template_tags' ] );
	}

	/**
	 * Checks the WordPress API for the template tags and stores them in a transient
	 */
	public function check_template_tags() {
		if ( get_transient( self::TEMPLATE_TRANSIENT ) === false ) {
			$tags = $this->get_template_tags();

			set_transient( self::TEMPLATE_TRANSIENT, $tags, DAY_IN_SECONDS );
		}
	}

	/**
	 * Method that calls the wordpress.org API
	 *
	 * Calls and returns the list of template tags, categorized like in the API
	 * response.
	 *
	 * @throws Api_Response_Error If API is down.
	 * @return array Array of allowed template tags.
	 */
	private function get_template_tags() {
		$tags_response = wp_remote_get( self::TEMPLATE_API_URL );

		if ( is_wp_error( $tags_response ) ) {
			throw Api_Response_Error::message( $tags_response->get_error_message() );
		}

		$tags_decoded = json_decode( wp_remote_retrieve_body( $tags_response ), true );

		return [
			'subject_tags' => $tags_decoded['Subject'],
			'allowed_tags' => array_merge(
				...array_values(
					array_diff_key( $tags_decoded, array_flip( [ 'Subject' ] ) )
				)
			),
		];
	}
}

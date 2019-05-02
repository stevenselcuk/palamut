<?php
/**
 * File containing the invalid service exception class
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Exception
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Exception;

/**
 * Class Invalid_Service.
 */
class Invalid_Service extends \InvalidArgumentException implements General_Exception {

	/**
	 * Create a new instance of the exception for a service class name that is
	 * not recognized.
	 *
	 * @param string $service Class name of the service that was not recognized.
	 *
	 * @return static
	 */
	public static function from_service( $service ) {
		$message = sprintf(
			// translators: Name of the service.
			esc_html__( 'The service "%s" is not recognized and cannot be registered.', 'theme-sniffer' ),
			is_object( $service )
			? get_class( $service )
			: (string) $service
		);

		return new static( $message );
	}
}

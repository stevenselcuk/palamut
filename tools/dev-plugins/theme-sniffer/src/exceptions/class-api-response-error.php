<?php
/**
 * File containing the failure exception class when API call fails
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Exception
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Exception;

/**
 * Class Api_Response_Error.
 */
class Api_Response_Error extends \ErrorException implements General_Exception {

	/**
	 * Create a new instance of the exception in case
	 * an API call fails.
	 *
	 * @param string $message Error message to show on
	 * thrown exception.
	 *
	 * @return static
	 */
	public static function message( $message ) {
		return new static( $message );
	}
}

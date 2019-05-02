<?php
/**
 * File containing the plugin activation failure exception class
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Exception
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Exception;

/**
 * Class Plugin_Activation_Failure.
 */
class Plugin_Activation_Failure extends \RuntimeException implements General_Exception {

	/**
	 * Create a new instance of the exception in case plugin cannot be activated.
	 *
	 * @param string $message Error message to show on plugin activation failure.
	 *
	 * @return static
	 */
	public static function activation_message( $message ) {
		return new static( $message );
	}
}

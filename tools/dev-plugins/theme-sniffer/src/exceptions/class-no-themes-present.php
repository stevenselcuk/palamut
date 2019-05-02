<?php
/**
 * File containing the failure exception class when there are no themes present in the themes folder
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Exception
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Exception;

/**
 * Class No_Themes_Present.
 */
class No_Themes_Present extends \OutOfRangeException implements General_Exception {

	/**
	 * Create a new instance of the exception in case
	 * there are no themes in the wp-config/themes folder.
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

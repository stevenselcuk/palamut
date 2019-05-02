<?php
/**
 * File containing failed to load view class
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Exception
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Exception;

/**
 * Class Failed_To_Load_View.
 */
class Failed_To_Load_View extends \RuntimeException implements General_Exception {

	/**
	 * Create a new instance of the exception if the view file itself created
	 * an exception.
	 *
	 * @param string     $uri       URI of the file that is not accessible or
	 *                              not readable.
	 * @param \Exception $exception Exception that was thrown by the view file.
	 *
	 * @return static
	 */
	public static function view_exception( $uri, $exception ) {
		$message = sprintf(
			// translators: Name of the view URI.
			esc_html__( 'Could not load the View URI "%1$s". Reason: "%2$s".', 'theme-sniffer' ),
			$uri,
			$exception->getMessage()
		);

		return new static( $message, $exception->getCode(), $exception );
	}
}

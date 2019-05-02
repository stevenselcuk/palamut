<?php
/**
 * File that holds the invokable interface.
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Core
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Callback;

/**
 * Interface Invokable.
 *
 * An object that can be invoked or called (AJAX callback).
 */
interface Invokable {
	/**
	 * Callback of the current Invokable.
	 */
	public function callback();
}

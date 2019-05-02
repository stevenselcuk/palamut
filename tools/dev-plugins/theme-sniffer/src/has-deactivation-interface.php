<?php
/**
 * * File that holds Has_Deactivation interface
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Core
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Core;

/**
 * Interface Has_Deactivation.
 *
 * An object that can be deactivated.
 *
 * @since 1.0.0
 */
interface Has_Deactivation {
	/**
	 * Deactivate the service.
	 *
	 * Can be used to remove parts of the functionality defined by certain service.
	 *
	 * Examples: remove_role, remove_cap, flush_rewrite_rules etc.
	 *
	 * @return void
	 */
	public function deactivate();
}

<?php
/**
 * File containing the asset interface
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Assets
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Assets;

use Theme_Sniffer\Core\Registerable;

/**
 * Asset interface.
 */
interface Asset extends Registerable {

	/**
	 * Enqueue the asset.
	 *
	 * @return void
	 */
	public function enqueue();

	/**
	 * Get the handle of the asset.
	 *
	 * @return string
	 */
	public function get_handle();
}

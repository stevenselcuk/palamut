<?php
/**
 * File containing the assets handler class
 *
 * @since 1.0.0
 * @package Theme_Sniffer\Assets
 */

declare( strict_types=1 );

namespace Theme_Sniffer\Assets;

use Theme_Sniffer\Exception\Invalid_Asset_Handle;
use Theme_Sniffer\Core\Registerable;

/**
 * Class Assets_Handler.
 */
final class Assets_Handler implements Registerable {

	/**
	 * Assets known to this asset handler.
	 *
	 * @var array<Asset>
	 */
	private $assets = [];

	/**
	 * Add a single asset to the asset handler.
	 *
	 * @param Asset $asset Asset to add.
	 */
	public function add( Asset $asset ) {
		$this->assets[ $asset->get_handle() ] = $asset;
	}

	/**
	 * Register the current Registerable.
	 *
	 * @return void
	 */
	public function register() {
		foreach ( $this->assets as $asset ) {
			$asset->register();
		}
	}

	/**
	 * Enqueue a single asset based on its handle.
	 *
	 * @param string $handle Handle of the asset to enqueue.
	 *
	 * @throws Invalid_Asset_Handle If the passed-in asset handle is not valid.
	 */
	public function enqueue_handle( $handle ) {
		if ( ! array_key_exists( $handle, $this->assets ) ) {
			throw Invalid_Asset_Handle::from_handle( $handle );
		}

		$this->assets[ $handle ]->enqueue();
	}

	/**
	 * Enqueue all assets known to this asset handler.
	 *
	 * @param Asset|null $asset Optional. Asset to enqueue.
	 *                          If omitted, all known assets are enqueued.
	 */
	public function enqueue( Asset $asset = null ) {
		$assets = $asset ? [ $asset ] : $this->assets;

		foreach ( $assets as $asset_object ) {
			$asset_object->enqueue();
		}
	}
}

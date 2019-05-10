/* global jQuery */
/* global wp */
( function( $, api ) {
	'use strict';

	/* === Select Multiple Control === */
	api.controlConstructor[ 'prefix-multiple-select' ] = api.Control.extend(
		{
			ready: function() {
				const control = this;

				$( '.selectize' ).selectize( {} );

				$( 'select', control.container ).change(
					function() {
						const value = $( this ).val();

						if ( null === value ) {
							control.setting.set( '' );
						} else {
							control.setting.set( value );
						}
					}
				);
			},
		}
	);
}( jQuery, wp.customize ) );

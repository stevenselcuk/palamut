( function( $, api ) {
	api.controlConstructor[ 'palamut-range' ] = api.Control.extend( {

		ready: function() {
			const control = this;

			this.container.on( 'change', 'input[data-input-type="range"]', function() {
				value = $( this ).val();
				$( this ).prev( '.palamut-range__value' ).find( 'span' ).html( value );
				control.setting.set( value );
			} );

			$( '.palamut-range__reset' ).on( 'click', function() {
				const
					input = $( this ).prev( $( 'input[data-input-type="range"]' ) ),
					defaultValue = input.data( 'default-value' );

				input.val( defaultValue );

				const value = input.val();
				input.prev( '.palamut-range__value' ).find( 'span' ).html( value );
				input.change();
			} );
		},
	} );
}( jQuery, wp.customize ) );

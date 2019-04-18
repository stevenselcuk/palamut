( function( $, api ) {
	api.controlConstructor[ 'palamut-toggle' ] = api.Control.extend( {

		ready: function() {
			const control = this;

			this.container.on( 'change', 'input:checkbox', function() {
				value = this.checked ? true : false;
				control.setting.set( value );
				control.container.find( '.components-form-toggle' ).toggleClass( 'is-checked' );

				if ( this.checked ) {
					control.container.find( '.components-form-toggle__off' ).remove();
					control.container.find( '.components-base-control__help--has-toggled-description' ).find( '.toggle--on' ).removeClass( 'hidden' );
					control.container.find( '.components-base-control__help--has-toggled-description' ).find( '.toggle--off' ).addClass( 'hidden' );
				} else {
					control.container.find( '.components-form-toggle__on' ).remove();
					control.container.find( '.components-base-control__help--has-toggled-description' ).find( '.toggle--on' ).addClass( 'hidden' );
					control.container.find( '.components-base-control__help--has-toggled-description' ).find( '.toggle--off' ).removeClass( 'hidden' );
				}
			} );
		},
	} );
}( jQuery, wp.customize ) );

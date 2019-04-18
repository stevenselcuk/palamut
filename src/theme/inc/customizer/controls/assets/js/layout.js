( function( $, api ) {

	api.controlConstructor['palamut-layout'] = api.Control.extend( {

		ready: function() {
			var control = this;

			this.container.on( 'change', 'input:radio', function() {
				control.setting.set( $( this ).val() );
			} );

			this.container.on( 'click', '.layout-switcher', function(e) {

				var wrapper = $( this ).next( $( '.layout-switcher__wrapper' ) );

				e.preventDefault();

				wrapper.toggleClass( 'open' );

				if ( $( this ).text() === palamutLocalization.open ) {
					$( this ).text( palamutLocalization.close );
				} else {
					$( this ).text( palamutLocalization.open );
				}
			} );
		}
	} );

} )( jQuery, wp.customize );

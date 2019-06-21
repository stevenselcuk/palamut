/**
 * Customizer Previewer
 */
( function( wp, $ ) {
	'use strict';

	// Bail if the customizer isn't initialized
	if ( ! wp || ! wp.customize ) {
		return;
	}

	let api = wp.customize,
		OldPreview;

	// Custom Customizer Preview class (attached to the Customize API)
	api.myCustomizerPreview = {
		// Init
		init: function() {
			const self = this; // Store a reference to "this"

			// When the previewer is active, the "active" event has been triggered (on load)
			this.preview.bind( 'active', function() {
				const $body = $( 'body' ),
					$document = $( document ); // Store references to the body and document elements
				const	$header = $( '.site-header' ),
					$branding = $( '.site-branding' ),
					$navigation = $( '.primary-menu' ),
					$siteContent = $( '.site-content' ),
					$sidebar = $( '#secondary' ),
					$pagination = $( '.navigation.pagination' ),
					$footer = $( '.site-footer' );

				$header.append( '<div class="customizer__border customizer__border-btm"></div><div class="customizer__border customizer__border-top"></div><div class="customizer__border customizer__border-left"></div><div class="customizer__border customizer__border-right"></div><button class="index-event-button customizer-editlayout-button" data-customizer-event="open-header">Edit</button>' );
				$siteContent.append( '<div class="customizer__border customizer__border-btm"></div><div class="customizer__border customizer__border-top"></div><div class="customizer__border customizer__border-left"></div><div class="customizer__border customizer__border-right"></div><button class="index-event-button customizer-editlayout-button customizer-open-widgetarea" data-customizer-event="open-content">Edit</button>' );
				$sidebar.append( '<div class="customizer__border customizer__border-btm"></div><div class="customizer__border customizer__border-top"></div><div class="customizer__border customizer__border-left"></div><div class="customizer__border customizer__border-right"></div><button class="index-event-button customizer-editlayout-button customizer-open-widgetarea" data-customizer-event="open-sidebar-widgets">Edit</button>' );
				$footer.append( '<div class="customizer__border customizer__border-btm"></div><div class="customizer__border customizer__border-top"></div><div class="customizer__border customizer__border-left"></div><div class="customizer__border customizer__border-right"></div><button class="index-event-button customizer-editlayout-button customizer-open-widgetarea" data-customizer-event="open-footer">Edit</button>' );
				$branding.append( '<span class="customizer-add-menu"><button class="index-event-button customizer-event-button" data-customizer-event="open-site-indentity" data-balloon-pos="left" data-balloon="Edit this"></button></span>' );
				$navigation.append( '<span class="customizer-add-menu"><button class="index-event-button customizer-event-button" data-customizer-event="open-navigation" data-balloon-pos="left" data-balloon="Edit this"></button></span>' );
				$pagination.append( '<span class="customizer-add-menu"><button class="index-event-button customizer-event-button" data-customizer-event="open-content" data-balloon-pos="left" data-balloon="Edit this"></button></span>' );

				// Listen for events on the new previewer buttons
				$document.on( 'touch click', '.index-event-button', function( e ) {
					const $this = $( this );

					// Send the event that we've specified on the HTML5 data attribute ('data-customizer-event') to the Customizer
					self.preview.send( $this.attr( 'data-customizer-event' ) );
				} );
			} );
		},
	};

	/**
     * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0)
     *
     * @see https://github.com/WordPress/WordPress/blob/5cab03ab29e6172a8473eb601203c9d3d8802f17/wp-admin/js/customize-controls.js#L1013
     */
	OldPreview = api.Preview;
	api.Preview = OldPreview.extend( {
		initialize: function( params, options ) {
			// Store a reference to the Preview
			api.myCustomizerPreview.preview = this;

			// Call the old Preview's initialize function
			OldPreview.prototype.initialize.call( this, params, options );
		},
	} );

	// Document ready
	$( function() {
		// Initialize our Preview
		api.myCustomizerPreview.init();
	} );
}( window.wp, jQuery ) );

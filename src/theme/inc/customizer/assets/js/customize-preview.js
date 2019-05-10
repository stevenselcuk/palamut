/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. This javascript will grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

( function( $ ) {
	wp.customize( 'site_title_font_size', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title h1, .site-title p' ).css( { 'font-size': newval + 'px' } );
		} );
	} );

  // Primary Nav Operations Start.
	wp.customize( 'menu_item_font_size', function( value ) {
		value.bind( function( newval ) {
			$( '#primary-nav .primary-menu li a' ).css( { 'font-size': newval + 'px' } );
		} );
	} );

	wp.customize( 'menu_item_font_weight', function( value ) {
		value.bind( function( newval ) {
			$( '#primary-nav .primary-menu li a' ).css( { 'font-weight': newval } );
		} );
	} );

	wp.customize( 'menu_item_transform', function( value ) {
		value.bind( function( newval ) {
			$( '#primary-nav .primary-menu li a' ).css( { 'text-transform': newval } );
		} );
	} );
    // Primary Nav Operations End.
}( jQuery ) );

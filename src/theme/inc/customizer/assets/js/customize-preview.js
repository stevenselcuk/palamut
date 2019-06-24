/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. This javascript will grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

( function( $ ) {
	wp.customize( 'custom_logo_max_width', function( value ) {
		value.bind( function( newval ) {
			$( '.site-logo img' ).css( { 'max-width': newval + 'px' } );
		} );
	} );

	wp.customize( 'site_title_font_size', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title h1, .site-title p' ).css( { 'font-size': newval + 'px' } );
		} );
	} );

	wp.customize( 'site_desc_font_size', function( value ) {
		value.bind( function( newval ) {
			$( '.site-description' ).css( { 'font-size': newval + 'px' } );
		} );
	} );

	wp.customize( 'header_max_width', function( value ) {
		value.bind( function( newval ) {
			$( '.header-container' ).css( { 'max-width': newval + 'px' } );
		} );
	} );

	wp.customize( 'header_bg_color', function( value ) {
		value.bind( function( newval ) {
			$( '#masthead' ).css( { background: newval } );
		} );
	} );

	wp.customize( 'content_bg_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site' ).css( { background: newval } );
		} );
	} );

	wp.customize( 'body_text_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site, .entry-content' ).css( { color: newval } );
		} );
	} );

	wp.customize( 'body_text_link_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site a:not(.entry-title a ), .entry-content a:not(.entry-title a )' ).css( { color: newval } );
		} );
	} );

	wp.customize( 'body_text_link_color_hover', function( value ) {
		value.bind( function( newval ) {
			$( '.site a:hover , .entry-content a:hover' ).css( { color: newval } );
		} );
	} );

	wp.customize( 'body_text_link_color_visited', function( value ) {
		value.bind( function( newval ) {
			$( '.site a:visited, .entry-content a:visited' ).css( { color: newval } );
		} );
	} );

	wp.customize( 'heading_text_color', function( value ) {
		value.bind( function( newval ) {
			$( 'h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, h1, h2, h3, h4, h5, h6' ).css( { color: newval } );
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

/**
 * Palamut Theme JavaScript Sources, Functions etc.
 *
 */
( function( $ ) {
	'use strict';
	const
		body		= $( 'body' ),
		open	 	= ( 'nav-open noscroll' ),
		finished	= ( 'nav-finished' );

	function mobileNav() {
		const dropdownOpener = $( '.mobile-navigation .mobil-nav-arrow, .main-navigation h6, .mobile-navigation a.palamut-mobile-no-link' );
		const animationSpeed = 200;

		if ( dropdownOpener.length ) {
			dropdownOpener.each( function() {
				$( this ).on( 'tap click', function( e ) {
					const dropdownToOpen = $( this ).nextAll( 'ul' ).first();

					if ( dropdownToOpen.length ) {
						e.preventDefault();
						e.stopPropagation();

						const openerParent = $( this ).parent( 'li' );
						if ( dropdownToOpen.is( ':visible' ) ) {
							dropdownToOpen.slideUp( animationSpeed );
							openerParent.removeClass( 'menu-opened' );
						} else {
							dropdownToOpen.slideDown( animationSpeed );
							openerParent.addClass( 'menu-opened' );
						}
					}
				} );
			} );
		}
	}

	$( document ).ready( function() {
		mobileNav();
		if ( body.hasClass( 'has-sticky-header' ) ) {
			$( '#masthead' ).headroom();
		}
		$( '.hamburger, .offcanvas-close' ).on( 'click', function() {
			if ( body.hasClass( open ) ) {
				body.removeClass( open );
				setTimeout( function() {
					body.removeClass( finished );
				}, 300 );
			} else {
				body.addClass( open );
				setTimeout( function() {
					body.removeClass( finished );
				}, 600 );
			}
		} );
	} );
}( jQuery ) );

AOS.init( {
	once: true,
} );

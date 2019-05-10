/**
 * Customizer Worker Dude.
 */
( function( exports, $ ) {
	'use strict';

	let api = wp.customize,
		OldPreviewer;

	api.myCustomizerPreviewer = {

		init: function() {
			const self = this;

			// Site Identity Opener.
			this.preview.bind( 'open-site-indentity', function() {
				const siteIndentity = wp.customize.section( 'title_tagline' );
				if ( ! siteIndentity.expanded() ) {
					siteIndentity.expand();
				}
			} );

			// Single Post Sidebar
			this.preview.bind( 'index-open-single_product-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-singleproduct' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Site Logo
			this.preview.bind( 'index-open-header-site-title', function() {
				const primary_sidebar_section = wp.customize.section( 'title_tagline' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Hfeed Styles
			this.preview.bind( 'index-open-hfeed-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-blogroll' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Single Post Styles
			this.preview.bind( 'index-open-singlepost-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-singlepost' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Header Styles
			this.preview.bind( 'index-open-header-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-header' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Header Secondary Styles
			this.preview.bind( 'index-open-top-header-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-top-header' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Footer Styles
			this.preview.bind( 'index-open-footer-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-footer' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Colophon Styles
			this.preview.bind( 'index-open-colophon-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-colophon' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Colophon Menu
			this.preview.bind( 'index-add-menu', function() {
				const primary_sidebar_section = wp.customize.panel( 'nav_menus' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Mobile Menu
			this.preview.bind( 'index-open-mobilemenu-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-mobilenav' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			// Single Post Sidebar
			this.preview.bind( 'index-open-sidebar-1', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-sidebar-1' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			this.preview.bind( 'index-add-widget-sidebar-1', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-sidebar-1' ), // Grab the Primary Sidebar from the collection of panels
					primary_sidebar_control = api.control( 'sidebars_widgets[sidebar-1]' ); // Grab the control from the Customizer settings object

				// First we'll check to see if the Customizer Sidebar is open
				if ( $( '.wp-full-overlay' ).hasClass( 'collapsed' ) ) {
					// Trigger a click event on the collapse sidebar element
					$( '.collapse-sidebar' ).trigger( 'click' );
				}

				// Then we'll check to see if the Primary Sidebar section is open
				if ( ! primary_sidebar_section.expanded() ) {
					// Expanding the Primary Sidebar section will also open the Widgets Panel
					primary_sidebar_section.expand( {
						// Open immediately (no animation)
						duration: 0,
						// We can pass a function to execute upon completion called the completeCallback
						completeCallback: function() {
							// Pass the control to the available widgets panel to give it context
							api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
						},
					} );
				}
				// Otherwise, if the Add a Widget Panel is collapsed, open it
				else if ( ! $( 'body' ).hasClass( 'adding-widget' ) ) {
					// Pass the control to the available widgets panel to give it context
					api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
				}
			} );

			// Footer Col 1
			this.preview.bind( 'index-open-footer-col-1', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-footer-col-1' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			this.preview.bind( 'index-add-widget-footer-col-1', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-footer-col-1' ), // Grab the Primary Sidebar from the collection of panels
					primary_sidebar_control = api.control( 'sidebars_widgets[footer-col-1]' ); // Grab the control from the Customizer settings object

				// First we'll check to see if the Customizer Sidebar is open
				if ( $( '.wp-full-overlay' ).hasClass( 'collapsed' ) ) {
					// Trigger a click event on the collapse sidebar element
					$( '.collapse-sidebar' ).trigger( 'click' );
				}

				// Then we'll check to see if the Primary Sidebar section is open
				if ( ! primary_sidebar_section.expanded() ) {
					// Expanding the Primary Sidebar section will also open the Widgets Panel
					primary_sidebar_section.expand( {
						// Open immediately (no animation)
						duration: 0,
						// We can pass a function to execute upon completion called the completeCallback
						completeCallback: function() {
							// Pass the control to the available widgets panel to give it context
							api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
						},
					} );
				}
				// Otherwise, if the Add a Widget Panel is collapsed, open it
				else if ( ! $( 'body' ).hasClass( 'adding-widget' ) ) {
					// Pass the control to the available widgets panel to give it context
					api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
				}
			} );

			// Footer Col 2
			this.preview.bind( 'index-open-footer-col-2', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-footer-col-2' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			this.preview.bind( 'index-add-widget-footer-col-2', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-footer-col-2' ), // Grab the Primary Sidebar from the collection of panels
					primary_sidebar_control = api.control( 'sidebars_widgets[footer-col-2]' ); // Grab the control from the Customizer settings object

				// First we'll check to see if the Customizer Sidebar is open
				if ( $( '.wp-full-overlay' ).hasClass( 'collapsed' ) ) {
					// Trigger a click event on the collapse sidebar element
					$( '.collapse-sidebar' ).trigger( 'click' );
				}

				// Then we'll check to see if the Primary Sidebar section is open
				if ( ! primary_sidebar_section.expanded() ) {
					// Expanding the Primary Sidebar section will also open the Widgets Panel
					primary_sidebar_section.expand( {
						// Open immediately (no animation)
						duration: 0,
						// We can pass a function to execute upon completion called the completeCallback
						completeCallback: function() {
							// Pass the control to the available widgets panel to give it context
							api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
						},
					} );
				}
				// Otherwise, if the Add a Widget Panel is collapsed, open it
				else if ( ! $( 'body' ).hasClass( 'adding-widget' ) ) {
					// Pass the control to the available widgets panel to give it context
					api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
				}
			} );

			// Footer Col 3
			this.preview.bind( 'index-open-footer-col-3', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-footer-col-3' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			this.preview.bind( 'index-add-widget-footer-col-3', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-footer-col-3' ), // Grab the Primary Sidebar from the collection of panels
					primary_sidebar_control = api.control( 'sidebars_widgets[footer-col-3]' ); // Grab the control from the Customizer settings object

				// First we'll check to see if the Customizer Sidebar is open
				if ( $( '.wp-full-overlay' ).hasClass( 'collapsed' ) ) {
					// Trigger a click event on the collapse sidebar element
					$( '.collapse-sidebar' ).trigger( 'click' );
				}

				// Then we'll check to see if the Primary Sidebar section is open
				if ( ! primary_sidebar_section.expanded() ) {
					// Expanding the Primary Sidebar section will also open the Widgets Panel
					primary_sidebar_section.expand( {
						// Open immediately (no animation)
						duration: 0,
						// We can pass a function to execute upon completion called the completeCallback
						completeCallback: function() {
							// Pass the control to the available widgets panel to give it context
							api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
						},
					} );
				}
				// Otherwise, if the Add a Widget Panel is collapsed, open it
				else if ( ! $( 'body' ).hasClass( 'adding-widget' ) ) {
					// Pass the control to the available widgets panel to give it context
					api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
				}
			} );

			// Footer Col 4
			this.preview.bind( 'index-open-footer-col-4', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-footer-col-4' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			this.preview.bind( 'index-add-widget-footer-col-4', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-footer-col-4' ), // Grab the Primary Sidebar from the collection of panels
					primary_sidebar_control = api.control( 'sidebars_widgets[footer-col-4]' ); // Grab the control from the Customizer settings object

				// First we'll check to see if the Customizer Sidebar is open
				if ( $( '.wp-full-overlay' ).hasClass( 'collapsed' ) ) {
					// Trigger a click event on the collapse sidebar element
					$( '.collapse-sidebar' ).trigger( 'click' );
				}

				// Then we'll check to see if the Primary Sidebar section is open
				if ( ! primary_sidebar_section.expanded() ) {
					// Expanding the Primary Sidebar section will also open the Widgets Panel
					primary_sidebar_section.expand( {
						// Open immediately (no animation)
						duration: 0,
						// We can pass a function to execute upon completion called the completeCallback
						completeCallback: function() {
							// Pass the control to the available widgets panel to give it context
							api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
						},
					} );
				}
				// Otherwise, if the Add a Widget Panel is collapsed, open it
				else if ( ! $( 'body' ).hasClass( 'adding-widget' ) ) {
					// Pass the control to the available widgets panel to give it context
					api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
				}
			} );

			// Flyout
			this.preview.bind( 'index-open-flyout-styles', function() {
				const primary_sidebar_section = wp.customize.section( 'ava__style-flyout' );
				if ( ! primary_sidebar_section.expanded() ) {
					primary_sidebar_section.expand();
				}
			} );

			this.preview.bind( 'index-add-widget-flyout', function() {
				const primary_sidebar_section = wp.customize.section( 'sidebar-widgets-flyout' ), // Grab the Primary Sidebar from the collection of panels
					primary_sidebar_control = api.control( 'sidebars_widgets[flyout]' ); // Grab the control from the Customizer settings object

				// First we'll check to see if the Customizer Sidebar is open
				if ( $( '.wp-full-overlay' ).hasClass( 'collapsed' ) ) {
					// Trigger a click event on the collapse sidebar element
					$( '.collapse-sidebar' ).trigger( 'click' );
				}

				// Then we'll check to see if the Primary Sidebar section is open
				if ( ! primary_sidebar_section.expanded() ) {
					// Expanding the Primary Sidebar section will also open the Widgets Panel
					primary_sidebar_section.expand( {
						// Open immediately (no animation)
						duration: 0,
						// We can pass a function to execute upon completion called the completeCallback
						completeCallback: function() {
							// Pass the control to the available widgets panel to give it context
							api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
						},
					} );
				}
				// Otherwise, if the Add a Widget Panel is collapsed, open it
				else if ( ! $( 'body' ).hasClass( 'adding-widget' ) ) {
					// Pass the control to the available widgets panel to give it context
					api.Widgets.availableWidgetsPanel.open( primary_sidebar_control );
				}
			} );
		},
	};

	/**
     * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0)
     *
     * @see https://github.com/WordPress/WordPress/blob/5cab03ab29e6172a8473eb601203c9d3d8802f17/wp-admin/js/customize-controls.js#L1013
     */
	OldPreviewer = api.Previewer;
	api.Previewer = OldPreviewer.extend( {
		initialize: function( params, options ) {
			// Store a reference to the Previewer
			api.myCustomizerPreviewer.preview = this;

			// Call the old Previewer's initialize function
			OldPreviewer.prototype.initialize.call( this, params, options );
		},
	} );

	// Document Ready
	$( function() {
		// Initialize our Previewer
		api.myCustomizerPreviewer.init();
	} );
}( wp, jQuery ) );

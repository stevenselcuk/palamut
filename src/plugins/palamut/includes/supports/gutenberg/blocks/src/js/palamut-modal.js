"use strict";

var palamut_frame = false;
var palamut_trigger = false;
var palamut_modal = {
	init: function() {
		var self 		= this;
		self.elem 		= jQuery('.palamut-default-ui');

		self.appendModal();
		self.navClick();
		self.closeModal();
		self.createTemplate();
		self.typeSelection();
		// self.liveSearch();

		if( jQuery( '.palamut-default-ui' ).hasClass( 'palamut-autoOpen' ) ){
			jQuery( 'a.page-title-action, .split-page-title-action a' ).click();
		}
    },

	appendModal: function(e) {
		var self = this;
		if( self.elem.length > 0 ){
			self.elem.find('.selected').removeClass('details selected');
        	self.elem.appendTo('.palamut-default-ui-wrapper').hide();
		}

        palamut_trigger = palamut_frame = false;
	},

	navClick: function(){
		var self = this;
		jQuery( document ).on( 'click', '.palamut-default-ui .media-router a', function(e){
			e.preventDefault();
		} );
	},

	closeModal: function(){
		var self = this;

		jQuery(document).on('click', '.media-modal-close, .media-modal-backdrop, .palamut-cancel-insertion', function(e){
        	e.preventDefault();
        	self.appendModal();
        });
        jQuery(document).on('keydown', function(e){
            if ( 27 == e.keyCode && palamut_frame ) {
                self.appendModal(e);
            }
        });
	},

	createTemplate: function(){
		var self 	= this;
		jQuery(document).on('click', '.wp-admin.edit-php.post-type-palamut a.page-title-action, .wp-admin.edit-php.post-type-palamut .split-page-title-action a, #wp-admin-bar-new-palamut a, .palamut-saver, .palamut-dashboard-widget__create .button', function(e){
			e.preventDefault();

			if( jQuery(this).hasClass('palamut-saver') ){
				e.stopImmediatePropagation();
			}

			if( !jQuery(this).hasClass('disabled') ){
				// display modal
		        palamut_frame = true;

				//hide media modal unnecessary elements
				self.elem.find( '.palamut-predesigned, .palamut-templates, .palamut-theme, .media-router a, .palamut-spinner' ).hide();
				self.elem.find( '.palamut-new, .palamut-create, .media-sidebar, .palamut-meta-sidebar' ).show();
				self.elem.find( '.media-frame-title h1' ).text( PalamutVars.create );
				self.elem.addClass( 'creating-palamut' );

				//if saving as template
				if( jQuery( this ).hasClass( 'palamut-saver' ) ){
					jQuery( '.palamut-creation [name="palamut_action"]' ).val( 'save_template' );
				}else{
					jQuery( '.palamut-creation [name="palamut_action"]' ).val( 'create_template' );
				}

				self.elem.appendTo('body').show();
			}

		});

		//on form submit
		self.submitCreation();
	},

	submitCreation: function(){
		var self = this;
		var valid = true;
		jQuery(document).on( 'submit', '.palamut-creation', function(e){
			e.preventDefault();

			if( self.elem.find('.palamut-create .button-primary').hasClass( 'disabled' ) ){
				return false;
			}

			jQuery(this).find( '.palamut-required' ).each(function () {
		        if ( jQuery(this).val() === '' ){
		        	valid = false;
		            jQuery(this).css({ border : '1px solid red' });
		            return false;
		        }else{
		        	valid = true;
		        }
		    });

		    if( valid ){
		    	jQuery( this ).find('.button').val( PalamutVars.creating ).attr('disabled','disabled');

		    	var postData = {
	        		'action'	: 'palamut_ajax_inserter',
					'nonce'		:  PalamutVars.nonce,
					'method'	: jQuery( '.palamut-creation [name="palamut_action"]' ).val(),
					'formdata' 	: jQuery( this ).serialize()
				};

				jQuery.post( ajaxurl, postData )
				.always(function( a, status, b ) {
					a = jQuery.parseJSON( a );
					// console.log(a.raw_html);
					if ( 'undefined' !== a.response ) {
						if( typeof a.redirect != 'undefined' ){
							window.location.href = a.redirect;
						}else if( typeof a.templateid !== 'undefined' ){
							self.elem.find( '.palamut-creation' ).hide();
							jQuery( '<span class="palamut-saved">'+ PalamutVars.saved +'</span>' ).insertAfter('.palamut-creation');
						}
					}
				});
		    }

			return false;
		});
	},

	typeSelection: function(){
		var self = this;
		self.elem.find( '#palamut-type' ).on( 'change',function(){
			switch( jQuery( this ).val() ){
				case 'section':
					jQuery( 'label[for="palamut-name"]' ).text( PalamutVars.name_section );
					jQuery( '.palamut-creation .button-primary' ).val( PalamutVars.create_section );
				break;
				default:
					jQuery( 'label[for="palamut-name"]' ).text( PalamutVars.name_template );
					jQuery( '.palamut-creation .button-primary' ).val( PalamutVars.create_template );
				break;
			}
		});
	},
}

jQuery(document).ready(function() {
	palamut_modal.init();
});
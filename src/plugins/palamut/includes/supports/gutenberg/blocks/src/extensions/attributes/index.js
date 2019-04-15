/**
 * External Dependencies
 */
import classnames from 'classnames';

/**
 * WordPress Dependencies
 */
const { __ } = wp.i18n;
const { addFilter } = wp.hooks;
const { Fragment }	= wp.element;
const { compose, createHigherOrderComponent } = wp.compose;

const allowedBlocks = [ 'palamut/row', 'palamut/column', 'palamut/features', 'palamut/feature', 'palamut/media-card', 'palamut/shape-divider', 'palamut/hero' ];

/**
 * Filters registered block settings, extending attributes with settings
 *
 * @param {Object} settings Original block settings.
 * @return {Object} Filtered block settings.
 */
function addAttributes( settings ) {

	// Add custom selector/id
	if( allowedBlocks.includes( settings.name ) && typeof settings.attributes !== 'undefined' ) {
		settings.attributes = Object.assign( settings.attributes, {
			palamut: { type: 'object' }
		} );
	}

	return settings;
}

/**
 * Add custom Palamut attributes to selected blocks
 *
 * @param {function|Component} BlockEdit Original component.
 * @return {string} Wrapped component.
 */
const withAttributes = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {

		const {
			clientId,
			attributes,
			setAttributes,
		} = props;

		if ( typeof attributes.palamut === 'undefined' ) {
			attributes.palamut = [];
		}

		//add unique selector
		if( allowedBlocks.includes( props.name ) && typeof attributes.palamut.id === 'undefined' ){
			let d = new Date();

			if( typeof attributes.palamut !== 'undefined' && typeof attributes.palamut.id !== 'undefined' ){
				delete attributes.palamut.id;
			}

			const palamut = Object.assign( { id: "" + d.getMonth() + d.getDate() + d.getHours() + d.getMinutes() + d.getSeconds() + d.getMilliseconds() }, attributes.palamut );
			setAttributes( { palamut: palamut } );
		}

		return (
			<Fragment>
				<BlockEdit {...props} />
			</Fragment>
		);
	};
}, 'withAttributes');

addFilter(
	'blocks.registerBlockType',
	'palamut/custom/attributes',
	addAttributes
);

addFilter(
	'editor.BlockEdit',
	'palamut/attributes',
	withAttributes
);
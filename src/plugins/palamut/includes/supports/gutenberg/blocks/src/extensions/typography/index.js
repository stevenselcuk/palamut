/**
 * Internal Dependencies
 */
import './styles/editor.scss';
import './styles/style.scss';
import Controls from './controls';
import applyStyle from './apply-style';
import TypographyControls, { TypographyAttributes } from '../../components/typography-controls';

/**
 * External Dependencies
 */
import classnames from 'classnames';

/**
 * WordPress Dependencies
 */
const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { addFilter } = wp.hooks;
const { Fragment }	= wp.element;
const { InspectorAdvancedControls }	= wp.components;
const { compose, createHigherOrderComponent } = wp.compose;

const allowedBlocks = [ 'core/paragraph', 'core/heading', 'core/cover', 'core/pullquote', 'core/quote', 'core/button', 'core/list', 'palamut/row', 'palamut/column', 'palamut/accordion', 'palamut/accordion-item', 'palamut/click-to-tweet', 'palamut/alert', 'palamut/highlight', 'palamut/pricing-table', 'palamut/features' ];

/**
 * Filters registered block settings, extending attributes with settings
 *
 * @param {Object} settings Original block settings.
 * @return {Object} Filtered block settings.
 */
function addAttributes( settings ) {

	// Use Lodash's assign to gracefully handle if attributes are undefined
	if( allowedBlocks.includes( settings.name ) ){
		settings.attributes = Object.assign( settings.attributes, TypographyAttributes );
	}

	return settings;
}

/**
 * Override the default edit UI to include a new block toolbar control
 *
 * @param {function|Component} BlockEdit Original component.
 * @return {string} Wrapped component.
 */
const withControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {

		const {
			clientId,
			attributes,
			setAttributes,
		} = props;

		return (
			<Fragment>
				<BlockEdit {...props} />
				{ props.isSelected && allowedBlocks.includes( props.name ) && <Controls {...{ ...props }} /> }
			</Fragment>
		);
	};
}, 'withControls');

/**
 * Override the default block element to add	wrapper props.
 *
 * @param  {Function} BlockListBlock Original component
 * @return {Function} Wrapped component
 */

const enhance = compose(
	/**
	 * For blocks whose block type doesn't support `multiple`, provides the
	 * wrapped component with `originalBlockClientId` -- a reference to the
	 * first block of the same type in the content -- if and only if that
	 * "original" block is not the current one. Thus, an inexisting
	 * `originalBlockClientId` prop signals that the block is valid.
	 *
	 * @param {Component} WrappedBlockEdit A filtered BlockEdit instance.
	 *
	 * @return {Component} Enhanced component with merged state data props.
	 */
	withSelect( ( select, block ) => {
		return { selected : select( 'core/editor' ).getSelectedBlock(), select: select };
	} )
);

const withFontSettings = createHigherOrderComponent( (BlockListBlock) => {
	return enhance( ( { selected, select, ...props } ) => {

		let wrapperProps 	= props.wrapperProps;
		let customData 	 	= {};
		let attributes 		= select( 'core/editor' ).getBlock( props.clientId ).attributes;
		let blockName		= select( 'core/editor' ).getBlockName( props.clientId );

		if( allowedBlocks.includes( blockName ) ){
			const { customFontSize, fontFamily, lineHeight, fontWeight, letterSpacing, textTransform, customTextColor } = attributes;

			if( customFontSize ){
				customData = Object.assign( customData, { 'data-custom-fontsize': 1 } );
			}

			if( lineHeight ){
				customData = Object.assign( customData, { 'data-custom-lineheight': 1 } );
			}

			if( fontFamily ){
				customData = Object.assign( customData, { 'data-palamut-font': 1 } );
			}

			if( fontWeight ){
				customData = Object.assign( customData, { 'data-custom-fontweight': 1 } );
			}

			if( textTransform ){
				customData = Object.assign( customData, { 'data-custom-texttransform': 1 } );
			}

			if( customTextColor ){
				customData = Object.assign( customData, { 'data-custom-textcolor': 1 } );
			}

			if ( letterSpacing ) {
				customData = Object.assign( customData, { 'data-custom-letterspacing' : 1 } );
			}

			wrapperProps = {
				...wrapperProps,
				style: applyStyle( attributes, blockName ),
				...customData,
			};
		}

		return <BlockListBlock {...props} wrapperProps={wrapperProps} />;
	} );
}, 'withFontSettings');

/**
 * Override props assigned to save component to inject atttributes
 *
 * @param {Object} extraProps Additional props applied to save element.
 * @param {Object} blockType  Block type.
 * @param {Object} attributes Current block attributes.
 *
 * @return {Object} Filtered props applied to save element.
 */
function applyFontSettings(extraProps, blockType, attributes) {

	if ( allowedBlocks.includes( blockType.name ) ) {

		if( typeof extraProps.style !== 'undefined' ){
			extraProps.style = Object.assign( extraProps.style, applyStyle( attributes, blockType.name ) );
		} else {
			extraProps.style = applyStyle( attributes, blockType.name );
		}

		const { customFontSize, fontFamily, lineHeight, fontWeight, letterSpacing, textTransform, noBottomSpacing, noTopSpacing } = attributes;

		if ( customFontSize ) {
			extraProps.className = classnames( extraProps.className, 'has-custom-size' );
		}

		if ( fontFamily ) {
			extraProps.className = classnames( extraProps.className, 'has-custom-font' );
		}

		if ( fontWeight ) {
			extraProps.className = classnames( extraProps.className, 'has-custom-weight' );
		}

		if ( textTransform ) {
			extraProps.className = classnames( extraProps.className, 'has-custom-transform' );
		}

		if ( lineHeight ) {
			extraProps.className = classnames( extraProps.className, 'has-custom-lineheight' );
		}

		if ( letterSpacing ) {
			extraProps.className = classnames( extraProps.className, 'has-custom-letterspacing' );
		}

		if ( typeof noBottomSpacing !== 'undefined' && noBottomSpacing ) {
			extraProps.className = classnames( extraProps.className, 'mb-0 pb-0' );
		}

		if ( typeof noTopSpacing !== 'undefined' && noTopSpacing ) {
			extraProps.className = classnames( extraProps.className, 'mt-0 pt-0' );
		}
	}

	return extraProps;
}

addFilter(
	'blocks.registerBlockType',
	'palamut/inspector/attributes',
	addAttributes
);

addFilter(
	'editor.BlockEdit',
	'palamut/typography',
	withControls
);

addFilter(
	'editor.BlockListBlock',
	'palamut/withFontSettings',
	withFontSettings
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'palamut/applyFontSettings',
	applyFontSettings
);
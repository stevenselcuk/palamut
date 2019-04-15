/**
 * External Dependencies
 */
import classnames from 'classnames';

/**
 * Internal Dependencies
 */
import './styles/editor.scss';
import './styles/style.scss';

/**
 * WordPress Dependencies
 */
const { __ } = wp.i18n;
const { addFilter } = wp.hooks;
const { Fragment }	= wp.element;
const { withSelect } = wp.data;
const { hasBlockSupport }	= wp.blocks;
const { InspectorAdvancedControls }	= wp.editor;
const { compose, createHigherOrderComponent } = wp.compose;
const { ToggleControl } = wp.components;

const blocksWithSpacingSupport = [ 'core/image', 'core/gallery', 'core/spacer', 'core/cover' ];

/**
 * Filters registered block settings, extending attributes with settings
 *
 * @param {Object} settings Original block settings.
 * @return {Object} Filtered block settings.
 */
function addAttributes( settings ) {

	// Add custom attribute
	if ( hasBlockSupport( settings, 'stackedOnMobile' ) ) {
		if( typeof settings.attributes !== 'undefined' ){
			if( !settings.attributes.isStackedOnMobile ){
				settings.attributes = Object.assign( settings.attributes, {
					isStackedOnMobile: {
						type: 'boolean',
						default: true,
					}
				} );
			}
		}
	}

	//Add Palamut spacing support
	if( blocksWithSpacingSupport.includes( settings.name ) ){
		if( !settings.supports ){
			settings.supports = {};
		}
		settings.supports = Object.assign( settings.supports, {
			coBlocksSpacing: true
		} );
	}

	if ( hasBlockSupport( settings, 'coBlocksSpacing' ) ) {
		if( typeof settings.attributes !== 'undefined' ){

			if( ! settings.attributes.noBottomMargin ){
				settings.attributes = Object.assign( settings.attributes, {
					noBottomMargin: {
						type: 'boolean',
						default: false,
					}
				} );
			}
			if( ! settings.attributes.noTopMargin ){
				settings.attributes = Object.assign( settings.attributes, {
					noTopMargin: {
						type: 'boolean',
						default: false,
					}
				} );
			}
		}
	}

	return settings;
}

/**
 * Add custom Palamut attributes to selected blocks
 *
 * @param {function|Component} BlockEdit Original component.
 * @return {string} Wrapped component.
 */
const withAdvancedControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {

		const {
			name,
			clientId,
			attributes,
			setAttributes,
			isSelected,
		} = props;

		const {
			isStackedOnMobile,
			noBottomMargin,
			noTopMargin,
		} = attributes;

		const hasStackedControl = hasBlockSupport( name, 'stackedOnMobile' );
		const withBlockSpacing = hasBlockSupport( name, 'coBlocksSpacing' );

		return (
			<Fragment>
				<BlockEdit {...props} />
				{ isSelected &&
					<InspectorAdvancedControls>
						{ hasStackedControl &&
							<ToggleControl
								label={ __( 'Stack on Mobile' ) }
								checked={ !! isStackedOnMobile }
								onChange={ () => setAttributes( {  isStackedOnMobile: ! isStackedOnMobile } ) }
								help={ !! isStackedOnMobile ? __( 'Responsiveness is enabled.' ) : __( 'Toggle to stack elements on top of each other on smaller viewports.' ) }
							/>
						}
						{ withBlockSpacing &&
							<ToggleControl
								label={ __( 'Remove Top Spacing' ) }
								checked={ !! noTopMargin }
								onChange={ () => setAttributes( {  noTopMargin: ! noTopMargin, marginTop: 0, marginTopTablet: 0, marginTopMobile: 0 } ) }
								help={ !! noTopMargin ? __( 'Top margin is removed on this block.' ) : __( 'Toggle to remove any margin applied to the top of this block.' ) }
							/>
						}
						{ withBlockSpacing &&
							<ToggleControl
								label={ __( 'Remove Bottom Spacing' ) }
								checked={ !! noBottomMargin }
								onChange={ () => {
									setAttributes( {  noBottomMargin: ! noBottomMargin, marginBottom: 0, marginBottomTablet: 0, marginBottomMobile: 0  } );

									let nextBlockClientId = wp.data.select( 'core/editor' ).getNextBlockClientId( clientId );
									if( nextBlockClientId && ! noBottomMargin ){
										wp.data.dispatch( 'core/editor' ).updateBlockAttributes( nextBlockClientId, {  noTopMargin: ! noTopMargin, marginTop: 0, marginTopTablet: 0, marginTopMobile: 0 } );
									}
								} }
								help={ !! noBottomMargin ? __( 'Bottom margin is removed on this block.' ) : __( 'Toggle to remove any margin applied to the bottom of this block.' ) }
							/>
						}
					</InspectorAdvancedControls>
				}

			</Fragment>
		);
	};
}, 'withAdvancedControls');

/**
 * Override props assigned to save component to inject atttributes
 *
 * @param {Object} extraProps Additional props applied to save element.
 * @param {Object} blockType  Block type.
 * @param {Object} attributes Current block attributes.
 *
 * @return {Object} Filtered props applied to save element.
 */
function applySpacingClass(extraProps, blockType, attributes) {

	const withBlockSpacing = hasBlockSupport( blockType.name, 'coBlocksSpacing' );

	if ( withBlockSpacing ) {

		const { noBottomMargin, noTopMargin } = attributes;

		if ( typeof noBottomMargin !== 'undefined' && noBottomMargin ) {
			extraProps.className = classnames( extraProps.className, 'mb-0' );
		}

		if ( typeof noTopMargin !== 'undefined' && noTopMargin ) {
			extraProps.className = classnames( extraProps.className, 'mt-0' );
		}
	}

	return extraProps;
}

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

const addEditorBlockAttributes = createHigherOrderComponent( (BlockListBlock) => {
	return enhance( ( { selected, select, ...props } ) => {

		let wrapperProps 	= props.wrapperProps;
		let customData 	 	= {};
		let attributes 		= select( 'core/editor' ).getBlock( props.clientId ).attributes;
		let blockName		= select( 'core/editor' ).getBlockName( props.clientId );

		const withBlockSpacing = hasBlockSupport( blockName, 'coBlocksSpacing' );
		let withAlignSupport = hasBlockSupport( blockName, 'align' );

		if( [ 'core/image' ].includes( blockName ) ){
			withAlignSupport = true;
		}

		if ( withBlockSpacing ) {

			const { noBottomMargin, noTopMargin } = attributes;

			if ( typeof noTopMargin !== 'undefined' && noTopMargin ) {
				customData = Object.assign( customData, { 'data-palamut-top-spacing': 1 } );
			}

			if ( typeof noBottomMargin !== 'undefined' && noBottomMargin ) {
				customData = Object.assign( customData, { 'data-palamut-bottom-spacing': 1 } );
			}

		}

		if( withAlignSupport ){
			customData = Object.assign( customData, { 'data-palamut-align-support': 1 } );
		}

		if( withBlockSpacing || withAlignSupport ){
			wrapperProps = {
				...wrapperProps,
				...customData,
			};
		}

		return <BlockListBlock {...props} wrapperProps={wrapperProps} />;
	} );
}, 'addEditorBlockAttributes');

addFilter(
	'blocks.registerBlockType',
	'palamut/AdvancedControls/attributes',
	addAttributes
);

addFilter(
	'editor.BlockEdit',
	'palamut/advanced',
	withAdvancedControls
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'palamut/applySpacingClass',
	applySpacingClass
);

addFilter(
	'editor.BlockListBlock',
	'palamut/addEditorBlockAttributes',
	addEditorBlockAttributes
);
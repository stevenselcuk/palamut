/**
 * Internal dependencies
 */
import applyWithColors from './colors';
import icons from './../../../utils/icons';
import BackgroundPanel, { BackgroundAttributes, BackgroundClasses } from '../../../components/background';
import DimensionsControl from '../../../components/dimensions-control/';

/**
 * WordPress dependencies
 */
const { __, sprintf } = wp.i18n;
const { Component, Fragment } = wp.element;
const { compose } = wp.compose;
const { InspectorControls, PanelColorSettings } = wp.editor;
const { PanelBody, ToggleControl, TextareaControl, RangeControl } = wp.components;

/**
 * Inspector controls
 */
class Inspector extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	render() {

		const {
			attributes,
			backgroundColor,
			setAttributes,
			setBackgroundColor,
		} = this.props;

		const {
			hasImgShadow,
			hasCardShadow,
			mediaUrl,
			mediaAlt,
			paddingBottom,
			paddingLeft,
			paddingRight,
			paddingSize,
			paddingTop,
			paddingBottomTablet,
			paddingLeftTablet,
			paddingRightTablet,
			paddingTopTablet,
			paddingBottomMobile,
			paddingLeftMobile,
			paddingRightMobile,
			paddingTopMobile,
			paddingSyncUnits,
			paddingSyncUnitsTablet,
			paddingSyncUnitsMobile,
			paddingUnit,
			maxWidth,
			align,
			mediaType,
		} = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Media Card Settings' ) } className='block-palamut__inspector-block-settings-panel-body'>
						<DimensionsControl { ...this.props }
							type={ 'padding' }
							label={ __( 'Padding' ) }
							help={ __( 'Space inside of the container.' ) }
							valueTop={ paddingTop }
							valueRight={ paddingRight }
							valueBottom={ paddingBottom }
							valueLeft={ paddingLeft }
							valueTopTablet={ paddingTopTablet }
							valueRightTablet={ paddingRightTablet }
							valueBottomTablet={ paddingBottomTablet }
							valueLeftTablet={ paddingLeftTablet }
							valueTopMobile={ paddingTopMobile }
							valueRightMobile={ paddingRightMobile }
							valueBottomMobile={ paddingBottomMobile }
							valueLeftMobile={ paddingLeftMobile }
							unit={ paddingUnit }
							syncUnits={ paddingSyncUnits }
							syncUnitsTablet={ paddingSyncUnitsTablet }
							syncUnitsMobile={ paddingSyncUnitsMobile }
							dimensionSize={ paddingSize }
						/>
						{ ( 'full' == align || 'wide' == align ) && (
							<RangeControl
								label={ __( 'Max Width' ) }
								className="components-block-palamut-media-card-maxwidth-range"
								value={ parseFloat( maxWidth ) }
								onChange={ ( nextMaxWidth ) => setAttributes( {  maxWidth: nextMaxWidth } ) }
								min={ 400 }
								max={ 2000 }
								step={ 1 }
							/>
						) }
						{ mediaUrl && mediaType === 'image' && (
							<TextareaControl
								label={ __( 'Alt Text (Alternative Text)' ) }
								value={ mediaAlt }
								onChange={ ( nextMediaAlt ) => setAttributes( { mediaAlt: nextMediaAlt } ) }
								help={ __( 'Alternative text describes your image to people who can’t see it. Add a short description with its key details.' ) }
							/>
						) }
						<ToggleControl
							label={ __( 'Card Shadow' ) }
							checked={ !! hasCardShadow }
							onChange={ () => setAttributes( {  hasCardShadow: ! hasCardShadow } ) }
							help={ !! hasCardShadow ? __( 'Showing card shadow.' ) : __( 'Toggle to add a card shadow.' ) }
						/>
						{ mediaType && (
							<ToggleControl
								label={ sprintf( __( ' %s Shadow' ), mediaType.charAt(0).toUpperCase() + mediaType.slice(1) ) }
								checked={ !! hasImgShadow }
								onChange={ () => setAttributes( {  hasImgShadow: ! hasImgShadow } ) }
								help={ !! hasImgShadow ? sprintf( __( 'Showing %s shadow.' ), mediaType ) : sprintf( __( 'Toggle to add an %s shadow' ), mediaType ) }
							/>
						) }
					</PanelBody>
					<PanelColorSettings
						title={ __( 'Color Settings' ) }
						initialOpen={ false }
						colorSettings={ [
							{
								value: backgroundColor.color,
								onChange: ( nextBg ) => {
									setBackgroundColor( nextBg );
									if( !paddingSize || paddingSize == 'no' ){
										setAttributes( { paddingSize: 'medium' } );
									}
									if( !nextBg ){
										setAttributes( { paddingSize: 'no' } );
									}
								},
								label: __( 'Background Color' ),
							},
						] }
					>
					</PanelColorSettings>
					{ BackgroundPanel( this.props, { overlay: true } ) }
				</InspectorControls>
			</Fragment>
		);
	}
}

export default compose( [
	applyWithColors,
] )( Inspector );

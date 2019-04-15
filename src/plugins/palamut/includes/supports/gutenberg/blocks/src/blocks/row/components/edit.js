/**
 * External dependencies
 */
import classnames from 'classnames';
import memoize from 'memize';
import times from 'lodash/times';
import map from 'lodash/map';

/**
 * Internal dependencies
 */
import { layoutOptions } from './layouts'
import Inspector from './inspector';
import Controls from './controls';
import applyWithColors from './colors';
import rowIcons from './icons';
import { title, icon } from '../'
import BackgroundPanel, { BackgroundClasses, BackgroundDropZone, BackgroundVideo } from '../../../components/background';

/**
 * WordPress dependencies
 */
const { __, sprintf } = wp.i18n;
const { Component, Fragment } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks } = wp.editor;
const { ResizableBox, ButtonGroup, Button, IconButton, Tooltip, Placeholder, Spinner } = wp.components;
const { isBlobURL } = wp.blob;

/**
 * Allowed blocks constant is passed to InnerBlocks precisely as specified here.
 * The contents of the array should never change.
 * The array should contain the name of each block that is allowed.
 * In columns block, the only block we allow is 'core/column'.
 *
 * @constant
 * @type {string[]}
*/
const ALLOWED_BLOCKS = [ 'palamut/column' ];

const TEMPLATE = {
	'100' : [
		[ 'palamut/column', { width: '100' } ],
	],
	'50-50' : [
		[ 'palamut/column', { width: '50' } ],
		[ 'palamut/column', { width: '50' } ],
	],
	'25-75' : [
		[ 'palamut/column', { width: '25' } ],
		[ 'palamut/column', { width: '75' } ],
	],
	'75-25' : [
		[ 'palamut/column', { width: '75' } ],
		[ 'palamut/column', { width: '25' } ],
	],
	'66-33' : [
		[ 'palamut/column', { width: '66' } ],
		[ 'palamut/column', { width: '33' } ],
	],
	'33-66' : [
		[ 'palamut/column', { width: '33' } ],
		[ 'palamut/column', { width: '66' } ],
	],
	'33-33-33' : [
		[ 'palamut/column', { width: '33.33' } ],
		[ 'palamut/column', { width: '33.33' } ],
		[ 'palamut/column', { width: '33.33' } ],
	],
	'50-25-25' : [
		[ 'palamut/column', { width: '50' } ],
		[ 'palamut/column', { width: '25' } ],
		[ 'palamut/column', { width: '25' } ],
	],
	'25-25-50' : [
		[ 'palamut/column', { width: '25' } ],
		[ 'palamut/column', { width: '25' } ],
		[ 'palamut/column', { width: '50' } ],
	],
	'25-50-25' : [
		[ 'palamut/column', { width: '25' } ],
		[ 'palamut/column', { width: '50' } ],
		[ 'palamut/column', { width: '25' } ],
	],
	'20-60-20' : [
		[ 'palamut/column', { width: '20' } ],
		[ 'palamut/column', { width: '60' } ],
		[ 'palamut/column', { width: '20' } ],
	],
	'25-25-25-25' : [
		[ 'palamut/column', { width: '25' } ],
		[ 'palamut/column', { width: '25' } ],
		[ 'palamut/column', { width: '25' } ],
		[ 'palamut/column', { width: '25' } ],
	],
	'40-20-20-20' : [
		[ 'palamut/column', { width: '40' } ],
		[ 'palamut/column', { width: '20' } ],
		[ 'palamut/column', { width: '20' } ],
		[ 'palamut/column', { width: '20' } ],
	],
	'20-20-20-40' : [
		[ 'palamut/column', { width: '20' } ],
		[ 'palamut/column', { width: '20' } ],
		[ 'palamut/column', { width: '20' } ],
		[ 'palamut/column', { width: '40' } ],
	],
};

/**
 * Block edit function
 */
class Edit extends Component {

	constructor( props ) {
		super( ...arguments );

		this.state = {
			layoutSelection: true,
		}
	}

	numberToText( columns ) {
		if ( columns === 1 ) {
			return __( 'one' );
		} else if ( columns === 2 ) {
			return __( 'two' );
		} else if ( columns === 3 ) {
			return __( 'three' );
		} else if ( columns === 4 ) {
			return __( 'four' );
		}
	}

	render() {

		const {
			attributes,
			className,
			isSelected,
			toggleSelection,
			setAttributes,
			backgroundColor,
			textColor,
		} = this.props

		const {
			palamut,
			backgroundImg,
			id,
			columns,
			layout,
			gutter,
			stacked,
			paddingTop,
			paddingRight,
			paddingBottom,
			paddingLeft,
			marginTop,
			marginRight,
			marginBottom,
			marginLeft,
			paddingUnit,
			marginUnit,
			marginSize,
			paddingSize,
			hasAlignmentControls,
			isStackedOnMobile,
			focalPoint,
			hasParallax,
			backgroundType,
		} = attributes;

		const dropZone = (
			<BackgroundDropZone
				{ ...this.props }
				label={ sprintf( __( 'Add backround to %s' ), title.toLowerCase() ) } // translators: %s: Lowercase block title
			/>
		);

		const columnOptions = [
			{ columns: 1, name: __( 'One Column' ), icon: rowIcons.colOne, key: '100', },
			{ columns: 2, name: __( 'Two Columns' ), icon: rowIcons.colTwo },
			{ columns: 3, name: __( 'Three Columns' ), icon: rowIcons.colThree },
			{ columns: 4, name: __( 'Four Columns' ), icon: rowIcons.colFour },
		];

		let selectedRows = 1;

		if ( columns ) {
			selectedRows = parseInt( columns.toString().split('-') );
		}

		if ( ! layout && this.state.layoutSelection ) {
			return [
				<Fragment>
					{ isSelected && (
						<Controls
							{ ...this.props }
						/>
					) }
					{ isSelected && (
						<Inspector
							{ ...this.props }
						/>
					) }
					<Placeholder
						key="placeholder"
						icon={ columns ? rowIcons.layout : rowIcons.row }
						label={ columns ? __( 'Row Layout' ) : __( 'Row' ) }
						instructions={ columns ? sprintf( __( 'Now select a layout for this %s column row.' ), this.numberToText( columns ) ) : __( 'Select the number of columns for this row.' ) }
						className={ 'components-palamut-visual-dropdown' }
					>
						{ ! columns ?
							<ButtonGroup aria-label={ __( 'Select Row Columns' ) }>
								{ map( columnOptions, ( { name, key, icon, columns } ) => (
									<Tooltip text={ name }>
										<div className="components-palamut-visual-dropdown__button-wrapper">
											<Button
												className="components-palamut-visual-dropdown__button"
												isSmall
												onClick={ () => {
													setAttributes( {
														columns: columns,
														layout: columns === 1 ? key : null,
													} );

													{ columns === 1 &&
														this.setState( { 'layoutSelection' : false } );
													}
												} }
											>
												{ icon }
											</Button>
										</div>
									</Tooltip>
								) ) }
							</ButtonGroup>
						:
							<Fragment>
								<ButtonGroup aria-label={ __( 'Select Row Layout' ) }>
									<IconButton
										icon="exit"
										className="components-palamut-visual-dropdown__back"
										onClick={ () => {
											setAttributes( {
												columns: null,
											} );
											this.setState( { 'layoutSelection' : true } );
										} }
										label={ __( 'Back to Columns' ) }
									/>
									{ map( layoutOptions[ selectedRows ], ( { name, key, icon, cols } ) => (
										<Tooltip text={ name }>
											<div className="components-palamut-visual-dropdown__button-wrapper">
												<Button
													key={ key }
													className="components-palamut-visual-dropdown__button"
													isSmall
													onClick={ () => {
														setAttributes( {
															layout: key,
														} );
														this.setState( { 'layoutSelection' : false } );
													} }
												>
													{ icon }
												</Button>
											</div>
										</Tooltip>
									) ) }
								</ButtonGroup>
							</Fragment>
						}
					</Placeholder>
				</Fragment>
			];
		}

		const classes = classnames(
			'wp-block-palamut-row', {
				[ `palamut-row--${ id }` ] : id,
				[ `palamut-row-${ palamut.id }` ] : palamut && ( typeof palamut.id != 'undefined' ),
			}
		);

		const innerClasses = classnames(
			'wp-block-palamut-row__inner',
			...BackgroundClasses( attributes ), {
				'has-text-color': textColor.color,
				[ `has-${ gutter }-gutter` ] : gutter,
				'has-padding': paddingSize && paddingSize != 'no',
				[ `has-${ paddingSize }-padding` ] : paddingSize && paddingSize != 'advanced',
				'has-margin': marginSize && marginSize != 'no',
				[ `has-${ marginSize }-margin` ] : marginSize && marginSize != 'advanced',
				'is-stacked-on-mobile': isStackedOnMobile,
			}
		);

		const innerStyles = {
			backgroundColor: backgroundColor.color,
			backgroundImage: backgroundImg && backgroundType == 'image' ? `url(${ backgroundImg })` : undefined,
			backgroundPosition: focalPoint && ! hasParallax ? `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%` : undefined,
			color: textColor.color,
			paddingTop: paddingSize === 'advanced' && paddingTop ? paddingTop + paddingUnit : undefined,
			paddingRight: paddingSize === 'advanced' && paddingRight ? paddingRight + paddingUnit : undefined,
			paddingBottom: paddingSize === 'advanced' && paddingBottom ? paddingBottom + paddingUnit : undefined,
			paddingLeft: paddingSize === 'advanced' && paddingLeft ? paddingLeft + paddingUnit : undefined,
			marginTop: marginSize === 'advanced' && marginTop ? marginTop + marginUnit : undefined,
			marginRight: marginSize === 'advanced' && marginRight ? marginRight + marginUnit : undefined,
			marginBottom: marginSize === 'advanced' && marginBottom ? marginBottom + marginUnit : undefined,
			marginLeft: marginSize === 'advanced' && marginLeft ? marginLeft + marginUnit : undefined,
		};

		return [
			<Fragment>
				{ dropZone }
				{ isSelected && (
					<Controls
						{ ...this.props }
					/>
				) }
				{ isSelected && (
					<Inspector
						{ ...this.props }
					/>
				) }
				<div className={ classes }>
					{ isBlobURL( backgroundImg ) && <Spinner /> }
					{ BackgroundVideo( attributes ) }
					<div className={ innerClasses } style={ innerStyles }>
						<InnerBlocks
							template={ TEMPLATE[ layout ] }
							templateLock="all"
							allowedBlocks={ ALLOWED_BLOCKS }
							templateInsertUpdatesSelection={ columns === 1 ? true : false } />
					</div>
				</div>
			</Fragment>
		];
	}
};

export default compose( [
	applyWithColors,
] )( Edit );

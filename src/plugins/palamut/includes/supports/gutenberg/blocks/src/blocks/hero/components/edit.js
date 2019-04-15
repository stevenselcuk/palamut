/**
 * External dependencies
 */
import classnames from 'classnames';
import memoize from 'memize';
import times from 'lodash/times';

/**
 * Internal dependencies
 */
import { title } from '../'
import Inspector from './inspector';
import Controls from './controls';
import applyWithColors from './colors';
import BackgroundPanel, { BackgroundClasses, BackgroundDropZone, BackgroundVideo } from '../../../components/background';

/**
 * WordPress dependencies
 */
const { __, _x, sprintf } = wp.i18n;
const { compose } = wp.compose;
const { Component, Fragment } = wp.element;
const { InnerBlocks } = wp.editor;
const { ResizableBox, Spinner } = wp.components;
const { isBlobURL } = wp.blob;

/**
 * Constants
 */

/**
 * Allowed blocks and template constant is passed to InnerBlocks precisely as specified here.
 * The contents of the array should never change.
 * The array should contain the name of each block that is allowed.
 * In standout block, the only block we allow is 'core/list'.
 *
 * @constant
 * @type {string[]}
*/
const ALLOWED_BLOCKS = [ 'core/heading', 'core/paragraph', 'core/spacer', 'core/button', 'core/list', 'core/image', 'palamut/alert', 'palamut/gif', 'palamut/social', 'palamut/row' , 'palamut/column', 'palamut/buttons' ];
const TEMPLATE = [
	[ 'core/heading', { placeholder: _x( 'Add heading...', 'content placeholder' ), content: _x( 'Hero Block', 'content placeholder' ) , level: 2 } ],
	[ 'core/paragraph', { placeholder: _x( 'Add content...', 'content placeholder' ), content: _x( 'An introductory area of a page accompanied by a small amount of text and a call to action.', 'content placeholder' ) } ],
	[ 'palamut/buttons', { contentAlign: 'left', items: 2, gutter: 'medium' },
		[
			[ 'core/button', { text: _x( 'Primary', 'content placeholder' ) } ],
			[ 'core/button', { text: _x( 'Secondary', 'content placeholder' ), className: 'is-style-outline' } ],
		]
	],
];
/**
 * Block edit function
 */
class Edit extends Component {

	constructor( props ) {
		super( ...arguments );

		this.state = {
			resizing: false,
		}
	}

	componentDidMount() {
		let currentBlock = document.getElementById( 'block-' + this.props.clientId );
		if( currentBlock ){
			currentBlock.getElementsByClassName( 'wp-block-palamut-hero__box' )[0].style.width = 'auto';
			currentBlock.getElementsByClassName( 'wp-block-palamut-hero__box' )[0].style.maxWidth = this.props.attributes.maxWidth + 'px';
		}
	}

	render() {

		const {
			clientId,
			attributes,
			className,
			isSelected,
			setAttributes,
			backgroundColor,
			textColor,
			toggleSelection,
		} = this.props;

		const {
			id,
			palamut,
			layout,
			fullscreen,
			maxWidth,
			backgroundImg,
			backgroundType,
			paddingSize,
			paddingTop,
			paddingRight,
			paddingBottom,
			paddingLeft,
			paddingUnit,
			mediaPosition,
			contentAlign,
			focalPoint,
			hasParallax,
		} = attributes;

		const dropZone = (
			<BackgroundDropZone
				{ ...this.props }
				label={ sprintf( __( 'Add backround to %s' ), title.toLowerCase() ) } // translators: %s: Lowercase block title
			/>
		);

		const classes = classnames(
			'wp-block-palamut-hero', {
				[ `palamut-hero-${ palamut.id }` ] : palamut && ( typeof palamut.id != 'undefined' ),
			}
		);

		const innerClasses = classnames(
			'wp-block-palamut-hero__inner',
			...BackgroundClasses( attributes ), {
				[ `hero-${ layout }-align` ] : layout,
				'has-text-color': textColor.color,
				'has-padding': paddingSize && paddingSize != 'no',
				[ `has-${ paddingSize }-padding` ] : paddingSize && paddingSize != 'advanced',
				[ `has-${ contentAlign }-content` ]: contentAlign,
				'is-fullscreen': fullscreen,
			}
		);

		const innerStyles = {
			backgroundColor: backgroundColor.color,
			backgroundImage: backgroundImg && backgroundType == 'image' ? `url(${ backgroundImg })` : undefined,
			color: textColor.color,
			paddingTop: paddingSize === 'advanced' && paddingTop ? paddingTop + paddingUnit : undefined,
			paddingRight: paddingSize === 'advanced' && paddingRight ? paddingRight + paddingUnit : undefined,
			paddingBottom: paddingSize === 'advanced' && paddingBottom ? paddingBottom + paddingUnit : undefined,
			paddingLeft: paddingSize === 'advanced' && paddingLeft ? paddingLeft + paddingUnit : undefined,
			backgroundPosition: focalPoint && ! hasParallax ? `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%` : undefined,
		};

		const enablePositions = {
			top: false,
			right: true,
			bottom: false,
			left: true,
			topRight: false,
			bottomRight: false,
			bottomLeft: false,
			topLeft: false,
		};

		return [
			<Fragment>
				{ dropZone }
				{ isSelected && (
					<Inspector
						{ ...this.props }
					/>
				) }
				{ isSelected && (
					<Controls
						{ ...this.props }
					/>
				) }
				<div
					className={ classes }
				>
					<div className={ innerClasses } style={ innerStyles } >
						{ isBlobURL( backgroundImg ) && <Spinner /> }
						{ BackgroundVideo( attributes ) }
						{ ( typeof this.props.insertBlocksAfter !== 'undefined' ) && (
							<ResizableBox
								className={ classnames(
									'wp-block-palamut-hero__box',
									'editor-media-container__resizer', {
										'is-resizing' : this.state.resizing,
									}
								) }
								size={ { width: maxWidth } }
								minWidth="400"
								maxWidth="1000"
								enable={ enablePositions }
								onResizeStart={ () => {
									this.setState( { resizing: true } );
									toggleSelection( false );
									let currentBlock = document.getElementById( 'block-' + clientId );
									currentBlock.getElementsByClassName( 'wp-block-palamut-hero__box' )[0].style.maxWidth = '';
									currentBlock.getElementsByClassName( 'wp-block-palamut-hero__box' )[0].style.width = maxWidth + 'px';
								} }
								onResizeStop={ ( event, direction, elt, delta ) => {
									setAttributes( {
										maxWidth: parseInt( maxWidth + delta.width, 10 ),
									} );
									toggleSelection( true );
									this.setState( { resizing: false } );
									let currentBlock = document.getElementById( 'block-' + clientId );
									currentBlock.getElementsByClassName( 'wp-block-palamut-hero__box' )[0].style.width = 'auto';
									currentBlock.getElementsByClassName( 'wp-block-palamut-hero__box' )[0].style.maxWidth = parseInt( maxWidth + delta.width, 10 ) + 'px';
								} }
							>
								<InnerBlocks
									template={ TEMPLATE }
									allowedBlocks={ ALLOWED_BLOCKS }
									templateLock={ false }
									templateInsertUpdatesSelection={ false }
								/>
							</ResizableBox>
						) }
					</div>
				</div>
			</Fragment>
		];
	}
}

export default compose( [
	applyWithColors,
] )( Edit );

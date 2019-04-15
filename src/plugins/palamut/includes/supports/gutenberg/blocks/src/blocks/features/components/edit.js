/**
 * External dependencies
 */
import classnames from 'classnames';
import memoize from 'memize';
import times from 'lodash/times';

/**
 * Internal dependencies
 */
import BackgroundPanel, { BackgroundClasses, BackgroundDropZone, BackgroundVideo } from '../../../components/background';
import applyWithColors from './colors';
import Inspector from './inspector';
import Controls from './controls';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks } = wp.editor;
const { isBlobURL } = wp.blob;
const { Spinner } = wp.components;

/**
 * Constants
 */
const ALLOWED_BLOCKS = [ 'palamut/feature' ];

/**
 * Returns the layouts configuration for a given number of feature items.
 *
 * @param {number} count Number of feature items.
 *
 * @return {Object[]} Columns layout configuration.
 */
const getCount = memoize( ( count ) => {
	return times( count, () => [ 'palamut/feature' ] );
} );

/**
 * Block edit function
 */
class Edit extends Component {
	constructor( props ) {
		super( ...arguments );
	}

	render() {
		const {
			attributes,
			backgroundColor,
			textColor,
			className,
			isSelected,
			setAttributes,
		} = this.props;

		const {
			palamut,
			backgroundImg,
			columns,
			contentAlign,
			gutter,
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
			focalPoint,
			hasParallax,
			backgroundType,
		} = attributes;

		const dropZone = (
			<BackgroundDropZone
				{ ...this.props }
				label={ __( 'Add as backround' ) }
			/>
		);

		const classes = classnames(
			className, {
				[ `palamut-features-${ palamut.id }` ]: palamut && ( typeof palamut.id !== 'undefined' ),
			}
		);

		const innerClasses = classnames(
			'wp-block-palamut-features__inner',
			...BackgroundClasses( attributes ), {
				[ `has-${ gutter }-gutter` ]: gutter,
				'has-padding': paddingSize && paddingSize != 'no',
				[ `has-${ paddingSize }-padding` ]: paddingSize && paddingSize != 'advanced',
				'has-margin': marginSize && marginSize != 'no',
				[ `has-${ marginSize }-margin` ]: marginSize && marginSize != 'advanced',
				[ `has-${ contentAlign }-content` ]: contentAlign,
			}
		);

		const innerStyles = {
			backgroundColor: backgroundColor.color,
			backgroundImage: backgroundImg && backgroundType == 'image' ? `url(${ backgroundImg })` : undefined,
			backgroundPosition: focalPoint && ! hasParallax ? `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%` : undefined,
			color: textColor.color,
			textAlign: contentAlign,
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
				<div
					className={ classes }
				>
					<div className={ innerClasses } style={ innerStyles }>
						{ isBlobURL( backgroundImg ) && <Spinner /> }
						{ BackgroundVideo( attributes ) }
						<InnerBlocks
							template={ getCount( columns ) }
							allowedBlocks={ ALLOWED_BLOCKS }
							templateLock="all"
							templateInsertUpdatesSelection={ false } />
					</div>
				</div>
			</Fragment>,
		];
	}
}

export default compose( [
	applyWithColors,
] )( Edit );

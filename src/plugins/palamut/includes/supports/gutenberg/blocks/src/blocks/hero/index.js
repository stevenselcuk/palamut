/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import './styles/style.scss';
import './styles/editor.scss';
import icons from './components/icons';
import Edit from './components/edit';
import BackgroundPanel, { BackgroundAttributes, BackgroundClasses, BackgroundTransforms, BackgroundVideo } from '../../components/background';
import DimensionsAttributes from '../../components/dimensions-control/attributes';
import CSSGridAttributes from '../../components/grid-control/attributes';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { createBlock } = wp.blocks;
const { RichText, getColorClassName, getFontSizeClass, InnerBlocks } = wp.editor;


/**
 * Block constants
 */
const name = 'hero';

const title = __( 'Hero' );

const icon = icons.hero;

const keywords = [
	__( 'button' ),
	__( 'cta' ),
	__( 'call to action' ),
];

const blockAttributes = {
	...CSSGridAttributes,
	...DimensionsAttributes,
	...BackgroundAttributes,
	align: {
		type: 'string',
		default: 'full',
	},
	contentAlign: {
		type: 'string',
	},
	textColor: {
		type: 'string',
	},
	customTextColor: {
		type: 'string',
	},
	maxWidth: {
		type: 'number',
		default: 560,
	},
	savePalamutMeta: {
		type: 'boolean',
		default: true,
	},
	paddingSize: {
		type: 'string',
		default: 'huge',
	},
	paddingUnit: {
		type: 'string',
		default: 'px',
	},
	paddingTop: {
		type: 'number',
		default: 60,
	},
	paddingBottom: {
		type: 'number',
		default: 60,
	},
	paddingLeft: {
		type: 'number',
		default: 60,
	},
	paddingRight: {
		type: 'number',
		default: 60,
	},
	customBackgroundColor: {
		type: 'string',
		default: '#f3f3f3',
	},
};

const settings = {

	title: title,

	description: __( 'An introductory area of a page accompanied by a small amount of text and a call to action.' ),

	keywords: keywords,

	attributes: blockAttributes,

	supports: {
		align: [ 'wide', 'full' ],
		coBlocksSpacing: true,
	},

	transforms: {
		from: [
			{
				type: 'prefix',
				prefix: ':hero',
				transform: function( content ) {
					return createBlock( `palamut/${ name }`, {
						content,
					} );
				},
			},
		],
	},

	edit: Edit,

	save( { attributes, className } ) {
		const {
				palamut,
				layout,
				fullscreen,
				maxWidth,
				backgroundImg,
				backgroundType,
				paddingSize,
				backgroundColor,
				customBackgroundColor,
				customTextColor,
				textColor,
				contentAlign,
				focalPoint,
				hasParallax,
				videoMuted,
				videoLoop,
			} = attributes;

			const textClass = getColorClassName( 'color', textColor );
			const backgroundClass = getColorClassName( 'background-color', backgroundColor );

			let classlist = {
				'has-text-color': textColor || customTextColor,
				[ textClass ]: textClass,
				[ `palamut-hero-${ palamut.id }` ] : palamut && ( typeof palamut.id != 'undefined' ),
			};

			const classes = classnames( classlist );

			const styles = {
				color: textClass ? undefined : customTextColor,
			};

			const innerClasses = classnames(
				'wp-block-palamut-hero__inner',
				...BackgroundClasses( attributes ), {
					[ `hero-${ layout }-align` ] : layout,
					'has-text-color': textColor && textColor.color,
					'has-padding': paddingSize && paddingSize != 'no',
					[ `has-${ paddingSize }-padding` ] : paddingSize && paddingSize != 'advanced',
					[ backgroundClass ]: backgroundClass,
					[ `has-${ contentAlign }-content` ]: contentAlign,
					'is-fullscreen': fullscreen,
			} );

			const innerStyles = {
				backgroundColor: backgroundClass ? undefined : customBackgroundColor,
				backgroundImage: backgroundImg && backgroundType == 'image' ? `url(${ backgroundImg })` : undefined,
				color: textColor ? textColor.color : undefined,
				backgroundPosition: focalPoint && ! hasParallax ? `${ focalPoint.x * 100 }% ${ focalPoint.y * 100 }%` : undefined,
			};

			return (
				<div className={ classes } style={ styles } >
					<div className={ innerClasses } style={ innerStyles }>
						{ BackgroundVideo( attributes ) }
						<div className="wp-block-palamut-hero__box" style={ { maxWidth: maxWidth ? maxWidth + 'px' : undefined } }>
							<InnerBlocks.Content />
						</div>
					</div>
				</div>
			);
	},
};

export { name, title, icon, settings };

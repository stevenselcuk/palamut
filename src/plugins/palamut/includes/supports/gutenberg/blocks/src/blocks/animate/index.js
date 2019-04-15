/**
 * BLOCK: palamut/animate
 */

// Import block dependencies
import anchorPlacementOptions from './anchor-placement-options';
import animationOptions from './animation-options';
import easingOptions from './easing-options';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const {
	InnerBlocks,
	InspectorControls,
} = wp.editor;
const {
	PanelBody,
	TextControl,
	SelectControl,
	ToggleControl,
	RangeControl,
} = wp.components;
const { applyFilters } = wp.hooks;

const aosDefaultOptions = {
	animation: 'fade',
	offset: 120,
	delay: 0,
	duration: 400,
	easing: 'ease',
	once: true,
	mirror: false,
	anchorPlacement: 'top-bottom',
};

let defaultOptions = {
	animation: animationOptions && animationOptions.length > 0 ? animationOptions[ 0 ].value : 'fade',
	offset: 120,
	delay: 0,
	duration: 400,
	easing: easingOptions && easingOptions.length > 0 ? easingOptions[ 0 ].value : 'ease',
	once: true,
	mirror: false,
	anchorPlacement: anchorPlacementOptions && anchorPlacementOptions.length > 0 ? anchorPlacementOptions[ 0 ].value : 'top-bottom',
};
defaultOptions = applyFilters( 'animateBlocks.defaultOptions', defaultOptions );

registerBlockType( 'palamut/animate', {
	title: __( 'Animate Block', 'palamut' ),
	icon: 'controls-forward',
	category: 'palamut',
	description: __( 'Creates an animated container', 'palamut' ),

	attributes: {
		animation: {
			type: 'string',
			default: defaultOptions.animation,
		},
		offset: {
			type: 'number',
			default: defaultOptions.offset,
		},
		delay: {
			type: 'number',
			default: defaultOptions.delay,
		},
		duration: {
			type: 'number',
			default: defaultOptions.duration,
		},
		easing: {
			type: 'string',
			default: defaultOptions.easing,
		},
		once: {
			type: 'boolean',
			default: defaultOptions.once,
		},
		mirror: {
			type: 'boolean',
			default: defaultOptions.mirror,
		},
		anchorPlacement: {
			type: 'string',
			default: defaultOptions.anchorPlacement,
		},
	},

	edit( { attributes, setAttributes, className } ) {
		const {
			animation = '',
			offset,
			delay,
			duration,
			easing,
			once,
			mirror,
			anchorPlacement,
		} = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody
						title={ __( 'Animation options', 'palamut' ) }
						initialOpen={ true }
					>
						<SelectControl
							label={ __( 'Animation', 'palamut' ) }
							value={ animation }
							options={ animationOptions }
							onChange={ ( selectedOption ) => setAttributes( { animation: selectedOption } ) }
						/>
						<RangeControl
							label={ __( 'Delay (ms)' ) }
							value={ delay }
							onChange={ ( value ) => setAttributes( { delay: value } ) }
							min={ 0 }
							max={ 3000 }
							step={ 50 }
						/>
						<RangeControl
							label={ __( 'Duration (ms)' ) }
							value={ duration }
							onChange={ ( value ) => setAttributes( { duration: value } ) }
							min={ 0 }
							max={ 3000 }
							step={ 50 }
						/>
						<TextControl
							label={ __( 'Offset (px)', 'palamut' ) }
							help={ __( 'offset (in px) from the original trigger point', 'palamut' ) }
							type="number"
							value={ offset }
							onChange={ ( value ) => setAttributes( { offset: value } ) }
						/>
						<SelectControl
							label={ __( 'Easing', 'palamut' ) }
							help={ __( 'easing function for animations', 'palamut' ) }
							value={ easing }
							options={ easingOptions }
							onChange={ ( selectedOption ) => setAttributes( { easing: selectedOption } ) }
						/>
						<ToggleControl
							label={ __( 'Once', 'palamut' ) }
							help={ 'whether animation should happen only once - while scrolling down' }
							checked={ once }
							onChange={ ( checked ) => setAttributes( { once: checked } ) }
						/>
						<ToggleControl
							label={ __( 'Mirror', 'palamut' ) }
							help={ 'whether elements should animate out while scrolling past them' }
							checked={ mirror }
							onChange={ ( checked ) => setAttributes( { mirror: checked } ) }
						/>
						<SelectControl
							label={ __( 'Anchor placement', 'palamut' ) }
							help={ __( 'defines which position of the element regarding to window should trigger the animation', 'palamut' ) }
							value={ anchorPlacement }
							options={ anchorPlacementOptions }
							onChange={ ( selectedOption ) => setAttributes( { anchorPlacement: selectedOption } ) }
						/>
					</PanelBody>
				</InspectorControls>
				<div className={ className }>
					<InnerBlocks />
				</div>
			</Fragment>
		);
	},

	save( { attributes, className } ) {
		const {
			animation = '',
			offset,
			delay,
			duration,
			easing,
			once,
			mirror,
			anchorPlacement,
		} = attributes;

		return (
			<div
				className={ className }
				data-aos={ animation }
				{ ...( delay !== aosDefaultOptions.delay && { 'data-aos-delay': delay } ) }
				{ ...( duration !== aosDefaultOptions.duration && { 'data-aos-duration': duration } ) }
				{ ...( offset !== aosDefaultOptions.offset && { 'data-aos-offset': offset } ) }
				{ ...( easing !== aosDefaultOptions.easing && { 'data-aos-easing': easing } ) }
				{ ...( once !== aosDefaultOptions.once && { 'data-aos-once': once } ) }
				{ ...( mirror !== aosDefaultOptions.mirror && { 'data-aos-mirror': mirror } ) }
				{ ...( anchorPlacement !== aosDefaultOptions.anchorPlacement && { 'data-aos-anchor-placement': anchorPlacement } ) }
			>
				<InnerBlocks.Content />
			</div>
		);
	},
} );

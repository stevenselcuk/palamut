// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

import SwiperPostSelector from './components/SwiperPostSelector';
import {
	SwiperEffectSelect,
	SwiperPerView,
	SwiperLoopToggle,
	SwiperAutoPlayToggle,
	SwiperCenterToggle,
	SwiperMoreToggle,
	SwiperNavigationToggle,
	NextArrow,
	PrevArrow,
	SwiperPaginationToggle,
	SwiperFeaturedImage,
	SwiperDateToggle,
} from './components';

// WP Components
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { Fragment, RawHTML } = wp.element;
const { InspectorControls } = wp.editor;
const { PanelBody, ColorPicker, SVG, Path, G } = wp.components;
const { dateI18n } = wp.date;

const icons = {};

icons.slider =
<SVG className="dashicon components-palamut-svg" height="24" viewBox="0 0 512 512" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="m494.933594 0h-477.867188c-9.421875.0078125-17.0585935 7.644531-17.066406 17.066406v204.800782c.0078125 9.421874 7.644531 17.058593 17.066406 17.066406h477.867188c9.421875-.011719 17.054687-7.644532 17.066406-17.066406v-204.800782c-.011719-9.421875-7.644531-17.0546872-17.066406-17.066406zm-477.867188 221.867188v-204.800782h477.867188l.007812 204.800782zm0 0"/><path d="m82.832031 79.300781c-1.597656-1.601562-3.769531-2.5-6.03125-2.5-2.265625 0-4.433593.898438-6.035156 2.5l-34.132813 34.132813c-1.601562 1.597656-2.5 3.769531-2.5 6.03125 0 2.265625.898438 4.433594 2.5 6.035156l34.132813 34.132812c3.347656 3.234376 8.671875 3.1875 11.964844-.105468 3.289062-3.289063 3.335937-8.613282.101562-11.960938l-28.097656-28.101562 28.097656-28.097656c1.601563-1.601563 2.5-3.769532 2.5-6.035157 0-2.261719-.898437-4.433593-2.5-6.03125zm0 0"/><path d="m441.234375 79.300781c-3.347656-3.234375-8.671875-3.1875-11.964844.101563-3.289062 3.292968-3.335937 8.617187-.101562 11.964844l28.097656 28.097656-28.097656 28.101562c-2.21875 2.144532-3.109375 5.316406-2.328125 8.300782.78125 2.980468 3.109375 5.3125 6.09375 6.09375s6.15625-.109376 8.300781-2.328126l34.132813-34.132812c1.601562-1.601562 2.5-3.769531 2.5-6.035156 0-2.261719-.898438-4.433594-2.5-6.03125zm0 0"/><path d="m256 34.132812h-136.535156c-9.421875.011719-17.054688 7.644532-17.066406 17.066407v136.535156c.011718 9.421875 7.644531 17.054687 17.066406 17.066406h136.535156c4.863281-.015625 9.484375-2.117187 12.695312-5.769531.113282-.132812.222657-.257812.324219-.394531 2.597657-3.039063 4.03125-6.902344 4.046875-10.902344v-136.535156c-.007812-9.421875-7.644531-17.054688-17.066406-17.066407zm-46.132812 153.601563-7.746094-14.210937 19.746094-36.222657 27.480468 50.433594zm46.132812-136.535156.011719 113.09375-19.160157-35.15625c-2.992187-5.484375-8.738281-8.894531-14.984374-8.894531-6.246094 0-11.992188 3.410156-14.984376 8.894531l-14.484374 26.570312-23.816407-43.675781c-2.988281-5.476562-8.734375-8.882812-14.972656-8.882812h-.007813c-6.246093.003906-11.988281 3.417968-14.972656 8.902343l-19.164062 35.128907v-95.980469zm-136.535156 131.625 34.144531-62.613281 36.816406 67.523437h-70.960937zm0 0"/><path d="m409.601562 42.667969h-110.933593c-4.714844 0-8.535157 3.820312-8.535157 8.53125 0 4.714843 3.820313 8.535156 8.535157 8.535156h110.933593c4.710938 0 8.53125-3.820313 8.53125-8.535156 0-4.710938-3.820312-8.53125-8.53125-8.53125zm0 0"/><path d="m392.535156 76.800781h-93.867187c-4.714844 0-8.535157 3.820313-8.535157 8.53125 0 4.714844 3.820313 8.535157 8.535157 8.535157h93.867187c4.710938 0 8.53125-3.820313 8.53125-8.535157 0-4.710937-3.820312-8.53125-8.53125-8.53125zm0 0"/><path d="m366.933594 110.933594h-68.265625c-4.714844 0-8.535157 3.820312-8.535157 8.53125 0 4.714844 3.820313 8.535156 8.535157 8.535156h68.265625c4.710937 0 8.53125-3.820312 8.53125-8.535156 0-4.710938-3.820313-8.53125-8.53125-8.53125zm0 0"/><path d="m341.332031 145.066406h-42.664062c-4.714844 0-8.535157 3.820313-8.535157 8.535156 0 4.710938 3.820313 8.53125 8.535157 8.53125h42.664062c4.714844 0 8.535157-3.820312 8.535157-8.53125 0-4.714843-3.820313-8.535156-8.535157-8.535156zm0 0"/><path d="m315.734375 179.199219h-17.066406c-4.714844 0-8.535157 3.820312-8.535157 8.535156 0 4.710937 3.820313 8.53125 8.535157 8.53125h17.066406c4.710937 0 8.53125-3.820313 8.53125-8.53125 0-4.714844-3.820313-8.535156-8.53125-8.535156zm0 0"/><path d="m196.265625 110.933594c14.140625 0 25.601563-11.460938 25.601563-25.601563 0-14.136719-11.460938-25.597656-25.601563-25.597656-14.136719 0-25.597656 11.460937-25.597656 25.597656.015625 14.132813 11.464843 25.585938 25.597656 25.601563zm0-34.132813c4.714844 0 8.535156 3.820313 8.535156 8.53125 0 4.714844-3.820312 8.535157-8.535156 8.535157-4.710937 0-8.53125-3.820313-8.53125-8.535157.003906-4.710937 3.820313-8.527343 8.53125-8.53125zm0 0"/><path d="m128 315.734375c0-14.140625-11.460938-25.601563-25.601562-25.601563-14.136719 0-25.597657 11.460938-25.597657 25.601563 0 14.136719 11.460938 25.597656 25.597657 25.597656 14.132812-.015625 25.585937-11.464843 25.601562-25.597656zm-34.132812 0c0-4.714844 3.820312-8.535156 8.53125-8.535156 4.714843 0 8.535156 3.820312 8.535156 8.535156 0 4.710937-3.820313 8.53125-8.535156 8.53125-4.707032-.003906-8.527344-3.820313-8.53125-8.53125zm0 0"/><path d="m230.398438 315.734375c0-14.140625-11.460938-25.601563-25.597657-25.601563-14.140625 0-25.601562 11.460938-25.601562 25.601563 0 14.136719 11.460937 25.597656 25.601562 25.597656 14.132813-.015625 25.582031-11.464843 25.597657-25.597656zm-34.132813 0c0-4.714844 3.820313-8.535156 8.535156-8.535156 4.710938 0 8.53125 3.820312 8.53125 8.535156 0 4.710937-3.820312 8.53125-8.53125 8.53125-4.710937-.003906-8.527343-3.820313-8.535156-8.53125zm0 0"/><path d="m332.800781 315.734375c0-14.140625-11.460937-25.601563-25.601562-25.601563-14.136719 0-25.597657 11.460938-25.597657 25.601563 0 14.136719 11.460938 25.597656 25.597657 25.597656 14.132812-.015625 25.585937-11.464843 25.601562-25.597656zm-25.601562 8.53125c-4.710938 0-8.53125-3.820313-8.53125-8.53125 0-4.714844 3.820312-8.535156 8.53125-8.535156 4.714843 0 8.535156 3.820312 8.535156 8.535156-.007813 4.710937-3.824219 8.527344-8.535156 8.53125zm0 0"/><path d="m435.199219 315.734375c0-14.140625-11.460938-25.601563-25.597657-25.601563-14.140624 0-25.601562 11.460938-25.601562 25.601563 0 14.136719 11.460938 25.597656 25.601562 25.597656 14.128907-.015625 25.582032-11.464843 25.597657-25.597656zm-34.132813 0c0-4.714844 3.820313-8.535156 8.535156-8.535156 4.710938 0 8.53125 3.820312 8.53125 8.535156 0 4.710937-3.820312 8.53125-8.53125 8.53125-4.710937-.003906-8.53125-3.820313-8.535156-8.53125zm0 0"/><path d="m162.132812 315.734375c0-32.992187-26.742187-59.734375-59.734374-59.734375-32.988282 0-59.730469 26.742188-59.730469 59.734375 0 32.988281 26.742187 59.730469 59.730469 59.730469 32.976562-.035156 59.699218-26.757813 59.734374-59.730469zm-102.398437 0c0-23.566406 19.101563-42.667969 42.664063-42.667969 23.566406 0 42.667968 19.101563 42.667968 42.667969 0 23.5625-19.101562 42.664063-42.667968 42.664063-23.550782-.027344-42.636719-19.113282-42.664063-42.664063zm0 0"/></SVG>

/**
 * Register Gutenberg Block
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 */
registerBlockType( 'palamut/postslider', {
	title: __( 'Post Slider' ),
	icon: icons.slider,
	category: 'palamut',
	keywords: [
		__( 'Post Swiper' ),
		__( 'Tyme' ),
		__( 'Carousel' ),
	],
	attributes: {
		posts: {
			type: 'array',
			default: [],
		},
		swiperEffect: {
			type: 'string',
			default: 'slide',
		},
		swiperPerView: {
			type: 'number',
			default: 1,
		},
		swiperLoop: {
			type: 'boolean',
			default: true,
		},
		swiperAutoPlay: {
			type: 'boolean',
			default: false,
		},
		swiperCentered: {
			type: 'boolean',
			default: true,
		},
		swiperReadMore: {
			type: 'boolean',
			default: false,
		},
		swiperReadMoreText: {
			type: 'string',
			default: __( 'Read more...' ),
		},
		swiperShowNav: {
			type: 'boolean',
			default: false,
		},
		swiperNavColor: {
			type: 'string',
			default: '#017AFF',
		},
		swiperShowPagi: {
			type: 'boolean',
			default: false,
		},
		swiperPagiType: {
			type: 'string',
			default: 'default',
		},
		swiperFeaturedImage: {
			type: 'boolean',
			default: true,
		},
		swiperLinkFeaturedImage: {
			type: 'boolean',
			default: false,
		},
		swiperShowDate: {
			type: 'boolean',
			default: false,
		},
	},

	edit: ( props ) => {
		const {
			posts,
			swiperEffect,
			swiperPerView,
			swiperLoop,
			swiperAutoPlay,
			swiperCentered,
			swiperReadMore,
			swiperReadMoreText,
			swiperShowNav,
			swiperNavColor,
			swiperShowPagi,
			swiperPagiType,
			swiperFeaturedImage,
			swiperLinkFeaturedImage,
			swiperShowDate,
		} = props.attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Swiper Posts' ) } icon="edit">
						<SwiperPostSelector
							onPostSelect={ ( post ) => {
								posts.push( post );
								props.setAttributes( { posts: [ ...posts ] } );
							} }
							posts={ posts }
							onChange={ ( newPost ) => {
								props.setAttributes( { posts: [ ...newPost ] } );
							} }
							postType={ 'post' }
							showSuggestions={ true }
						/>
					</PanelBody>

					<PanelBody title={ __( 'Post Settings' ) } icon="edit">
						<SwiperFeaturedImage
							onChange={ ( displayFeatured ) => {
								props.setAttributes( { swiperFeaturedImage: displayFeatured } );
							} }
							value={ swiperFeaturedImage }
							onLinkImageChange={ ( linkFeaturedImage ) => {
								props.setAttributes( { swiperLinkFeaturedImage: linkFeaturedImage } );
							} }
							linkImage={ swiperLinkFeaturedImage }
						/>
						<SwiperDateToggle
							onChange={ ( displayDate ) => {
								props.setAttributes( { swiperShowDate: displayDate } );
							} }
							value={ swiperShowDate }
						/>
						<SwiperMoreToggle
							onChange={ ( moreVal ) => {
								props.setAttributes( { swiperReadMore: moreVal } );
							} }
							value={ swiperReadMore }
							moreText={ swiperReadMoreText }
							onTextChange={ ( moreText ) => {
								props.setAttributes( { swiperReadMoreText: moreText } );
							} }
						/>
					</PanelBody>

					<PanelBody title={ __( 'Swiper Settings' ) } initialOpen={ false } icon="slides">
						<SwiperEffectSelect
							onChange={ ( newEffect ) => {
								props.setAttributes( { swiperEffect: newEffect } );
							} }
							value={ swiperEffect }
						/>
						<SwiperPerView
							onChange={ ( newPerView ) => {
								props.setAttributes( { swiperPerView: newPerView } );
							} }
							value={ swiperPerView }
						/>
						<SwiperLoopToggle
							onChange={ ( loopPosts ) => {
								props.setAttributes( { swiperLoop: loopPosts } );
							} }
							value={ swiperLoop }
						/>
						<SwiperCenterToggle
							onChange={ ( centerVal ) => {
								props.setAttributes( { swiperCentered: centerVal } );
							} }
							value={ swiperCentered }
						/>
						<SwiperAutoPlayToggle
							onChange={ ( autoPlayVal ) => {
								props.setAttributes( { swiperAutoPlay: autoPlayVal } );
							} }
							value={ swiperAutoPlay }
						/>
						<SwiperNavigationToggle
							onChange={ ( navVal ) => {
								props.setAttributes( { swiperShowNav: navVal } );
							} }
							value={ swiperShowNav }
						/>
						{
							swiperShowNav ? (
								<ColorPicker
									color={ swiperNavColor }
									onChangeComplete={ ( { hex } ) => {
										props.setAttributes( { swiperNavColor: hex } );
									} }
									disableAlpha
								/>
							) : null
						}
						<SwiperPaginationToggle
							onChange={ ( pagiVal ) => {
								props.setAttributes( { swiperShowPagi: pagiVal } );
							} }
							changeType={ ( pagiType ) => {
								props.setAttributes( { swiperPagiType: pagiType } );
							} }
							value={ swiperShowPagi }
							type={ swiperPagiType }
						/>
					</PanelBody>
				</InspectorControls>
				<div
					className="swiper-container"
					data-swiper-effect={ swiperEffect }
					data-swiper-perview={ swiperPerView }
					data-swiper-loop={ swiperLoop }
					data-swiper-autoplay={ swiperAutoPlay }
					data-swiper-centered={ swiperCentered }
					data-swiper-navigation={ swiperShowNav }
					data-swiper-pagination={ swiperShowPagi }
					data-swiper-pagination-type={ swiperPagiType }
					data-block-selected={ props.isSelected }
					data-swiper-more={ swiperReadMore }
				>
					<div className="swiper-wrapper">
						{ posts.map( post => (
							<div className="swiper-slide" key={ post.id }>
								{
									swiperFeaturedImage && post.image.length > 1 && swiperLinkFeaturedImage ? (
										<a href={ post.url }><img src={ post.image } alt={ post.title } /></a>
									) : null
								}
								{
									swiperFeaturedImage && post.image.length > 1 && ! swiperLinkFeaturedImage ? (
										<img src={ post.image } alt={ post.title } />
									) : null
								}
								<h2><a href={ post.url }>{ post.title }</a></h2>
								{
									swiperShowDate ? (
										<div className="post-date">{ dateI18n( 'F j, Y', post.date ) }</div>
									) : null
								}
								<RawHTML>{ post.excerpt }</RawHTML>
								{ swiperReadMore ? (
									<div className="read-more">
										<a href={ post.url }>{ swiperReadMoreText }</a>
									</div>
								) : null }
							</div>
						) ) }
					</div>

					{ swiperShowNav ? (
						<Fragment>
							<div className="swiper-button-next">
								<NextArrow color={ swiperNavColor } />
							</div>
							<div className="swiper-button-prev">
								<PrevArrow color={ swiperNavColor } />
							</div>
						</Fragment>
					) : null }

					{ swiperShowPagi ? (
						<div className="swiper-pagination"></div>
					) : null }
				</div>
			</Fragment>
		);
	},

	save: ( props ) => {
		const {
			posts,
			swiperEffect,
			swiperPerView,
			swiperLoop,
			swiperAutoPlay,
			swiperCentered,
			swiperReadMore,
			swiperReadMoreText,
			swiperShowNav,
			swiperNavColor,
			swiperShowPagi,
			swiperPagiType,
			swiperFeaturedImage,
			swiperLinkFeaturedImage,
			swiperShowDate,
		} = props.attributes;

		return (
			<div className="tyme-swiper">
				<div
					className="swiper-container"
					data-swiper-effect={ swiperEffect }
					data-swiper-perview={ swiperPerView }
					data-swiper-loop={ swiperLoop }
					data-swiper-autoplay={ swiperAutoPlay }
					data-swiper-centered={ swiperCentered }
					data-swiper-navigation={ swiperShowNav }
					data-swiper-pagination={ swiperShowPagi }
					data-swiper-pagination-type={ swiperPagiType }
					data-swiper-more={ swiperReadMore }
				>
					<div className="swiper-wrapper">
						{ posts.map( post => (
							<div className="swiper-slide" key={ post.id }>
								{
									swiperFeaturedImage && post.image.length > 1 && swiperLinkFeaturedImage ? (
										<a href={ post.url }><img src={ post.image } alt={ post.title } /></a>
									) : ''
								}
								{
									swiperFeaturedImage && post.image.length > 1 && ! swiperLinkFeaturedImage ? (
										<img src={ post.image } alt={ post.title } />
									) : ''
								}
								<h2><a href={ post.url }>{ post.title }</a></h2>
								{
									swiperShowDate ? (
										<div className="post-date">{ dateI18n( 'F j, Y', post.date ) }</div>
									) : ''
								}

								<RawHTML>{ post.excerpt }</RawHTML>
								{ swiperReadMore ? (
									<div className="read-more">
										<a href={ post.url }>{ swiperReadMoreText }</a>
									</div>
								) : '' }
							</div>
						) ) }
					</div>

					{ swiperShowNav ? (
						<Fragment>
							<div className="swiper-button-next">
								<NextArrow color={ swiperNavColor } />
							</div>
							<div className="swiper-button-prev">
								<PrevArrow color={ swiperNavColor } />
							</div>
						</Fragment>
					) : '' }

					{ swiperShowPagi ? (
						<div className="swiper-pagination"></div>
					) : '' }
				</div>
			</div>
		);
	},
} );

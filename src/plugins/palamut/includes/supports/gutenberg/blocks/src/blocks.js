/**
 * WordPress dependencies
 */
const { registerBlockType } = wp.blocks;

// Category slug and title
const category = {
	slug: 'palamut',
	title: 'Palamut',
};

// Custom foreground icon color based on the Palamut branding
const iconColor = '#1e35b9';

// Register block category
import icons from './utils/block-category';

// Editor and Frontend Styles
import './styles/editor.scss';
import './styles/style.scss';

// Extensions
import './extensions/colors/inspector';
import './extensions/typography';
import './extensions/attributes';
import './extensions/advanced-controls';
import './extensions/list-styles';
import './extensions/button-styles';
import './extensions/button-controls';

// Formats
import './formats/';

// Sidebars
import './sidebars/block-manager';

// Register Blocks
import * as accordion from './blocks/accordion';
import * as accordionItem from './blocks/accordion/accordion-item';
import * as alert from './blocks/alert';
import * as author from './blocks/author';
import * as clickToTweet from './blocks/click-to-tweet';
import * as column from './blocks/row/column';
import * as dynamicSeparator from './blocks/dynamic-separator';
import * as gif from './blocks/gif';
import * as highlight from './blocks/highlight';
import * as pricingTable from './blocks/pricing-table';
import * as pricingTableItem from './blocks/pricing-table/pricing-table-item';
import * as row from './blocks/row';
import * as social from './blocks/social';
import * as map from './blocks/map';
import * as mediaCard from './blocks/media-card';
import * as shapeDivider from './blocks/shape-divider';
import * as icon from './blocks/icon';
import * as feature from './blocks/features/feature';
import * as features from './blocks/features';
import * as buttons from './blocks/buttons';
import * as hero from './blocks/hero';
import * as postSlider from './blocks/post-slider';
import * as postGrid from './blocks/post-grid';
import * as animate from './blocks/animate';
//import * as team from './blocks/team-member';

export function registerBlocks() {
	[
		accordion,
		accordionItem,
		alert,
		author,
		clickToTweet,
		column,
		dynamicSeparator,
		gif,
		highlight,
		pricingTable,
		pricingTableItem,
		row,
		social,
		map,
		mediaCard,
		shapeDivider,
		icon,
		feature,
		features,
		buttons,
		hero,
		postGrid,
		postSlider,
		animate,
//		team,

	].forEach( ( block ) => {
		if ( ! block ) {
			return;
		}

		const { name, icon, settings } = block;

		registerBlockType( `palamut/${ name }`, { category: category.slug, icon: { src: icon, foreground: iconColor }, ...settings } );
	} );
}
registerBlocks();

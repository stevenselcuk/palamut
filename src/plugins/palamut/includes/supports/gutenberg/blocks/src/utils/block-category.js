/**
 * WordPress dependencies
 */
const { getCategories, setCategories } = wp.blocks;

/**
 * Internal dependencies
 */
import brandAssets from './brand-assets';

setCategories( [
	// Add a Palamut block category
	{
		slug: 'palamut',
		title: 'Palamut',
		icon: brandAssets.categoryIcon,
	},
	...getCategories().filter( ( { slug } ) => slug !== 'palamut' ),
] );

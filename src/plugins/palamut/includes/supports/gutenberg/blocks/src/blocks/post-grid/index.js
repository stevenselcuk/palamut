/**
 * BLOCK: Post Grid
 */

// Import block dependencies and components
import classnames from 'classnames';
import edit from './edit';

// Import CSS
import './styles/style.scss';
import './styles/editor.scss';

// Components
const { __ } = wp.i18n;

// Extend component
const { Component } = wp.element;

// Register block controls
const {
	registerBlockType,
} = wp.blocks;

// Register alignments
const validAlignments = [ 'center', 'wide' ];

export const name = 'core/latest-posts';

// Register the block
registerBlockType( 'palamut/postgrid', {
	title: __( 'Post Grid', 'palamut' ),
	description: __( 'Add a grid or list of customizable posts to your page.', 'palamut' ),
	icon: 'grid-view',
	category: 'palamut',
	keywords: [
		__( 'post', 'palamut' ),
		__( 'grid', 'palamut' ),
		__( 'palamut', 'palamut' ),
	],

	getEditWrapperProps( attributes ) {
		const { align } = attributes;
		if ( -1 !== validAlignments.indexOf( align ) ) {
			return { 'data-align': align };
		}
	},

	edit,

	// Render via PHP
	save() {
		return null;
	},
} );

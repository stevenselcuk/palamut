/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import Inspector from './inspector';
import applyWithColors from './colors';
import Controls from './controls';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks, RichText } = wp.editor;

/**
 * Constants
 */
const ALLOWED_BLOCKS = [ 'core/button', 'core/paragraph', 'core/heading', 'core/list', 'core/image', 'core/columns', 'core/column', 'palamut/row', 'palamut/column', 'palamut/highlight', 'palamut/alert',  'palamut/social' ];

const TEMPLATE = [ [ 'core/paragraph', { placeholder: 'Add content...' } ] ];

/**
 * Block edit function
 */
class Edit extends Component {

	render() {

		const {
			attributes,
			backgroundColor,
			className,
			isSelected,
			onReplace,
			setAttributes,
			textColor,
		} = this.props;

		const {
			open,
			title,
		} = attributes;

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
				<div
					className={ classnames(
						className,
						`${ className }--open`, {
							'is-selected': isSelected,
						}
					) }
				>
					<RichText
						tagName="p"
						placeholder={ __( 'Add accordion title...' ) }
						value={ title }
						className={ classnames(
							`${ className }__title`, {
								'has-background': backgroundColor.color,
								'has-text-color': textColor.color,
							}
						) }
						style={ {
							backgroundColor: backgroundColor.color,
							color: textColor.color,
						} }
						onChange={ ( nextTitle ) => setAttributes( { title: nextTitle } ) }
						keepPlaceholderOnFocus
						onRemove={ ( forward ) => {
							const hasEmptyTitle = typeof title == 'undefined' || ( typeof title != 'undefined' && title.length == 0 );

							if ( ! forward && hasEmptyTitle ) {
								onReplace( [] );
							}
						} }
					/>
					<div
						className={ `${ className }__content`  }
						style={ { borderColor: backgroundColor.color } }
						>
						<InnerBlocks
							allowedBlocks={ ALLOWED_BLOCKS }
							template={ TEMPLATE }
							templateInsertUpdatesSelection={ false }
						/>
					</div>
				</div>
			</Fragment>
		];
	}
}

export default compose( [
	applyWithColors,
] )( Edit );

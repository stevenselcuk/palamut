/**
 * External dependencies
 */
import classnames from 'classnames';
import includes from 'lodash/includes';

/**
 * Internal dependencies
 */
import Controls from './controls';
import Inspector from './inspector';
import applyWithColors from './colors';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { compose } = wp.compose;
const { Component, Fragment } = wp.element;

/**
 * Block edit function
 */
class Edit extends Component {

	constructor() {
		super( ...arguments );
	}

	getTextColor( isMaskStyle ) {

		const {
			backgroundColor,
			textColor,
		} = this.props;

		return isMaskStyle ? backgroundColor.color : textColor.color;
	}

	render() {

		const {
			attributes,
			className,
			isSelected,
			setAttributes,
			backgroundColor,
			textColor,
		} = this.props;

		const {
			borderRadius,
			facebook,
			hasColors,
			linkedin,
			pinterest,
			reddit,
			size,
			textAlign,
			tumblr,
			twitter,
			email,
			iconSize,
			google,
		} = attributes;

		const isMaskStyle = includes( className, 'is-style-mask' );

		const classes = classnames( className, {
				[ `has-button-size-${ size }` ] : size != 'med',
				'has-colors' : hasColors,
			}
		);

		const buttonClasses = classnames(
			`wp-block-button__link`,
			`wp-block-palamut-social__button`, {
				'has-background' : hasColors || backgroundColor.color,
				'has-text-color' : hasColors || textColor.color,
				[ textColor.class ]: textColor.class,
			}
		);

		const buttonStyles = {
			borderRadius: borderRadius ? borderRadius + 'px' : undefined,
			backgroundColor: ! hasColors && ! isMaskStyle ? backgroundColor.color : undefined,
			color: ! hasColors ? this.getTextColor( isMaskStyle ) : undefined,
		};

		const iconStyles = {
			height: isMaskStyle && iconSize ? iconSize + 'px' : undefined,
			width: isMaskStyle && iconSize ? iconSize + 'px' : undefined,
		};

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
				<div className={ classes } style={ { textAlign: textAlign } }>
					<ul>

					{ twitter &&
						<li>
							<a className={ classnames( buttonClasses, `wp-block-palamut-social__button--twitter` ) } style={ buttonStyles }>
								<span className="wp-block-palamut-social__icon" style={ iconStyles }></span>
								<span className="wp-block-palamut-social__text">{ __( 'Share on Twitter' ) }</span>
							</a>
						</li>
					}
					{ facebook &&
						<li>
							<a className={ classnames( buttonClasses, `wp-block-palamut-social__button--facebook` ) } style={ buttonStyles }>
								<span className="wp-block-palamut-social__icon" style={ iconStyles }></span>
								<span className="wp-block-palamut-social__text">{ __( 'Share on Facebook' ) }</span>
							</a>
						</li>
					}
					{ pinterest &&
						<li>
							<a className={ classnames( buttonClasses, `wp-block-palamut-social__button--pinterest` ) } style={ buttonStyles }>
								<span className="wp-block-palamut-social__icon" style={ iconStyles }></span>
								<span className="wp-block-palamut-social__text">{ __( 'Share on Pinterest' ) }</span>
							</a>
						</li>
					}
					{ linkedin &&
						<li>
							<a className={ classnames( buttonClasses, `wp-block-palamut-social__button--linkedin` ) } style={ buttonStyles }>
								<span className="wp-block-palamut-social__icon" style={ iconStyles }></span>
								<span className="wp-block-palamut-social__text">{ __( 'Share on LinkedIn' ) }</span>
							</a>
						</li>
					}
					{ email &&
						<li>
							<a className={ classnames( buttonClasses, `wp-block-palamut-social__button--email` ) } style={ buttonStyles }>
								<span className="wp-block-palamut-social__icon" style={ iconStyles }></span>
								<span className="wp-block-palamut-social__text">{ __( 'Share via Email' ) }</span>
							</a>
						</li>
					}
					{ tumblr &&
						<li>
							<a className={ classnames( buttonClasses, `wp-block-palamut-social__button--tumblr` ) } style={ buttonStyles }>
								<span className="wp-block-palamut-social__icon" style={ iconStyles }></span>
								<span className="wp-block-palamut-social__text">{ __( 'Share on Tumblr' ) }</span>
							</a>
						</li>
					}
					{ google &&
						<li>
							<a className={ classnames( buttonClasses, `wp-block-palamut-social__button--google` ) } style={ buttonStyles }>
								<span className="wp-block-palamut-social__icon" style={ iconStyles }></span>
								<span className="wp-block-palamut-social__text">{ __( 'Share on Google' ) }</span>
							</a>
						</li>
					}
					{ reddit &&
						<li>
							<a className={ classnames( buttonClasses, `wp-block-palamut-social__button--reddit` ) } style={ buttonStyles }>
								<span className="wp-block-palamut-social__icon" style={ iconStyles }></span>
								<span className="wp-block-palamut-social__text">{ __( 'Share on Reddit' ) }</span>
							</a>
						</li>
					}
					</ul>
				</div>
			</Fragment>
		];
	}
};

export default compose( [
	applyWithColors,
] )( Edit );

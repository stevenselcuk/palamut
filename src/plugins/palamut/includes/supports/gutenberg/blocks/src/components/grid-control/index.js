/**
 * External dependencies
 */
import classnames from 'classnames';
import map from 'lodash/map';

/**
 * Internal dependencies
 */
import CSSGridAttributes from './attributes';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { withInstanceId } = wp.compose;
const { dispatch, select } = wp.data;
const { Component, Fragment } = wp.element;
const { ButtonGroup, Button, Tooltip, ToggleControl } = wp.components;

class CSSGridControl extends Component {
	constructor( props ) {
		super( ...arguments );
	}

	render() {
		const {
			attributes,
			clientId,
			setAttributes,
			tooltip = true,
		} = this.props;

		const {
			layout,
			fullscreen,
		} = attributes;

		/**
		 * Set layout options and padding controls for Row Blocks
		 * This will make us of existing block instead of creating new one
		 */
		let layoutOptions = [
			{ value: 'top-left', label: __( 'Top Left' ) },
			{ value: 'top-center', label: __( 'Top Center' ) },
			{ value: 'top-right', label: __( 'Top Right' ) },
			{ value: 'center-left', label: __( 'Center Left' ) },
			{ value: 'center-center', label: __( 'Center Center' ) },
			{ value: 'center-right', label: __( 'Center Right' ) },
			{ value: 'bottom-left', label: __( 'Bottom Left' ) },
			{ value: 'bottom-center', label: __( 'Bottom Center' ) },
			{ value: 'bottom-right', label: __( 'Bottom Right' ) },
		];

		if ( ! fullscreen ) {
			layoutOptions = [
				{ value: 'center-left', label: __( 'Center Left' ) },
				{ value: 'center-center', label: __( 'Center Center' ) },
				{ value: 'center-right', label: __( 'Center Right' ) },
			];
		}

		const layoutAttributes = {};
		//top
		layoutAttributes[ 'top-left' ] = {
			wrapper: {
				contentAlign: 'left',
			},
		};

		layoutAttributes[ 'top-center' ] = {
			wrapper: {
				contentAlign: 'center',
			},
		};

		layoutAttributes[ 'top-right' ] = {
			wrapper: {
				contentAlign: 'right',
			},
		};

		//center
		layoutAttributes[ 'center-left' ] = {
			wrapper: {
				contentAlign: 'left',
			},
		};

		layoutAttributes[ 'center-center' ] = {
			wrapper: {
				contentAlign: 'center',
			},
		};

		layoutAttributes[ 'center-right' ] = {
			wrapper: {
				contentAlign: 'right',
			},
		};

		//bottom
		layoutAttributes[ 'bottom-left' ] = {
			wrapper: {
				contentAlign: 'left',
			},
		};

		layoutAttributes[ 'bottom-center' ] = {
			wrapper: {
				contentAlign: 'center',
			},
		};

		layoutAttributes[ 'bottom-right' ] = {
			wrapper: {
				contentAlign: 'right',
			},
		};

		const getBlockContents = select( 'core/editor' ).getBlock( clientId );

		const classes = classnames(
			'components-base-control',
			'components-palamut-css-grid-selector', {
				'is-fullscreen': fullscreen,
			}
		);

		return (
			<Fragment>
				<div className={ classes }>
					<label className="components-base-control__label" >{ __( 'Layout' ) }</label>
					<ButtonGroup aria-label={ __( 'Select Layout' ) }>
						{ map( layoutOptions, ( { label, value, icon } ) => {
						 if ( tooltip ) {
						 	return (
							<Tooltip text={ label }>
										<div className={ ( value == layout ) ? 'is-selected' : null }>
									<Button
												isSmall
												onClick={ () => {
													setAttributes( { layout: value } );
													if ( layoutAttributes[ value ].wrapper ) {
														dispatch( 'core/editor' ).updateBlockAttributes( clientId, layoutAttributes[ value ].wrapper );
													}
												} }
											>
											</Button>
								</div>
									</Tooltip>
								);
						 }
						 	return (
							<div className={ ( value == layout ) ? 'is-selected' : null }>
									<Button
									isSmall
									onClick={ () => {
											setAttributes( { layout: value } );
											if ( layoutAttributes[ value ].wrapper ) {
												dispatch( 'core/editor' ).updateBlockAttributes( clientId, layoutAttributes[ value ].wrapper );
											}
										} }
									>
								</Button>
								</div>
						 	);
						} ) }
					</ButtonGroup>
				</div>
				<ToggleControl
					label={ __( 'Fullscreen' ) }
					checked={ !! fullscreen }
					onChange={ () => {
						if ( fullscreen ) {
							if ( [ 'bottom-left', 'top-left' ].includes( layout ) ) {
								setAttributes( { layout: 'center-left' } );
							}

							if ( [ 'bottom-center', 'top-center' ].includes( layout ) ) {
								setAttributes( { layout: 'center-center' } );
							}

							if ( [ 'bottom-right', 'top-right' ].includes( layout ) ) {
								setAttributes( { layout: 'center-right' } );
							}
						}
						setAttributes( { fullscreen: ! fullscreen } );
					} }
					help={ !! fullscreen ? __( 'Fullscreen mode is enabled.' ) : __( 'Toggle to enable fullscreen mode.' ) }
				/>
			</Fragment>
		);
	}
}

export default withInstanceId( CSSGridControl );

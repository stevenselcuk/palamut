/**
 * External dependencies
 */
import classnames from 'classnames';
import map from 'lodash/map';

/**
 * Internal dependencies
 */
import DimensionsAttributes from './attributes';
import icons from './icons';
import './styles/editor.scss';

/**
 * WordPress dependencies
 */
const { __, _x, sprintf } = wp.i18n;
const { withInstanceId } = wp.compose;
const { Component, Fragment } = wp.element;
const { ButtonGroup, Dropdown, NavigableMenu, BaseControl, Button, Tooltip, Dashicon, TabPanel } = wp.components;

class ResponsiveBaseControl extends Component {

	constructor( props ) {
		super( ...arguments );

		this.saveMeta = this.saveMeta.bind( this );

		let meta = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'meta' );
		// console.log( props.attributes );
	}

	saveMeta( event ){
		let meta = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'meta' );
		let block = wp.data.select( 'core/editor' ).getBlock( this.props.clientId );
		let dimensions = {};
		
		if ( typeof this.props.attributes.palamut !== 'undefined' && typeof this.props.attributes.palamut.id !== 'undefined' ) {
			let id = this.props.name.split('/').join('-') + '-' + this.props.attributes.palamut.id;
			let height = {
				height: block.attributes[ this.props.type ],
				heightTablet: block.attributes[ this.props.type + 'Tablet' ],
				heightMobile: block.attributes[ this.props.type + 'Mobile' ],
			};

			if ( typeof meta._palamut_responsive_height === 'undefined' || ( typeof meta._palamut_responsive_height !== 'undefined' && meta._palamut_responsive_height  == '' ) ){
				dimensions = {};
			} else {
				dimensions = JSON.parse( meta._palamut_responsive_height );
			}

			if ( typeof dimensions[ id ] === 'undefined' ) {
				dimensions[ id ] = {};
				dimensions[ id ][ this.props.type ] = {};
			} else {
				if ( typeof dimensions[ id ][ this.props.type ] === 'undefined' ){
					dimensions[ id ][ this.props.type ] = {};
				}
			}

			dimensions[ id ][ this.props.type ] = height;
			
			// Save values to metadata.
			wp.data.dispatch( 'core/editor' ).editPost({
				meta: {
					_palamut_responsive_height: JSON.stringify( dimensions ),
				}
			});

		}
	}

	render() {

		const {
			bottom = true,
			className,
			help,
			instanceId,
			label = __( 'Height' ),
			left = true,
			reset = false,
			right = true,
			setAttributes,
			top = true,
			type = 'margin',
			unit,
			units = true,
			valueBottom,
			valueLeft,
			valueRight,
			valueTop,
			valueBottomTablet,
			valueLeftTablet,
			valueRightTablet,
			valueTopTablet,
			valueBottomMobile,
			valueLeftMobile,
			valueRightMobile,
			valueTopMobile,
			syncUnits,
			syncUnitsTablet,
			syncUnitsMobile,
			dimensionSize,



			height,
			heightTablet,
			heightMobile,
			onChange,
			onChangeTablet,
			onChangeMobile,
			sync,
			min = 10,
			max = 1000,
			step = 1,


		} = this.props;

		const onSelect = ( tabName ) => {
			let selected = 'desktop';

			switch( tabName ){
				case 'desktop':
					selected = 'tablet';
				break;
				case 'tablet':
					selected = 'mobile';
				break;
				case 'mobile':
					selected = 'desktop';
				break;
				default:
				break;
			}

			//Reset z-index
			const buttons = document.getElementsByClassName( `components-palamut-dimensions-control__mobile-controls-item--${ this.props.type }`);

			for(var i = 0; i < buttons.length; i++) {
				buttons[i].style.display = 'none';
			}
			if( tabName == 'default' ){
				const button = document.getElementsByClassName( `components-palamut-dimensions-control__mobile-controls-item-${ this.props.type }--tablet`);
				button[0].click();
			}else{
				const button = document.getElementsByClassName( `components-palamut-dimensions-control__mobile-controls-item-${ this.props.type }--${ selected }`);
				button[0].style.display = 'block';
			}
		};

		const classes = classnames(
			'components-base-control',
			'components-palamut-dimensions-control',
			'components-palamut-responsive-base-control', {
			}
		);

		const id = `inspector-palamut-dimensions-control-${ instanceId }`;

		return (
			<Fragment>
				<div className={ classes }>
					<Fragment>
						<span className="components-base-control__label">{ label }</span>
						<TabPanel
							className="components-palamut-dimensions-control__mobile-controls"
							activeClass="is-active"
							initialTabName="default"
							onSelect={ onSelect }
							tabs={ [
								{
									name: 'default',
									title: icons.desktopChrome,
									className: `components-palamut-dimensions-control__mobile-controls-item components-palamut-dimensions-control__mobile-controls-item--${ this.props.type } components-button components-palamut-dimensions-control__mobile-controls-item--default components-palamut-dimensions-control__mobile-controls-item-${ this.props.type }--default`,
								},
								{
									name: 'desktop',
									title: icons.mobile,
									className: `components-palamut-dimensions-control__mobile-controls-item components-palamut-dimensions-control__mobile-controls-item--${ this.props.type } components-button components-palamut-dimensions-control__mobile-controls-item--desktop components-palamut-dimensions-control__mobile-controls-item-${ this.props.type }--desktop`,
								},
								{
									name: 'tablet',
									title: icons.desktopChrome,
									className: `components-palamut-dimensions-control__mobile-controls-item components-palamut-dimensions-control__mobile-controls-item--${ this.props.type } components-button components-palamut-dimensions-control__mobile-controls-item--tablet components-palamut-dimensions-control__mobile-controls-item-${ this.props.type }--tablet`,
								},
								{
									name: 'mobile',
									title: icons.tablet,
									className: `components-palamut-dimensions-control__mobile-controls-item components-palamut-dimensions-control__mobile-controls-item--${ this.props.type } components-button components-palamut-dimensions-control__mobile-controls-item--mobile components-palamut-dimensions-control__mobile-controls-item-${ this.props.type }--mobile`,
								},
							] }>
							{
								( tab ) => {
									if ( 'mobile' === tab.name ) {
										return (
											<Fragment>
												<div className='components-palamut-dimensions-control__inputs component-palamut-is-mobile'>
													<BaseControl>
														<input
															type="number"
															onChange={ ( newValue ) => {
																onChangeMobile( newValue );
																this.saveMeta();
															} }
															value={ heightMobile ? heightMobile : '' }
															min={ min }
															step={ step }
															max={ max }
														/>
													</BaseControl>
												</div>
											</Fragment>
										)
									} else if ( 'tablet' === tab.name ) {
										return (
											<Fragment>
												<div className='components-palamut-dimensions-control__inputs component-palamut-is-tablet'>
													<BaseControl>
														<input
															type="number"
															onChange={ ( newValue ) =>{
																onChangeTablet( newValue );
																this.saveMeta();
															} }
															value={ heightTablet ? heightTablet : '' }
															min={ min }
															step={ step }
															max={ max }
														/>
													</BaseControl>
												</div>
											</Fragment>
										)
									} else {
										return (
											<Fragment>
												<div className='components-palamut-dimensions-control__inputs component-palamut-is-desktop'>
													<BaseControl>
														<input
															type="number"
															onChange={ ( newValue ) => {
																onChange( newValue );
																this.saveMeta();
															} }
															value={ height ? height : '' }
															min={ min }
															step={ step }
															max={ max }
														/>
													</BaseControl>
												</div>
											</Fragment>
										)
									}
								}
							}
						</TabPanel>
					</Fragment>
				</div>
			</Fragment>
		);
	}
}

export default withInstanceId( ResponsiveBaseControl );
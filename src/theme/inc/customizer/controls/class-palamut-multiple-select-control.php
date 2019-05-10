<?php
/**
 * Document_title
 *
 * Document_desc
 *
 * @link N/A
 *
 * @package pkg.name
 *
 * @subpackage Theme Functions
 * @category Functions
 *
 * @version pkg.version
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */


/**
 * Multiple select customize control class.
 *
 * @since  1.0
 * @access public
 */
class Palamut_Multiple_Select_Control extends WP_Customize_Control {
	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0
	 * @access public
	 * @var    string
	 */
	public $type = 'prefix-multiple-select';

	/**
	 * Custom classes to apply on select.
	 *
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $custom_class = '';

	/**
	 * prefix_Select_Multiple constructor.
	 *
	 * @param WP_Customize_Manager $manager Customize manager object.
	 * @param string               $id Control id.
	 * @param array                $args Control arguments.
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if ( array_key_exists( 'custom_class', $args ) ) {
			$this->custom_class = esc_attr( $args['custom_class'] );
		}
	}

	/**
	 * Loads the framework scripts/styles.
	 *
	 * @since  1.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( 'prefix-selectize-style', get_theme_file_uri( '/inc/customizer/controls/assets/css/selectize.css' ), null, '1.0' );
	//	wp_enqueue_style( 'prefix-selectize-theme', get_theme_file_uri( '/inc/customizer/controls/assets/css/selectize.default.css' ), null, '1.0' );
		wp_enqueue_script( 'selectize', get_theme_file_uri( '/inc/customizer/controls/assets/js/selectize.min.js' ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'prefix-multiple-select', get_theme_file_uri( '/inc/customizer/controls/assets/js/multiple-select.js' ), array( 'jquery', 'selectize' ), '1.0', true );
	}
	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0
	 * @access public
	 * @return array
	 */
	public function json() {
		$json                 = parent::json();
		$json['choices']      = $this->choices;
		$json['link']         = $this->get_link();
		$json['value']        = (array) $this->value();
		$json['id']           = $this->id;
		$json['custom_class'] = $this->custom_class;

		return $json;
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>
		<#
		if ( ! data.choices ) {
			return;
		} #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<#
			var custom_class = ''
			if ( data.custom_class ) {
				custom_class = 'class='+data.custom_class
			} #>
			<select multiple {{{ data.link }}} {{ custom_class }}>
				<# _.each( data.choices, function( label, choice ) {
					var selected = data.value.includes( choice.toString() ) ? 'selected="selected"' : ''
					#>
					<option value="{{ choice }}" {{ selected }} >{{ label }}</option>
				<# } ) #>
			</select>
		</label>
		<?php
	}
}

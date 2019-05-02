<?php
/**
 * Range Customizer Control.
 *
 * @see https://developer.wordpress.org/reference/classes/wp_customize_control/
 *
 * @package     Palamut Admin
 * @link        https://palamut.com/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if WP_Customize_Control does not exsist.
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * This class is for the range control in the Customizer.
 *
 * @access public
 */
class Palamut_Range_Control extends WP_Customize_Control {

	/**
	 * The type of customize control.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'palamut-range';

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue() {
		wp_enqueue_style( 'palamut-range-control', get_theme_file_uri( '/inc/customizer/controls/assets/css/range.css' ), false, __PRE_THEME_VERSION, 'all' );
		wp_enqueue_script( 'palamut-range-control', get_theme_file_uri( '/inc/customizer/controls/assets/js/range.js' ), array( 'jquery' ), __PRE_THEME_VERSION, true );
	}

	/**
	 * Refresh the parameters passed to the JpalamutScript via JSON.
	 *
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		// The setting value.
		$this->json['id']                  = $this->id;
		$this->json['value']               = $this->value();
		$this->json['link']                = $this->get_link();
		$this->json['defaultValue']        = $this->setting->default;
		$this->json['input_attrs']['min']  = ( isset( $this->input_attrs['min'] ) ) ? $this->input_attrs['min'] : '0';
		$this->json['input_attrs']['max']  = ( isset( $this->input_attrs['max'] ) ) ? $this->input_attrs['max'] : '100';
		$this->json['input_attrs']['step'] = ( isset( $this->input_attrs['step'] ) ) ? $this->input_attrs['step'] : '1';
	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 */
	public function render_content() {}

	/**
	 * Render a JS template for the content of the control.
	 */
	protected function content_template() {
		?>

		<div class="palamut-range">

			<# if ( data.label ) { #>
				<label class="palamut-range__label">
					<span class="customize-control-title">{{ data.label }}</span>
				</label>
			<# } #>

			<div class="palamut-range__value">
				<span>{{ data.value }}</span>
				<input id="range-{{ data.id }}" type="number" class="palamut-range__number-input" value="{{ data.value }}" data-default-value="{{ data.defaultValue }}" {{{ data.link }}} <# if ( data.value ) { #> checked="checked" <# } #> />
				<# if ( data.description ) { #>
					<em>{{ data.description }}</em>
				<# } #>
			</div>

			<input type="range" data-input-type="range" class="palamut-range__track" value="{{ data.value }}" data-default-value="{{ data.defaultValue }}"  min="{{ data.input_attrs['min'] }}" max="{{ data.input_attrs['max'] }}" step="{{ data.input_attrs['step'] }}" {{{ data.link }}} />

			<a type="button" value="reset" class="palamut-range__reset"></a>

		</div>
		<?php
	}
}

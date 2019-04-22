<?php
/**
 * Toggle Customizer Control.
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
 * This class is for the toggle control in the Customizer.
 *
 * @access public
 */
class Palamut_Toggle_Control extends WP_Customize_Control {

	/**
	 * The type of customize control.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'palamut-toggle';
	/**
	 * The style of customize control.
	 *
	 * @access public
	 * @var    string
	 */
	public $style = 'ios';

	/**
	 * Custom pro button URL.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $toggled_description = '';

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue() {
		wp_enqueue_style( 'palamut-toggle-control', PALA_THEME_DIR_URL . '/inc/customizer/controls/assets/css/toggle.css', false, '1.0', 'all' );
		wp_enqueue_script( 'palamut-toggle-control', PALA_THEME_DIR_URL . '/inc/customizer/controls/assets/js/toggle.js', array( 'jquery' ), '1.0', true );
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
		$this->json['style']               = $this->style;
		$this->json['value']               = $this->value();
		$this->json['link']                = $this->get_link();
		$this->json['defaultValue']        = $this->setting->default;
		$this->json['toggled_description'] = ( isset( $this->toggled_description ) ) ? $this->toggled_description : null;
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

		<div class="components-base-control components-toggle-control">

			<div class="components-base-control__field">

				<# if ( data.label ) { #>
					<label for="inspector-toggle-control-{{ data.id }}" class="customize-control-title components-toggle-control__label">{{ data.label }}</label>
				<# } #>

				<span class="components-form-toggle <# if ( data.value ) { #>is-checked<# } #>">
					<input class="tgl tgl-{{ data.style }}" id="inspector-toggle-control-{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}} <# if ( data.value ) { #> checked="checked" <# } #> />
					<label class="tgl-btn" for="inspector-toggle-control-{{ data.id }}"></label>
				</span>
			</div>

			<# if ( data.description ) { #>
				<span id="inspector-toggle-control-{{ data.id }}__help" class="description customize-control-description components-base-control__help <# if ( data.toggled_description ) { #> components-base-control__help--has-toggled-description <# } #>">
					<span class="toggle--off <# if ( data.value && data.toggled_description ) { #> hidden <# } #>">{{ data.description }}</span>
					<# if ( data.toggled_description ) { #>
						<span class="toggle--on <# if ( ! data.value && data.toggled_description ) { #> hidden <# } #>">{{ data.toggled_description }}</span>
					<# } #>
				</span>
			<# } #>
		</div>

		<?php
	}
}

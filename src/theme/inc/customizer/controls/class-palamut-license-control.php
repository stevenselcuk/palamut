<?php
/**
 * License Customizer Control.
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
 * This class is for the license control in the Customizer.
 *
 * @access public
 */
class Palamut_License_Control extends WP_Customize_Control {

	/**
	 * The type of customize control.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'palamut-license';

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue() {

		wp_enqueue_style( 'palamut-license-control', PALA_THEME_DIR_URL . 'inc/customizer/controls/assets/css/dist/license.css', false, '1.0', 'all' );
		wp_enqueue_script( 'palamut-license-control', PALA_THEME_DIR_URL . 'inc/customizer/controls/assets/js/dist/license.js', array( 'jquery' ), '1.0', true );

		// Localization.
		$localize = array(
			'nonce'   => array(
				'activate'   => wp_create_nonce( 'palamut-activate-license' ),
				'deactivate' => wp_create_nonce( 'palamut-deactivate-license' ),
			),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		);

		wp_localize_script( 'palamut-license-control', 'palamut_license_control', $localize );
	}

	/**
	 * Refresh the parameters passed to the JpalamutScript via JSON.
	 *
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		// Retrieve the license class.
		$customizer = new Palamut_License();

		// Check the validity of the license.
		$is_valid   = $customizer->is_valid_license();
		$visibility = ( true === $is_valid ) ? 'is-valid' : 'is-not-valid';

		// The setting value.
		$this->json['value']                       = $this->value();
		$this->json['link']                        = $this->get_link();
		$this->json['status']                      = $customizer->status();
		$this->json['visibility']                  = $visibility;
		$this->json['input_attrs']['tooltip']      = ( isset( $this->input_attrs['tooltip'] ) ) ? $this->input_attrs['tooltip'] : null;
		$this->json['input_attrs']['tooltip_link'] = ( isset( $this->input_attrs['tooltip_link'] ) ) ? $this->input_attrs['tooltip_link'] : null;
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

		<# if ( data.label ) { #>

			<span class="customize-control-title">

				{{ data.label }}

				<# if ( data.input_attrs['tooltip'] ) { #>
					<# if ( data.input_attrs['tooltip_link'] ) { #>
						<a class="palamut-tooltip " href="{{ data.input_attrs['tooltip_link'] }}" alt="{{ data.input_attrs['tooltip'] }}" target="_blank">
							<span class="screen-reader-text">{{ data.input_attrs['tooltip'] }}</span>
					<# } #>
						<span class="hint--top" aria-label="{{ data.input_attrs['tooltip'] }}">
							<span class="palamut-tooltip__icon dashicons dashicons-editor-help"></span>
						</span>
					<# if ( data.input_attrs['tooltip_link'] ) { #>
						</a>
					<# } #>
				<# } #>

			</span>

		<# } #>

		<# if ( data.description ) { #>
			<span class="customize-control-description">{{ data.description }}</span>
		<# } #>

		<div id="theme-license-form" class="license-form">
			<input id="theme-license-key" class="license" name="theme-license-key" spellcheck="false" type="text" value="{{ data.value }}" {{{ data.input_attrs }}} {{{ data.link }}} />
			<input type="submit" name="palamut-license" id="palamut-activate-license" value="<?php esc_attr_e( 'Activate', 'palamut' ); ?>" class="button-secondary button {{ data.visibility }}">
			<input type="submit" name="palamut-deactivate-license" id="palamut-deactivate-license" value="<?php esc_attr_e( 'Deactivate', 'palamut' ); ?>" class="button-secondary button {{ data.visibility }}">
			<div class="spinner"></div>
		</div>

		<div id="theme-license-error"></div>

		<ul id="theme-license-info" class="{{ data.visibility }}">
			<li><strong><?php esc_html_e( 'Status:', 'palamut' ); ?></strong> <span id="theme-license-status">{{ data.status }}</span></li>
		</ul>

		<?php
	}
}

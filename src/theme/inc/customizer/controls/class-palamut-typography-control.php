<?php
/**
 * Font selector.
 *
 * @package Intrinsic
 * @since 1.0
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}
/**
 * Class Intrinsic_Font_Selector
 */
class Palamut_Typography_Control extends WP_Customize_Control {

		/**
		 * Used to connect controls to each other.
		 *
		 * @since 1.0.0
		 * @var bool $connect
		 */
	public $connect = false;

		/**
		 * Used to connect variant controls to each other.
		 *
		 * @since 1.5.2
		 * @var bool $variant
		 */
	public $variant = false;

		/**
		 * Used to set the mode for code controls.
		 *
		 * @since 1.0.0
		 * @var bool $mode
		 */
	public $mode = 'html';

		/**
		 * Used to set the default font options.
		 *
		 * @since 1.0.8
		 * @var string $prefix_inherit
		 */
	public $prefix_inherit = '';

	/**
	 * Google Fonts
	 *
	 * @since 1.0.19
	 * @var array
	 */
	public static $google_fonts = array();

		/**
		 * All font weights
		 *
		 * @since 1.0.8
		 * @var string $prefix_inherit
		 */
	public $prefix_all_font_weight = array();

		/**
		 * If true, the preview button for a control will be rendered.
		 *
		 * @since 1.0.0
		 * @var bool $preview_button
		 */
	public $preview_button = false;

		/**
		 * Set the default font options.
		 *
		 * @since 1.0.8
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param string               $id      Control ID.
		 * @param array                $args    Default parent's arguments.
		 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->prefix_inherit         = __( 'Inherit', 'textdomain' );
		$this->prefix_all_font_weight = array(
			'100'       => __( 'Thin 100', 'textdomain' ),
			'100italic' => __( '100 Italic', 'textdomain' ),
			'200'       => __( 'Extra-Light 200', 'textdomain' ),
			'200italic' => __( '200 Italic', 'textdomain' ),
			'300'       => __( 'Light 300', 'textdomain' ),
			'300italic' => __( '300 Italic', 'textdomain' ),
			'400'       => __( 'Normal 400', 'textdomain' ),
			'italic'    => __( '400 Italic', 'textdomain' ),
			'500'       => __( 'Medium 500', 'textdomain' ),
			'500italic' => __( '500 Italic', 'textdomain' ),
			'600'       => __( 'Semi-Bold 600', 'textdomain' ),
			'600italic' => __( '600 Italic', 'textdomain' ),
			'700'       => __( 'Bold 700', 'textdomain' ),
			'700italic' => __( '700 Italic', 'textdomain' ),
			'800'       => __( 'Extra-Bold 800', 'textdomain' ),
			'800italic' => __( '800 Italic', 'textdomain' ),
			'900'       => __( 'Ultra-Bold 900', 'textdomain' ),
			'900italic' => __( '900 Italic', 'textdomain' ),
		);
		parent::__construct( $manager, $id, $args );
	}

		/**
		 * Renders the content for a control based on the type
		 * of control specified when this class is initialized.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
	protected function render_content() {

		switch ( $this->type ) {

			case 'prefix-font-family':
				$this->render_font( $this->prefix_inherit );
				break;

			case 'prefix-font-variant':
				$this->render_font_variant( $this->prefix_inherit );
				break;

			case 'prefix-font-weight':
				$this->render_font_weight( $this->prefix_inherit );
				break;
		}
	}

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
	public function enqueue() {

		wp_enqueue_style( 'prefix-selectize-style', get_theme_file_uri( '/inc/customizer/controls/assets/css/selectize.css' ), null, '1.0' );
		wp_enqueue_script( 'selectize', get_theme_file_uri( '/inc/customizer/controls/assets/js/selectize.min.js' ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'prefix-typography', get_theme_file_uri( '/inc/customizer/controls/assets/js/typography.js' ), array( 'jquery', 'selectize' ), '1.0', true );
	}
		/**
		 * Renders the title and description for a control.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
	protected function render_content_title() {
		if ( ! empty( $this->label ) ) {
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		}
		if ( ! empty( $this->description ) ) {
			echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
		}
	}

		/**
		 * Renders the connect attribute for a connected control.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
	protected function render_connect_attribute() {
		if ( $this->connect ) {
			echo ' data-connected-control="' . esc_attr( $this->connect ) . '"';
			echo ' data-inherit="' . esc_attr( $this->prefix_inherit ) . '"';
		}
		if ( $this->variant ) {
			echo ' data-connected-variant="' . esc_attr( $this->variant ) . '"';
			echo ' data-inherit="' . esc_attr( $this->prefix_inherit ) . '"';
		}
	}

		/**
		 * Renders a font control.
		 *
		 * @since 1.0.16 Added the action 'prefix_customizer_font_list' to support custom fonts.
		 * @since 1.0.0
		 * @param  string $default Inherit/Default.
		 * @access protected
		 * @return void
		 */
	protected function render_font( $default ) {
		echo '<label>';
		$this->render_content_title();
		echo '</label>';
		echo '<select class="prefix-typography-select"  placeholder="Select or Search a Google Font..."';
		$this->link();
		$this->render_connect_attribute();
		echo '>';
		echo '<option value="default"  selected>' . esc_attr( $default ) . '</option>';
		$google_fonts_json = array();
		if ( empty( $google_fonts ) ) {

			$google_fonts_file = __PRE_THEME_DIR . '/assets/fonts/google-fonts.json';

			if ( ! file_exists( __PRE_THEME_DIR . '/assets/fonts/google-fonts.json' ) ) {
				return array();
			}

			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}

			$file_contants     = $wp_filesystem->get_contents( $google_fonts_file );
			$google_fonts_json = json_decode( $file_contants, 1 );
		}

		foreach ( $google_fonts_json['items'] as $name => $single_font ) {
			echo '<option value="' . esc_attr( $single_font['family'] ) . '" ' . selected( $name, $this->value(), false ) . '>' . esc_attr( $single_font['family'] ) . '</option>';
		}

		echo '</select>';
	}

		/**
		 * Renders a font weight control.
		 *
		 * @since 1.0.0
		 * @param  string $default Inherit/Default.
		 * @access protected
		 * @return void
		 */
	protected function render_font_weight( $default ) {
		echo '<label>';
		$this->render_content_title();
		echo '</label>';
		echo '<select ';
		$this->link();
		$this->render_connect_attribute();
		echo '>';
		if ( 'normal' == $this->value() ) {
			echo '<option value="normal" ' . selected( 'normal', $this->value(), false ) . '>' . esc_attr( $default ) . '</option>';
		} else {
			echo '<option value="inherit" ' . selected( 'inherit', $this->value(), false ) . '>' . esc_attr( $default ) . '</option>';
		}
		$selected       = '';
		$selected_value = $this->value();
		$all_fonts      = $this->prefix_all_font_weight;

		foreach ( $all_fonts as $key => $value ) {
			if ( $key == $selected_value ) {
				$selected = ' selected = "selected" ';
			} else {
				$selected = '';
			}
			// Exclude all italic values.
			if ( strpos( $key, 'italic' ) === false ) {
				echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $value ) . '</option>';
			}
		}
		echo '</select>';
	}

		/**
		 * Renders a font variant control.
		 *
		 * @since 1.5.2
		 * @param  string $default Inherit/Default.
		 * @access protected
		 * @return void
		 */
	protected function render_font_variant( $default ) {
		echo '<label>';
		$this->render_content_title();
		echo '</label>';
		echo '<select ';
		$this->link();
		$this->render_connect_attribute();
		echo ' multiple >';
		$values = explode( ',', $this->value() );
		foreach ( $values as $key => $value ) {
			echo '<option value="' . esc_attr( $value ) . '" selected="selected" >' . esc_html( $value ) . '</option>';
		}
		echo '<input class="prefix-font-variant-hidden-value" type="hidden" value="' . esc_attr( $this->value() ) . '">';
		echo '</select>';
	}
}

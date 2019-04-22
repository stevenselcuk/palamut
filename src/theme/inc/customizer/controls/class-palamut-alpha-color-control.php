<?php
/**
 * { Document title }
 *
 * { Document descriptions will be add. }
 *
 * @link to be defined
 *
 * @package pdwname
 *
 * @subpackage Template Functions
 * @category Theme Framework
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * [Palamut_Customize_Alpha_Color_Control description]
 */
class Palamut_Alpha_Color_Control extends WP_Customize_Control {
	/**
	 * Official control name.
	 *
	 * @var string
	 */
	public $type = 'alpha-color';
	/**
	 * Add support for palettes to be passed in.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 *
	 * @var bool
	 */
	public $palette;
	/**
	 * Add support for showing the opacity value on the slider handle.
	 *
	 * @var array
	 */
	public $show_opacity;
	/**
	 * Enqueue scripts and styles.
	 *
	 * Ideally these would get registered and given proper paths before this control object
	 * gets initialized, then we could simply enqueue them here, but for completeness as a
	 * stand alone class we'll register and enqueue them here.
	 */
	public function enqueue() {
		wp_enqueue_script( 'palamut-alpha-color-picker', get_theme_file_uri( '/inc/customizer/controls/assets/js/alpha-color-picker.js' ), array( 'jquery', 'wp-color-picker' ), '1.0', true );
		wp_enqueue_style(
			'palamut-alpha-color-picker',
			get_theme_file_uri( '/inc/customizer/controls/assets/css/alpha-color-picker.css' ),
			array( 'wp-color-picker' ),
			'1.0'
		);
	}
	/**
	 * Render the control.
	 */
	public function render_content() {
		// Process the palette.
		if ( is_array( $this->palette ) ) {
			$palette = implode( '|', $this->palette );
		} else {
			// Default to true.
			$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
		}
		// Support passing show_opacity as string or boolean. Default to true.
		$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';
		// Output the label and description if they were passed in.
		if ( isset( $this->label ) && '' !== $this->label ) {
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		}
		if ( isset( $this->description ) && '' !== $this->description ) {
			echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
		}
		?>
		<label>
			<input class="alpha-color-control" type="text" data-show-opacity="<?php echo esc_attr( $show_opacity ); ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php esc_attr( $this->link() ); ?>  />
		</label>
		<?php
	}
}

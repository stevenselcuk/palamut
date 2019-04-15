<?php
/**
 * Customizer Control Group: Info
 *
 * Adds extra information fields
 *
 * @uses Kirki
 *
 * @link http://aristath.github.io/kirki/
 *
 * @package Palamut
 *
 * @subpackage Customizer
 * @category Extension for Customizer
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action(
	'customize_register',
	function( $wp_customize ) {
		/**
		 * [Palamut_Kirki_Info_Control_Group description]
		 */
		class Palamut_Info_Control extends Kirki_Control_Base {
			/**
			 * Control type
			 *
			 * @var $type
			 */
			public $type = 'palamut-info-control';
			/**
			 * Control Vars
			 *
			 * @var $info_type
			 */
			public $icon;

			/**
			 * [public description]
			 *
			 * @var [type]
			 */
			public $info_class;
			/**
			 * [public description]
			 *
			 * @var [type]
			 */
			public $info_content;

			/**
			 * [enqueue description]
			 *
			 * @method enqueue
			 *
			 * @since
			 *
			 * @link
			 */
			public function enqueue() {
				parent::enqueue();
				wp_enqueue_style( 'palamut-info-control', PALAMUT_PATH_URL . 'includes/extensions/kirki-extensions/info/assets/info.css', array( 'kirki-styles' ), PALAMUT_VERSION );
			}
			/**
			 * [render_content description]
			 *
			 * @method render_content
			 *
			 * @since
			 *
			 * @link
			 */
			public function render_content() {
				$icon    = isset( $this->icon ) ? sprintf( '<span class="dashicons dashicons-%s"></span>', esc_attr( $this->icon ) ) : '';
				$content = isset( $this->info_content ) ? sprintf( '<div class="control-info-bottom">%s</div>', $this->info_content ) : '';
				?>
		<div class="control-info <?php echo esc_attr( $this->info_class ); ?>">
				<?php
				if ( isset( $this->label ) && '' !== $this->label ) {
					printf(
						'<span class="customize-control-title control-info-label">%1$s%2$s</span>',
						wp_kses( sanitize_text_field( $this->label ), allowed_html() ),
						wp_kses( $icon, allowed_html() )
					);
				}

				if ( isset( $this->description ) && '' !== $this->description ) {
					printf(
						'<div class="description customize-control-description control-info-description">%s</div>',
						wp_kses_post( $this->description )
					);
				}

				echo wp_kses_post( $content );
				?>
		</div>
				<?php
			}
		}

		add_filter(
			'kirki_control_types',
			function( $controls ) {
				$controls['palamut-info-control'] = 'Palamut_Info_Control';
				return $controls;
			}
		);

	}
);

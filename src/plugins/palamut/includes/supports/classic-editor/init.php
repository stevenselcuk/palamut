<?php
/**
 * Classic Editor Support for our theme
 *
 * Some WP people does not love Gutenberg you know.
 *
 * @link       https://hevalandsteven.com
 * @since      1.0.0
 *
 * @package    Palamut
 * @subpackage Supports
 */

/**
 * Load Shorcodes
 */
require_once PALAMUT_PATH . 'includes/supports/classic-editor/shortcodes/init.php';

/**
 * Register shortcode & formatting buttons to text editor.
 *
 * @method palamut_shortcodes_button
 *
 * @since 1.0.0
 */
function palamut_shortcodes_button() {
	global $typenow;
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	if ( ! in_array( $typenow, array( 'post', 'page', 'portfolio' ), true ) ) {
		return;
	}

	if ( is_admin() && current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) && get_user_option( 'rich_editing' ) === 'true' ) {
		add_filter( 'mce_external_plugins', 'palamut_tinymce_plugin' );
		add_filter( 'mce_buttons', 'palamut_register_shortcode_button', 1, 2 );
	}
}

/**
 * Place buttons to text editor bar.
 *
 * @method palamut_register_shortcode_button
 *
 * @since 1.0.0
 *
 * @param  array $buttons Our usefull buttons.
 *
 * @return array $buttons Custom buttons
 */
function palamut_register_shortcode_button( $buttons ) {
	array_push( $buttons, ' | ', 'palamut_shortcode_button', 'styleselect' );

	return $buttons;
}

/**
 * [palamut_tinymce_plugin description]
 *
 * @method palamut_tinymce_plugin
 *
 * @since
 *
 * @link
 *
 * @param  [type] $plugin_array [description].
 *
 * @return [type]                               [description]
 */
function palamut_tinymce_plugin( $plugin_array ) {
	$plugin_array['palamut_shortcode_button'] = PALAMUT_PATH_URL . 'includes/supports/classic-editor/assets/js/shortcode-button.js';
	return $plugin_array;
}

add_action( 'admin_head', 'palamut_shortcodes_button' );

/**
 * Register format & styling menu to text ediyor
 *
 * @method palamut_wysiwyg_styles
 *
 * @since
 *
 * @link
 *
 * @param  array $settings (...).
 *
 * @return array Our multiple customizations
 */
function palamut_wysiwyg_styles( $settings ) {

	$settings['block_formats'] = 'Paragraph=p;Heading1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Div=div;Preformated=pre';

	$theme_styles = array(
		array(
			'title' => esc_html__( 'Dropcaps', 'palamut' ),
			'items' => array(
				array(
					'title'    => esc_html__( 'Dropcap', 'palamut' ),
					'selector' => 'p,div,span',
					'classes'  => 'palamut-dropcap',
				),

				array(
					'title'    => esc_html__( 'Dropcap box', 'palamut' ),
					'selector' => 'p,div,span',
					'classes'  => 'palamut-dropcap box',
				),

				array(
					'title'    => esc_html__( 'Dropcap box outline', 'palamut' ),
					'selector' => 'p,div,span',
					'classes'  => 'palamut-dropcap box outline',
				),

				array(
					'title'    => esc_html__( 'Dropcap rounded', 'palamut' ),
					'selector' => 'p,div,span',
					'classes'  => 'palamut-dropcap rounded',
				),

				array(
					'title'    => esc_html__( 'Dropcap rounded outline', 'palamut' ),
					'selector' => 'p,div,span',
					'classes'  => 'palamut-dropcap rounded outline',
				),

				array(
					'title'    => esc_html__( 'Dropcap circle', 'palamut' ),
					'selector' => 'p,div,span',
					'classes'  => 'palamut-dropcap circle',
				),

				array(
					'title'    => esc_html__( 'Dropcap circle outline', 'palamut' ),
					'selector' => 'p,div,span',
					'classes'  => 'palamut-dropcap circle outline',
				),

			),
		),
		array(
			'title' => esc_html__( 'Theme Styles', 'palamut' ),
			'items' => array(
				array(
					'title'   => esc_html__( 'Highlight', 'palamut' ),
					'inline'  => 'span',
					'classes' => 'palamut-highlight',
				),
				array(
					'title'   => esc_html__( 'Bold primary color', 'palamut' ),
					'inline'  => 'strong',
					'classes' => 'palamut-bold-primary',
				),
				array(
					'title'   => esc_html__( 'Primary color', 'palamut' ),
					'inline'  => 'span',
					'classes' => 'palamut-primary-color',
				),
				array(
					'title'   => esc_html__( 'Muted color', 'palamut' ),
					'inline'  => 'span',
					'classes' => 'palamut-muted-color',
				),
				array(
					'title'   => esc_html__( 'Dark color', 'palamut' ),
					'inline'  => 'span',
					'classes' => 'palamut-dark-color',
				),
				array(
					'title'   => esc_html__( 'Underline', 'palamut' ),
					'inline'  => 'span',
					'classes' => 'palamut-underline',
				),
				array(
					'title'   => esc_html__( 'Underline primary', 'palamut' ),
					'inline'  => 'span',
					'classes' => 'palamut-underline-primary',
				),

			),
		),
		array(
			'title' => esc_html__( 'Font Colors', 'palamut' ),
			'items' => array(
				array(
					'title'    => esc_html__( 'Highlight', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-highlight',
				),
				array(
					'title'    => esc_html__( 'Bold primary color', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-bold-primary',
				),
				array(
					'title'    => esc_html__( 'Primary color', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-primary-color',
				),
				array(
					'title'    => esc_html__( 'Muted color', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-muted-color',
				),
				array(
					'title'    => esc_html__( 'Dark color', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-dark-color',
				),
				array(
					'title'    => esc_html__( 'Underline', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-underline',
				),
				array(
					'title'    => esc_html__( 'Underline primary', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-underline-primary',
				),

			),
		),
		array(
			'title' => esc_html__( 'Font sizes', 'palamut' ),
			'items' => array(
				array(
					'title'   => esc_html__( 'Small', 'palamut' ),
					'inline'  => 'small',
					'classes' => 'palamut-small-text',
				),
				array(
					'title'    => esc_html__( 'Medium', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-medium-text',
				),
				array(
					'title'    => esc_html__( 'Large', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-large-text',
				),
				array(
					'title'    => esc_html__( 'Huge', 'palamut' ),
					'selector' => 'p,div,span,h1,h2,h2,h4,h5,h6',
					'classes'  => 'palamut-huge-text',
				),
			),
		),

		array(
			'title' => esc_html__( 'Content widths', 'palamut' ),
			'items' => array(
				array(
					'title'   => esc_html__( '85 percent container', 'palamut' ),

					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-content-85',
				),
				array(
					'title'   => esc_html__( '75 percent container', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-content-75',
				),
				array(
					'title'   => esc_html__( '50 percent container', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-content-50',
				),

				array(
					'title'   => esc_html__( '40 percent container', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-content-40',
				),

				array(
					'title'   => esc_html__( 'Stretch full width', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-stretch-content',
				),

				array(
					'title'   => esc_html__( 'Stretch site width', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-site-width palamut-stretch-content',
				),

				array(
					'title'   => esc_html__( '2 text columns', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-text-column-1-2',
				),

				array(
					'title'   => esc_html__( '3 text columns', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-text-column-1-3',
				),

				array(
					'title'   => esc_html__( '4 text columns', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-text-column-1-4',
				),
				array(
					'title'   => esc_html__( '5 text columns', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-text-column-1-5',
				),

				array(
					'title'   => esc_html__( '6 text columns', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-text-column-1-6',
				),
			),
		),

		array(
			'title' => esc_html__( 'Containers', 'palamut' ),
			'items' => array(
				array(
					'title'   => esc_html__( 'Div', 'palamut' ),
					'block'   => 'div',
					'wrapper' => true,
					'classes' => 'palamut-editor-div row',
				),
				array(
					'title'   => esc_html__( 'Section', 'palamut' ),
					'block'   => 'section',
					'wrapper' => true,
					'classes' => 'palamut-editor-section row',
				),
			),
		),

		array(
			'title' => esc_html__( 'Blockquotes', 'palamut' ),
			'items' => array(
				array(
					'title'   => esc_html__( 'Blockquote', 'palamut' ),
					'block'   => 'blockquote',
					'wrapper' => true,
				),
				array(
					'title'   => esc_html__( 'Pullquote', 'palamut' ),
					'block'   => 'blockquote',
					'classes' => 'pullquote',
					'wrapper' => true,
				),
				array(
					'title'    => esc_html__( 'Blockquote right', 'palamut' ),
					'selector' => 'blockquote',
					'classes'  => 'quote-right',
				),
				array(
					'title'    => esc_html__( 'Blockquote centered', 'palamut' ),
					'selector' => 'blockquote',
					'classes'  => 'quote-centered',
				),
				array(
					'title'   => esc_html__( 'Blockquote quoted', 'palamut' ),
					'block'   => 'blockquote',
					'classes' => 'quoted',
					'wrapper' => true,
				),
				array(
					'title'   => esc_html__( 'Blockquote brackets', 'palamut' ),
					'block'   => 'blockquote',
					'classes' => 'brackets',
					'wrapper' => true,
				),
			),
		),
	);

	// Add new styles.
	$settings['style_formats'] = wp_json_encode( $theme_styles );

	// Add new styles dynamic CSS.
	$add_css = '';

	$add_css .= 'body.mce-content-body .palamut-bold-primary,';
	$add_css .= 'body.mce-content-body .palamut-primary-color,';
	$add_css .= 'body.mce-content-body .palamut-bold-primary a,';
	$add_css .= 'body.mce-content-body .palamut-primary-color a{';
//	$add_css .= 'color:#000';
	$add_css .= '}';

	$settings['content_style'] = $add_css;

	// Return Settings.
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'palamut_wysiwyg_styles' );


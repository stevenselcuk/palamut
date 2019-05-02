<?php
/**
 * Oldskool (pre-Gutenberg area) Custom Metaboxes for posts
 *
 * It may be theme spesific
 *
 * @package Palamut
 *
 * @subpackage Metaboxes
 * @category Theme Features
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

/**
 * Add custom metaboxes to posts
 *
 * @method palamut_register_post_metabox
 *
 * @since 1.0.1
 *
 * @link https://github.com/CMB2/CMB2/wiki/Examples
 */
function palamut_register_post_metabox() {
	$prefix  = 'pdw_post_';
	$context = ( function_exists( 'register_block_type' ) ) ? 'side' : 'normal';
	// But wait... What if there is Classic Editor or old WP... Let's do it bigger.
	if ( class_exists( 'Classic_Editor' ) || version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
		$context = 'normal';
	}

	$cmb_post = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Test Metabox', 'palamut' ),
			'object_types' => array( 'post' ),
			'context'      => $context,
		// 'show_on_cb' => 'palamut_show_if_front_page', // function should return a bool value
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra palamut-wrap classes
		// 'classes_cb' => 'palamut_add_some_classes', // Add classes through a callback.
		/*
		* The following parameter is any additional arguments passed as $callback_args
		* to add_meta_box, if/when applicable.
		*
		* palamut does not use these arguments in the add_meta_box callback, however, these args
		* are parsed for certain special properties, like determining Gutenberg/block-editor
		* compatibility.
		*
		* Examples:
		*
		* - Make sure default editor is used as metabox is not compatible with block editor
		*      [ '__block_editor_compatible_meta_box' => false/true ]
		*
		* - Or declare this box exists for backwards compatibility
		*      [ '__back_compat_meta_box' => false ]
		*
		* More: https://wordpress.org/gutenberg/handbook/extensibility/meta-box/
		*/
		// 'mb_callback_args' => array( '__block_editor_compatible_meta_box' => false ),
		)
	);
	$cmb_post->add_field(
		array(
			'name'       => esc_html__( 'Test Text', 'palamut' ),
			'desc'       => esc_html__( 'field description (optional)', 'palamut' ),
			'id'         => $prefix . 'text',
			'type'       => 'text',
			'show_on_cb' => 'palamut_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
		// 'column'          => true, // Display field value in the admin post-listing columns
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Text Small', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'textsmall',
			'type' => 'text_small',
		// 'repeatable' => true,
		// 'column' => array(
		// 'name'     => esc_html__( 'Column Title', 'palamut' ), // Set the admin column title
		// 'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'palamut_display_text_small_column', // Output the display of the column values through a callback.
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Text Medium', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'textmedium',
			'type' => 'text_medium',
		)
	);
	$cmb_post->add_field(
		array(
			'name'       => esc_html__( 'Read-only Disabled Field', 'palamut' ),
			'desc'       => esc_html__( 'field description (optional)', 'palamut' ),
			'id'         => $prefix . 'readonly',
			'type'       => 'text_medium',
			'default'    => esc_attr__( 'Hey there, I\'m a read-only field', 'palamut' ),
			'save_field' => false, // Disables the saving of this field.
			'attributes' => array(
				'disabled' => 'disabled',
				'readonly' => 'readonly',
			),
		)
	);
	$cmb_post->add_field(
		array(
			'name'          => esc_html__( 'Custom Rendered Field', 'palamut' ),
			'desc'          => esc_html__( 'field description (optional)', 'palamut' ),
			'id'            => $prefix . 'render_row_cb',
			'type'          => 'text',
			'render_row_cb' => 'palamut_render_row_cb',
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Website URL', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'url',
			'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Text Email', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'email',
			'type' => 'text_email',
		// 'repeatable' => true,
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Time', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'time',
			'type' => 'text_time',
		// 'time_format' => 'H:i', // Set to 24hr format
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Time zone', 'palamut' ),
			'desc' => esc_html__( 'Time zone', 'palamut' ),
			'id'   => $prefix . 'timezone',
			'type' => 'select_timezone',
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Date Picker', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'textdate',
			'type' => 'text_date',
		// 'date_format' => 'Y-m-d',
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Date Picker (UNIX timestamp)', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'textdate_timestamp',
			'type' => 'text_date_timestamp',
		// 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Date/Time Picker Combo (UNIX timestamp)', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'datetime_timestamp',
			'type' => 'text_datetime_timestamp',
		)
	);
	// This text_datetime_timestamp_timezone field type
	// is only compatible with PHP versions 5.3 or above.
	// Feel free to uncomment and use if your server meets the requirement
	// $cmb_post->add_field( array(
	// 'name' => esc_html__( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'palamut' ),
	// 'desc' => esc_html__( 'field description (optional)', 'palamut' ),
	// 'id'   => $prefix . 'datetime_timestamp_timezone',
	// 'type' => 'text_datetime_timestamp_timezone',
	// ) );
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Money', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'textmoney',
			'type' => 'text_money',
		// 'before_field' => '£', // override '$' symbol if needed
		// 'repeatable' => true,
		)
	);
	$cmb_post->add_field(
		array(
			'name'    => esc_html__( 'Test Color Picker', 'palamut' ),
			'desc'    => esc_html__( 'field description (optional)', 'palamut' ),
			'id'      => $prefix . 'colorpicker',
			'type'    => 'colorpicker',
			'default' => '#ffffff',
		// 'options' => array(
		// 'alpha' => true, // Make this a rgba color picker.
		// ),
		// 'attributes' => array(
		// 'data-colorpicker' => json_encode( array(
		// 'palettes' => array( '#3dd0cc', '#ff834c', '#4fa2c0', '#0bc991', ),
		// ) ),
		// ),
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Text Area', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'textarea',
			'type' => 'textarea',
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Text Area Small', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'textareasmall',
			'type' => 'textarea_small',
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Text Area for Code', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'textarea_code',
			'type' => 'textarea_code',
		// 'attributes' => array(
		// Optionally override the code editor defaults.
		// 'data-codeeditor' => json_encode( array(
		// 'codemirror' => array(
		// 'lineNumbers' => false,
		// 'mode' => 'css',
		// ),
		// ) ),
		// ),
		// To keep the previous formatting, you can disable codemirror.
		// 'options' => array( 'disable_codemirror' => true ),
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Title Weeeee', 'palamut' ),
			'desc' => esc_html__( 'This is a title description', 'palamut' ),
			'id'   => $prefix . 'title',
			'type' => 'title',
		)
	);
	$cmb_post->add_field(
		array(
			'name'             => esc_html__( 'Test Select', 'palamut' ),
			'desc'             => esc_html__( 'field description (optional)', 'palamut' ),
			'id'               => $prefix . 'select',
			'type'             => 'select',
			'show_option_none' => true,
			'options'          => array(
				'standard' => esc_html__( 'Option One', 'palamut' ),
				'custom'   => esc_html__( 'Option Two', 'palamut' ),
				'none'     => esc_html__( 'Option Three', 'palamut' ),
			),
		)
	);
	$cmb_post->add_field(
		array(
			'name'             => esc_html__( 'Test Radio inline', 'palamut' ),
			'desc'             => esc_html__( 'field description (optional)', 'palamut' ),
			'id'               => $prefix . 'radio_inline',
			'type'             => 'radio_inline',
			'show_option_none' => 'No Selection',
			'options'          => array(
				'standard' => esc_html__( 'Option One', 'palamut' ),
				'custom'   => esc_html__( 'Option Two', 'palamut' ),
				'none'     => esc_html__( 'Option Three', 'palamut' ),
			),
		)
	);
	$cmb_post->add_field(
		array(
			'name'    => esc_html__( 'Test Radio', 'palamut' ),
			'desc'    => esc_html__( 'field description (optional)', 'palamut' ),
			'id'      => $prefix . 'radio',
			'type'    => 'radio',
			'options' => array(
				'option1' => esc_html__( 'Option One', 'palamut' ),
				'option2' => esc_html__( 'Option Two', 'palamut' ),
				'option3' => esc_html__( 'Option Three', 'palamut' ),
			),
		)
	);
	$cmb_post->add_field(
		array(
			'name'       => esc_html__( 'Test Taxonomy Radio', 'palamut' ),
			'desc'       => esc_html__( 'field description (optional)', 'palamut' ),
			'id'         => $prefix . 'text_taxonomy_radio',
			'type'       => 'taxonomy_radio', // Or `taxonomy_radio_inline`/`taxonomy_radio_hierarchical`
			'taxonomy'   => 'category', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
		// Optionally override the args sent to the WordPress get_terms function.
			'query_args' => array(
			// 'orderby' => 'slug',
			// 'hide_empty' => true,
			),
		)
	);
	$cmb_post->add_field(
		array(
			'name'     => esc_html__( 'Test Taxonomy Select', 'palamut' ),
			'desc'     => esc_html__( 'field description (optional)', 'palamut' ),
			'id'       => $prefix . 'taxonomy_select',
			'type'     => 'taxonomy_select',
			'taxonomy' => 'category', // Taxonomy Slug
		)
	);
	$cmb_post->add_field(
		array(
			'name'     => esc_html__( 'Test Taxonomy Multi Checkbox', 'palamut' ),
			'desc'     => esc_html__( 'field description (optional)', 'palamut' ),
			'id'       => $prefix . 'multitaxonomy',
			'type'     => 'taxonomy_multicheck', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`
			'taxonomy' => 'post_tag', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Checkbox', 'palamut' ),
			'desc' => esc_html__( 'field description (optional)', 'palamut' ),
			'id'   => $prefix . 'checkbox',
			'type' => 'checkbox',
		)
	);
	$cmb_post->add_field(
		array(
			'name'    => esc_html__( 'Test Multi Checkbox', 'palamut' ),
			'desc'    => esc_html__( 'field description (optional)', 'palamut' ),
			'id'      => $prefix . 'multicheckbox',
			'type'    => 'multicheck',
			// 'multiple' => true, // Store values in individual rows
			'options' => array(
				'check1' => esc_html__( 'Check One', 'palamut' ),
				'check2' => esc_html__( 'Check Two', 'palamut' ),
				'check3' => esc_html__( 'Check Three', 'palamut' ),
			),
		 // 'inline'  => true, // Toggles display to inline
		)
	);
	$cmb_post->add_field(
		array(
			'name'    => esc_html__( 'Test wysiwyg', 'palamut' ),
			'desc'    => esc_html__( 'field description (optional)', 'palamut' ),
			'id'      => $prefix . 'wysiwyg',
			'type'    => 'wysiwyg',
			'options' => array(
				'textarea_rows' => 5,
			),
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'Test Image', 'palamut' ),
			'desc' => esc_html__( 'Upload an image or enter a URL.', 'palamut' ),
			'id'   => $prefix . 'image',
			'type' => 'file',
		)
	);
	$cmb_post->add_field(
		array(
			'name'         => esc_html__( 'Multiple Files', 'palamut' ),
			'desc'         => esc_html__( 'Upload or add multiple images/attachments.', 'palamut' ),
			'id'           => $prefix . 'file_list',
			'type'         => 'file_list',
			'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		)
	);
	$cmb_post->add_field(
		array(
			'name' => esc_html__( 'oEmbed', 'palamut' ),
			'desc' => sprintf(
				/* translators: %s: link to codex.wordpress.org/Embeds */
				esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'palamut' ),
				'<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
			),
			'id'   => $prefix . 'embed',
			'type' => 'oembed',
		)
	);
	$cmb_post->add_field(
		array(
			'name'         => 'Testing Field Parameters',
			'id'           => $prefix . 'parameters',
			'type'         => 'text',
			'before_row'   => 'palamut_before_row_if_2', // callback.
			'before'       => '<p>Testing <b>"before"</b> parameter</p>',
			'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
			'after_field'  => '<p>Testing <b>"after_field"</b> parameter</p>',
			'after'        => '<p>Testing <b>"after"</b> parameter</p>',
			'after_row'    => '<p>Testing <b>"after_row"</b> parameter</p>',
		)
	);
}

//add_action( 'cmb2_admin_init', 'palamut_register_post_metabox' );

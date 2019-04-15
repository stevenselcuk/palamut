<?php
/**
 * Custom Areas for user profile
 *
 * Gives functionality for displaying users social accounts in front-end some other things.
 *
 * It may theme spesific.
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
 * Add custom metaboxes to user profile
 *
 * @method palamut_user_profile_metabox_init
 *
 * @since 1.0.1
 *
 * @link https://github.com/CMB2/CMB2/wiki/Examples
 */
function palamut_user_profile_metabox_init() {
	$prefix = 'pdw_user_';

	/**
	 * Metabox for the user profile screen
	 */
	$cmb_user = new_cmb2_box(
		array(
			'id'               => $prefix . 'edit',
			'title'            => esc_html__( 'User Profile Metabox', 'palamut' ),
			'object_types'     => array( 'user' ),
			'show_names'       => true,
			'new_user_section' => 'add-existing-user',
		)
	);

	$cmb_user->add_field(
		array(
			'name'     => esc_html__( 'Extra profile fields', 'palamut' ),
			'desc'     => esc_html__( 'PDW Theme spesific fields (All optional)', 'palamut' ),
			'id'       => $prefix . 'extra_info',
			'type'     => 'title',
			'on_front' => false,
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Avatar', 'palamut' ),
			'desc' => esc_html__( 'Alternative for Gravatar', 'palamut' ),
			'id'   => $prefix . 'avatar',
			'type' => 'file',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Tagline', 'palamut' ),
			'desc' => esc_html__( 'A short description about yourself!)', 'palamut' ),
			'id'   => $prefix . 'tagline',
			'type' => 'text',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Facebook', 'palamut' ),
			'desc' => esc_html__( 'Your Facebook Profile URL', 'palamut' ),
			'id'   => $prefix . 'facebook_url',
			'type' => 'text_url',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Twitter', 'palamut' ),
			'desc' => esc_html__( 'Your Twitter Profile URL', 'palamut' ),
			'id'   => $prefix . 'twitter_url',
			'type' => 'text_url',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Linkedin', 'palamut' ),
			'desc' => esc_html__( 'Your Linkedin Profile URL', 'palamut' ),
			'id'   => $prefix . 'linkedin_url',
			'type' => 'text_url',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Youtube', 'palamut' ),
			'desc' => esc_html__( 'Your Youtube Channel URL', 'palamut' ),
			'id'   => $prefix . 'youtube_url',
			'type' => 'text_url',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Vimeo', 'palamut' ),
			'desc' => esc_html__( 'Your Vimeo Channel URL', 'palamut' ),
			'id'   => $prefix . 'vimeo_url',
			'type' => 'text_url',
		)
	);

	$cmb_user->add_field(
		array(
			'name' => esc_html__( 'Instagram', 'palamut' ),
			'desc' => esc_html__( 'Your Instagram Profile URL', 'palamut' ),
			'id'   => $prefix . 'instagram_url',
			'type' => 'text_url',
		)
	);

}

add_action( 'cmb2_admin_init', 'palamut_user_profile_metabox_init' );

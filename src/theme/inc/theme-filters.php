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
 * @version pkg.license
 * @since 1.0.0
 *
 * @author pkg.author
 * @copyright pkg.copyright
 * @license pkg.license
 */

/**
 * Removes the "Protected" prefix on protected post titles. Returns the title back.
 */
function prefix_remove_protected_text() {
	return '%s';
}
add_filter( 'protected_title_format', 'prefix_remove_protected_text' );

/**
 * Customize the content for password protected content.
 *
 * @param string $content The post content.
 */
function prefix_protected_content( $content ) {

	if ( post_password_required() ) {
		$content = sprintf( '<p>%1s "<em>%2s</em>"</p>', esc_html__( 'Please enter the password below to access', 'textdomain' ), esc_html( get_the_title() ) );
	}

	return $content;
}
add_filter( 'the_content', 'prefix_protected_content' );

/**
 * Customize the password protected form.
 */
function prefix_password_form() {
	global $post;

	$label = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
	$form  = '
	<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		<label class="hidden" for="' . esc_attr( $label ) . '">' . esc_html__( 'Password', 'textdomain' ) . ' </label>
		<input name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" maxlength="20" /><input type="submit" name="Submit" value="' . esc_attr__( 'Submit', 'textdomain' ) . '" />
	</form>
	';

	return $form;
}
add_filter( 'the_password_form', 'prefix_password_form' );


/**
 * Adds a <p> wrapper to the more link, which shows up when the More block is added.
 *
 * @param string|int $more_link Link.
 * @param string|int $more_link_text Text.
 */
function prefix_modify_read_more_link( $more_link, $more_link_text ) {

	$button            = get_theme_mod( 'blogroll_more_btn', prefix_defaults( 'blogroll_more_btn' ) );
	$button_visibility = ( false === $button ) ? ' hidden' : null;

	$allowed_html = array(
		'span' => array(
			'class' => array(),
		),
	);

	// Show this within the Customizer, or if Button is true.
	if ( $button || is_customize_preview() ) {
		return '<p><a class="more-link ' . esc_attr( $button_visibility ) . '" href="' . esc_url( get_permalink() ) . '">' . wp_kses( $more_link_text, $allowed_html ) . '</a></p>';
	} else {
		// Clear the more link.
		$more_link_text = '';

		return $more_link_text;
	}
}
add_filter( 'the_content_more_link', 'prefix_modify_read_more_link', 0, 2 );


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

 /**
  * Removes the "Protected" prefix on protected post titles. Returns the title back.
  */
function palamut_remove_protected_text() {
	return '%s';
}
add_filter( 'protected_title_format', 'palamut_remove_protected_text' );

 /**
  * Customize the content for password protected content.
  *
  * @param string $content The post content.
  */
function palamut_protected_content( $content ) {

	if ( post_password_required() ) {
		$content = sprintf( '<p>%1s "<em>%2s</em>"</p>', esc_html__( 'Please enter the password below to access', 'palamut' ), esc_html( get_the_title() ) );
	}

	return $content;
}
add_filter( 'the_content', 'palamut_protected_content' );

 /**
  * Customize the password protected form.
  */
function palamut_password_form() {
	global $post;

	$label = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
	$form  = '
	<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		<label class="hidden" for="' . esc_attr( $label ) . '">' . esc_html__( 'Password', 'palamut' ) . ' </label>
		<input name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" maxlength="20" /><input type="submit" name="Submit" value="' . esc_attr__( 'Submit', 'palamut' ) . '" />
	</form>
	';

	return $form;
}
add_filter( 'the_password_form', 'palamut_password_form' );


/**
 * Adds a <p> wrapper to the more link, which shows up when the More block is added.
 *
 * @param string|int $more_link Link.
 * @param string|int $more_link_text Text.
 */
function palamut_modify_read_more_link( $more_link, $more_link_text ) {

	$button            = get_theme_mod( 'blogroll_more_btn', palamut_defaults( 'blogroll_more_btn' ) );
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
add_filter( 'the_content_more_link', 'palamut_modify_read_more_link', 0, 2 );


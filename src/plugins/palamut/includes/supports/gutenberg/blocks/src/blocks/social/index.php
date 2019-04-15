<?php
/**
 * Server-side rendering of the `palamut/social` block.
 *
 * @package   Palamut
 * @author    Rich Tabor & Jeffrey Carandang from Palamut
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Renders the block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the block content.
 */
function palamut_render_social_block( $attributes ) {

	global $post;

	// Get the featured image.
	if ( has_post_thumbnail() ) {
		$thumbnail_id = get_post_thumbnail_id( $post->ID );
		$thumbnail    = $thumbnail_id ? current( wp_get_attachment_image_src( $thumbnail_id, 'large', true ) ) : '';
	} else {
		$thumbnail = null;
	}

	// Generate the Twitter URL.
	$twitter_url = '
		http://twitter.com/share?
		text=' . get_the_title() . '
		&url=' . get_the_permalink() . '
	';

	// Generate the Facebook URL.
	$facebook_url = '
		https://www.facebook.com/sharer/sharer.php?
		u=' . get_the_permalink() . '
		&title=' . get_the_title() . '
	';

	// Generate the LinkedIn URL.
	$linkedin_url = '
		https://www.linkedin.com/shareArticle?mini=true
		&url=' . get_the_permalink() . '
		&title=' . get_the_title() . '
	';

	// Generate the Pinterest URL.
	$pinterest_url = '
		https://pinterest.com/pin/create/button/?
		&url=' . get_the_permalink() . '
		&description=' . get_the_title() . '
		&media=' . esc_url( $thumbnail ) . '
	';

	// Generate the Tumblr URL.
	$tumblr_url = '
		https://tumblr.com/share/link?
		url=' . get_the_permalink() . '
		&name=' . get_the_title() . '
	';

	// Generate the Reddit URL.
	$reddit_url = '
		https://www.reddit.com/submit?
		url=' . get_the_permalink() . '
	';

	// Generate the Email URL.
	$email_url = '
		mailto:
		?subject=' . get_the_title() . '
		&body=' . get_the_title() . '
		&mdash;' . get_the_permalink() . '
	';

	// Generate the Google URL.
	$google_url = '
		https://plus.google.com/share
		?url=' . get_the_permalink() . '
	';

	// Apply filters, so that the social URLs can be modified.
	$twitter_url   = apply_filters( 'palamut_twitter_share_url', $twitter_url );
	$facebook_url  = apply_filters( 'palamut_facebook_share_url', $facebook_url );
	$pinterest_url = apply_filters( 'palamut_pinterest_share_url', $pinterest_url );
	$linkedin_url  = apply_filters( 'palamut_linkedin_share_url', $linkedin_url );
	$email_url     = apply_filters( 'palamut_email_share_url', $email_url );
	$tumblr_url    = apply_filters( 'palamut_tumblr_share_url', $tumblr_url );
	$reddit_url    = apply_filters( 'palamut_reddit_share_url', $reddit_url );
	$google_url    = apply_filters( 'palamut_google_share_url', $google_url );

	// Attributes.
	$text_align    = is_array( $attributes ) && isset( $attributes['textAlign'] ) ? "style=text-align:{$attributes['textAlign']}" : false;
	$border_radius = is_array( $attributes ) && isset( $attributes['borderRadius'] ) ? "border-radius: {$attributes['borderRadius']}px;" : false;

	$has_backround           = '';
	$background_color_class  = '';
	$custom_background_color = '';
	$has_color               = '';
	$text_color_class        = '';
	$custom_text_color       = '';

	if ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-mask' ) !== false ) {
		$has_backround           = is_array( $attributes ) && isset( $attributes['hasColors'] ) && ( isset( $attributes['backgroundColor'] ) || isset( $attributes['customBackgroundColor'] ) ) && ( $attributes['hasColors'] || ( $attributes['backgroundColor'] || $attributes['customBackgroundColor'] ) ) ? 'has-text-color' : false;
		$background_color_class  = is_array( $attributes ) && isset( $attributes['backgroundColor'] ) ? "has-{$attributes['backgroundColor']}-color" : false;
		$custom_background_color = is_array( $attributes ) && isset( $attributes['customBackgroundColor'] ) && isset( $attributes['hasColors'] ) && ( ! $attributes['hasColors'] && ! isset( $attributes['backgroundColor'] ) ) ? "color: {$attributes['customBackgroundColor']};" : false;

	} else {
		$has_backround           = is_array( $attributes ) && isset( $attributes['hasColors'] ) && ( isset( $attributes['backgroundColor'] ) || isset( $attributes['customBackgroundColor'] ) ) && ( $attributes['hasColors'] || ( isset( $attributes['backgroundColor'] ) || $attributes['customBackgroundColor'] ) ) ? 'has-background' : false;
		$background_color_class  = is_array( $attributes ) && isset( $attributes['backgroundColor'] ) ? "has-{$attributes['backgroundColor']}-background-color" : false;
		$custom_background_color = is_array( $attributes ) && isset( $attributes['customBackgroundColor'] ) && isset( $attributes['hasColors'] ) && ( ! $attributes['hasColors'] && ! isset( $attributes['backgroundColor'] ) ) ? "background-color: {$attributes['customBackgroundColor']};" : false;

		$has_color         = is_array( $attributes ) && isset( $attributes['hasColors'] ) && ( isset( $attributes['textColor'] ) || isset( $attributes['customTextColor'] ) ) && ( $attributes['hasColors'] || ( isset( $attributes['textColor'] ) || $attributes['customTextColor'] ) ) ? 'has-text-color' : false;
		$text_color_class  = is_array( $attributes ) && isset( $attributes['textColor'] ) ? "has-{$attributes['textColor']}-color" : false;
		$custom_text_color = is_array( $attributes ) && isset( $attributes['customTextColor'] ) && isset( $attributes['hasColors'] ) && ( ! $attributes['hasColors'] && ! isset( $attributes['textColor'] ) ) ? "color: {$attributes['customTextColor']};" : false;
	}

	$icon_size = '';
	if ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-mask' ) !== false ) {
		$icon_size = is_array( $attributes ) && isset( $attributes['iconSize'] ) ? "height:{$attributes['iconSize']}px;width: {$attributes['iconSize']}px;" : false;
	}

	// Supported social media platforms.
	$platforms = array(
		'twitter'   => array(
			'text' => esc_html__( 'Share on Twitter', '@@textdomain' ),
			'url'  => $twitter_url,
		),
		'facebook'  => array(
			'text' => esc_html__( 'Share on Facebook', '@@textdomain' ),
			'url'  => $facebook_url,
		),
		'pinterest' => array(
			'text' => esc_html__( 'Share on Pinterest', '@@textdomain' ),
			'url'  => $pinterest_url,
		),
		'linkedin'  => array(
			'text' => esc_html__( 'Share on Linkedin', '@@textdomain' ),
			'url'  => $linkedin_url,
		),
		'email'     => array(
			'text' => esc_html__( 'Share via Email', '@@textdomain' ),
			'url'  => $email_url,
		),
		'tumblr'    => array(
			'text' => esc_html__( 'Share on Tumblr', '@@textdomain' ),
			'url'  => $tumblr_url,
		),
		'google'    => array(
			'text' => esc_html__( 'Share on Google', '@@textdomain' ),
			'url'  => $google_url,
		),
		'reddit'    => array(
			'text' => esc_html__( 'Share on Reddit', '@@textdomain' ),
			'url'  => $reddit_url,
		),
	);

	// Start markup.
	$markup = '';

	foreach ( $platforms as $id => $platform ) {

		if ( isset( $attributes[ $id ] ) && $attributes[ $id ] ) {
			$markup .= sprintf(
				'<li>
					<a href="%1$s" class="wp-block-button__link wp-block-palamut-social__button wp-block-palamut-social__button--%8$s %3$s %7$s %9$s %10$s" title="%2$s" style="%4$s%6$s%11$s">
						<span class="wp-block-palamut-social__icon" style="%5$s"></span>
						<span class="wp-block-palamut-social__text">%2$s</span>
					</a>
				</li>',
				esc_url( $platform['url'] ),
				esc_html( $platform['text'] ),
				esc_attr( $has_backround ),
				esc_attr( $border_radius ),
				esc_attr( $icon_size ),
				esc_attr( $custom_background_color ),
				esc_attr( $background_color_class ),
				esc_attr( $id ),
				esc_attr( $has_color ),
				esc_attr( $text_color_class ),
				esc_attr( $custom_text_color )
			);
		}
	}

	// Build classes.
	$class = 'wp-block-palamut-social';

	if ( isset( $attributes['className'] ) ) {
		$class .= ' ' . $attributes['className'];
	}

	if ( isset( $attributes['hasColors'] ) && $attributes['hasColors'] ) {
		$class .= ' has-colors';
	}

	if ( isset( $attributes['size'] ) && 'med' !== $attributes['size'] && ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-mask' ) === false ) ) {
		$class .= ' has-button-size-' . $attributes['size'];
	}

	// Render block content.
	$block_content = sprintf(
		'<div class="%1$s" %2$s><ul>%3$s</ul></div>',
		esc_attr( $class ),
		esc_attr( $text_align ),
		$markup
	);

	return $block_content;
}

/**
 * Registers the block on server.
 */
function palamut_register_social_block() {

	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	register_block_type(
		'palamut/social', array(
			'editor_script'   => 'palamut-editor',
			'editor_style'    => 'palamut-editor',
			'style'           => 'palamut-frontend',
			'attributes'      => array(
				'className'             => array(
					'type' => 'string',
				),
				'hasColors'             => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'borderRadius'          => array(
					'type'    => 'number',
					'default' => 40,
				),
				'size'                  => array(
					'type'    => 'string',
					'default' => 'med',
				),
				'iconSize'              => array(
					'type'    => 'number',
					'default' => 30,
				),
				'textAlign'             => array(
					'type' => 'string',
				),
				'backgroundColor'       => array(
					'type' => 'string',
				),
				'customBackgroundColor' => array(
					'type' => 'string',
				),
				'textColor'             => array(
					'type' => 'string',
				),
				'customTextColor'       => array(
					'type' => 'string',
				),
				'twitter'               => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'facebook'              => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'pinterest'             => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'linkedin'              => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'tumblr'                => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'reddit'                => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'email'                 => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'google'                => array(
					'type'    => 'boolean',
					'default' => false,
				),
			),
			'render_callback' => 'palamut_render_social_block',
		)
	);
}
add_action( 'init', 'palamut_register_social_block' );


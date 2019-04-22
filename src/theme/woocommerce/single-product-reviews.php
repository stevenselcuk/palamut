<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">

	<div class="reviews__inner">

		<div class="reviews__inner_padding">

			<div id="comments">
				<h2 class="woocommerce-Reviews-title">
					<?php
					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) ) {
						printf( _n( '%1$s review for %2$s%3$s%4$s', '%1$s reviews for %2$s%3$s%4$s', $count, 'palamut' ), $count, '<span>', get_the_title(), '</span>' );
					} else {
						esc_html_e( 'Reviews', 'palamut' );
					}
				?>
				</h2>

				<?php if ( have_comments() ) : ?>

					<ol class="commentlist">
						<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
					</ol>

					<?php
					if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
						echo '<nav class="woocommerce-pagination">';
						paginate_comments_links(
							apply_filters(
								'woocommerce_comment_pagination_args', array(
									'prev_text' => '&larr;',
									'next_text' => '&rarr;',
									'type'      => 'list',
								)
							)
						);
						echo '</nav>';
					endif;
					?>

				<?php else : ?>

					<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'palamut' ); ?></p>

				<?php endif; ?>
			</div>

			<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

				<div id="review_form_wrapper">
					<div id="review_form">
						<?php
							$commenter = wp_get_current_commenter();

							$comment_form = array(
								'title_reply'         => have_comments() ? __( 'Add a review', 'palamut' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'palamut' ), get_the_title() ),
								'title_reply_to'      => __( 'Leave a Reply to %s', 'palamut' ),
								'comment_notes_after' => '',
								'fields'              => array(
									'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'palamut' ) . ' <span class="required">*</span></label> ' .
												'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></p>',
									'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'palamut' ) . ' <span class="required">*</span></label> ' .
												'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></p>',
								),
								'label_submit'        => __( 'Submit', 'palamut' ),
								'logged_in_as'        => '',
								'comment_field'       => '',
							);

						if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
								$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'palamut' ), esc_url( $account_page_url ) ) . '</p>';
						}

						if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
							$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating:', 'palamut' ) . '</label><select name="rating" id="rating" aria-required="true" required>
								<option value="">' . __( 'Rate&hellip;', 'palamut' ) . '</option>
								<option value="5">' . __( 'Perfect', 'palamut' ) . '</option>
								<option value="4">' . __( 'Good', 'palamut' ) . '</option>
								<option value="3">' . __( 'Average', 'palamut' ) . '</option>
								<option value="2">' . __( 'Not that bad', 'palamut' ) . '</option>
								<option value="1">' . __( 'Very Poor', 'palamut' ) . '</option>
							</select></p>';
						}

							$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'palamut' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

							comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
						?>
					</div>
				</div>

			<?php else : ?>

				<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'palamut' ); ?></p>

			<?php endif; ?>

			<div class="clear"></div>

		</div>

	</div>

</div>

<?php
/**
 * Comments Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/
?>

<?php do_action( 'digitalstore_before_comments' ); ?>

<div id="comments">
    <?php if ( post_password_required() ) : ?>
        <p class="nopassword"><?php _e( 'This entry is password protected. Enter the password to view any comments.', 'edd-digitalstore' ); ?></p>
    </div><!-- #comments -->
    <?php
            return;
        endif;
    ?>
    <?php if ( have_comments() ) : ?>

        <h3 id="comments-title"><?php printf( _n( '1 Response for "%2s"', '%1s Responses for "%2s"', get_comments_number(), 'edd-digitalstore' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?></h3>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ): ?>
            <nav class="navigation">
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'edd-digitalstore' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'edd-digitalstore' ) ); ?></div>
            </nav><!-- .navigation -->
        <?php endif; ?>

        <ol class="commentlist">
            <?php wp_list_comments( array( 'callback'=>'digitalstore_theme_comment' ) );?>
        </ol><!-- .commentlist -->

    <?php endif; ?>

    <?php
            // If comments are closed and there are no comments, let's leave a little note, shall we?
            if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
            <p class="nocomments"><?php _e( 'Comments are closed.', 'edd-digitalstore' ); ?></p>
    <?php endif; ?>

    <?php 
        comment_form(
        array(
            'title_reply' => __( 'Leave a comment', 'edd-digitalstore' ),
            'comment_notes_before' => '',
            'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'edd-digitalstore' ) . '</label><textarea id="comment" name="comment" rows="10" aria-required="true"></textarea></p>',
            'label_submit' => __( 'Submit Comment', 'edd-digitalstore' ),
            'class_submit' => 'button primary'
        ) ); 
    ?>

</div><!-- #comments -->

<?php do_action( 'digitalstore_after_comments' ); ?>
<?php
/**
 * Theme Comments Functions
 *
 * Comment functions that are specific for this theme.
 * 
 * @package      Digital Store
 * @subpackage   Comments
 * @author       Matt Varone <contact@mattvarone.com>
 * @copyright    Copyright (c) 2012, Matt Varone
 * @link         http://www.mattvarone.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/** 
 * Theme Comment 
 * 
 * Callback to print the theme comments.
 * 
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_theme_comment' ) ) {
    function digitalstore_theme_comment( $comment, $args, $depth ) {

        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li class="pingback">
            <p><span class="fn"><?php _e( 'Pingback', 'digitalstore-mattvarone' ); ?></span> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'digitalstore-mattvarone' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
            break;
            default :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

                <article id="comment-<?php comment_ID(); ?>" class="comment">

                        <div class="comment-author vcard">
                            
                            <div class="comment-avatar">
                                <?php echo get_avatar( $comment, 51 ); ?>
                            </div><!-- comment-avatar -->

                            <div class="comment-author-meta">
                                <?php printf( __( '<span class="fn">%s</span>', 'digitalstore-mattvarone' ), get_comment_author_link() ); ?>
                                <?php

                                printf( '<time pubdate datetime="%2$s">%3$s</time> <a href="%1$s" class="comment-link">#</a>',
                                    esc_url( get_comment_link( $comment->comment_ID ) ),
                                    get_comment_time( 'c' ),
                                    sprintf( __( '%1$s %2$s', 'digitalstore-mattvarone' ), get_comment_date(), get_comment_time() )
                                     );
                                ?>
                            </div><!-- comment-author-meta -->

                        </div><!-- .comment-author -->

                        <div class="comment-contents">

                                <?php if ( $comment->comment_approved == '0' ) : ?>
                                    <em class="comment-awaiting-moderation">
                                        <?php _e( 'Your comment is awaiting moderation.', 'digitalstore-mattvarone' ); ?>
                                    </em><!-- .comment-awaiting-moderation -->
                                <?php endif; ?>

                                <div class="comment-content">
                                    <?php comment_text(); ?>
                                </div><!-- .comment-content -->

                                <span class="comment-meta">
                                    <?php

                                    printf( '<span class="reply">%1$s</span>',
                                        get_comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'digitalstore-mattvarone' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) )
                                     ) );

                                    if ( current_user_can( 'moderate_comments' ) ) {
                                        echo '<a href="' . get_edit_comment_link( $comment->comment_ID ) . '" title="' . __( 'Edit this comment', 'digitalstore-mattvarone' ) . '">' . __( 'Edit', 'digitalstore-mattvarone' ) . '</a>';
                                        echo ' &middot; <a href="' . admin_url( "comment.php?action=cdc&dt&c=" . $comment->comment_ID ) . ' title="'. __( 'Delete this comment', 'digitalstore-mattvarone' ) .'">' . __( 'Delete', 'digitalstore-mattvarone' ) . '</a>';
                                        echo ' &middot; <a href="' . admin_url( "comment.php?action=cdc&dt=spam&c=" . $comment->comment_ID ) . ' title="'. __( 'Mark comment as Spam', 'digitalstore-mattvarone' ) . '">' . __( 'Spam', 'digitalstore-mattvarone' ) . '</a>';
                                    }
                                    ?>
                                </span><!-- .comment-meta -->
                                
                        </div><!-- .comment-contents -->

                </article><!-- #comment-<?php comment_ID(); ?> -->

        <?php
        break;
        endswitch;
    }
}
<?php
/**
 * Partial: Content Standard
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
		return;

do_action( 'digitalstore_before_content', $post ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <div class="entry">
            
            <?php if ( has_post_thumbnail() ): ?>
                <div class="entry-image">
                   <?php the_post_thumbnail( 'digitalstore_thumb_155x156' ); ?>
                </div><!-- .entry-image -->
            <?php endif ?>
            
            <header class="entry-header">
                
                <h2 class="entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'edd-digitalstore' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                </h2><!-- entry-title -->
                
                <?php if ( 'post' == get_post_type() ) : ?>
                    <div class="entry-meta">
                        <?php digitalstore_posted_on(); ?>
                    </div><!-- .entry-meta -->
                <?php endif; ?>

            </header><!-- .entry-header -->
            
            
            <?php if ( is_search() || is_archive() || is_home() ): ?>
                <div class="entry-summary">
                    <?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'edd-digitalstore' ) ); ?>
                </div><!-- .entry-summary -->
            <?php else: ?>
                <div class="entry-content">
                    <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'edd-digitalstore' ) ); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'edd-digitalstore' ), 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
            <?php endif ?>
            
                <footer class="entry-meta">
                    <?php $show_sep = false; ?>
                    <?php if ( 'post' == get_post_type() ) : ?>
                    <?php
                        $categories_list = get_the_category_list( __( ', ', 'edd-digitalstore' ) );
                        if ( $categories_list ):
                    ?>
                    <span class="cat-links">
                        <?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'edd-digitalstore' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
                        $show_sep = true; ?>
                    </span>
                    <?php endif; ?>
                    <?php
                        $tags_list = get_the_tag_list( '', __( ', ', 'edd-digitalstore' ) );
                        if ( $tags_list ):
                        if ( $show_sep ) : ?>
                    <span class="sep"> | </span>
                        <?php endif; ?>
                    <span class="tag-links">
                        <?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'edd-digitalstore' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
                        $show_sep = true; ?>
                    </span>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ( comments_open() ) : ?>
                    <?php if ( $show_sep ) : ?>
                    <span class="sep"> | </span>
                    <?php endif; ?>
                    <span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'edd-digitalstore' ) . '</span>', __( '1 Reply', 'edd-digitalstore' ), __( '% Replies', 'edd-digitalstore' ) ); ?></span>
                    <?php endif; ?>

                </footer><!-- #entry-meta -->
                        
        </div><!-- .entry -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'digitalstore_after_content', $post ); ?>
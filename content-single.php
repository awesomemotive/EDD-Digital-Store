<?php
/**
 * Partial: Content Single
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

do_action( 'digitalstore_before_content', $post ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <div class="entry">
                        
            <header class="entry-header">

                <h1 class="entry-title">
                    <?php the_title(); ?>
                </h1>
                
                <?php if ( 'post' == get_post_type() ) : ?>
                    <div class="entry-meta">
                        <?php digitalstore_posted_on(); ?>              
                    </div><!-- .entry-meta -->
                <?php endif; ?>

            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'edd-digitalstore' ) ); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'edd-digitalstore' ), 'after' => '</div>' ) ); ?>
            </div><!-- .entry-content -->
            
            <footer class="entry-utility">
                <?php
                    $tag_list = get_the_tag_list( '', ', ' );
                    if ( '' != $tag_list ) {
                        $utility_text = __( 'Posted in %1$s and tagged %2$s.', 'edd-digitalstore' );
                    } else {
                        $utility_text = __( 'Posted in %1$s.', 'edd-digitalstore' );
                    }
                    printf(
                        $utility_text,
                        get_the_category_list( ', ' ),
                        $tag_list
                    );
                ?>
            </footer><!-- .entry-meta -->
        
        </div><!-- .entry -->
    
</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'digitalstore_after_content', $post ); ?>
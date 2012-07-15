<?php
/**
 * Partial: Content Page 
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
            
            <h1 class="page-title"><?php the_title(); ?></h1>
            
            <?php if ( has_excerpt() ): ?>
                <div class="intro-meta"><?php the_excerpt() ?></div>
            <?php endif ?>
            
        </header><!-- .entry-header -->
        
        <?php if ( has_post_thumbnail() ): ?>
            <div class="entry-image">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif ?>
        
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'edd-digitalstore' ) ); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'edd-digitalstore' ), 'after' => '</div>' ) ); ?>
        </div><!-- .entry-content -->
        
        <?php edit_post_link(); ?>
        
    </div>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'digitalstore_after_content', $post ); ?>
<?php
/**
 * Tag Archive Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

get_header( 'tag' ); ?>

<section id="main" role="main">
        
        <?php if ( have_posts() ) : ?>
            
            <?php do_action( 'digitalstore_before_template_header' ); ?>
            
            <header class="page-header">
                <h1 class="page-title"><?php printf( __( 'Tag Archives: %s', 'edd-digitalstore' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
                
                    <?php 
                        $category_description = category_description();
                        if ( ! empty( $category_description ) ) 
                        echo apply_filters( 'category_archive_meta', '<div class="intro-meta">' . $category_description . '</div>' );
                    ?>
            </header>
            
            <?php while ( have_posts() ) : the_post(); ?>
                
                <?php get_template_part( 'content' ); ?>
                
            <?php endwhile; ?>
            
            <?php get_template_part( 'pagination' ); ?>
            
        <?php else: ?>
            
            <article class="post no-results not-found">
                
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'edd-digitalstore' ); ?></h1>
                </header><!-- .entry-header -->
                
                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested tag. Perhaps searching will help find a related post.', 'edd-digitalstore' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
                
            </article>
            
        <?php endif; ?>
        
</section><!-- #main -->

<?php get_sidebar( 'tag' ); ?>
<?php get_footer( 'tag' ); ?>
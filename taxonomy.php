<?php
/**
 * Default Taxonomy Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

if ( ! have_posts() ) {
    get_template_part( '404' );
}

get_header( 'taxonomy' ); ?>

<section id="main" role="main">
            
            <?php if ( have_posts() ) : ?>
                
                <?php do_action( 'digitalstore_before_template_header' ); ?>
                
                <header class="page-header">
                    <h1 class="page-title"><?php single_term_title(); ?></h1>
                
                    <?php
                        $term_description = term_description();
                        if ( isset( $term_description ) ) 
                        echo apply_filters( 'term_archive_meta', '<div class="intro-meta">' .  $term_description . '</div>' );
                    ?>
                </header>
                        
                <?php while ( have_posts() ) : the_post(); ?>
                
                    <?php get_template_part( 'content', get_post_format() ); ?>
                
                <?php endwhile; ?>
                
                <?php get_template_part( 'pagination' ); ?>
                
            <?php else: ?>
                
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'edd-digitalstore' ); ?></h1>
                </header><!-- .entry-header -->
                
                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested taxonomy. Perhaps searching will help find a related post.', 'edd-digitalstore' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
                    
            <?php endif; ?>

</section><!-- #main -->

<?php get_sidebar( 'taxonomy' ); ?>
<?php get_footer( 'taxonomy' ); ?>
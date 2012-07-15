<?php
/**
 * Search Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

get_header( 'search' ) ?>

<section id="main" role="main">
            
            <?php if ( have_posts() ) : ?>
                
                <?php do_action( 'digitalstore_before_template_header' ); ?>
                
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e( sprintf( _n( '%1$s result was found for "%2$s".', '%1$s results were found for "%2$s".', ( int ) $wp_query->found_posts, 'edd-digitalstore' ), number_format_i18n( ( int ) $wp_query->found_posts ), get_search_query() ) ); ?></h1>
                </header><!-- .page-header -->
                
                <?php while ( have_posts() ) : the_post(); $post_type = get_post_type(); ?>
                    
                    <?php get_template_part( 'content', $post_type ); ?>
                    
                <?php endwhile; ?>
                
                <?php get_template_part( 'pagination' ); ?>
                
            <?php else : ?>
                
                <header class="entry-header">
                    <h1 class="page-title"><?php _e( 'Nothing Found', 'edd-digitalstore' ); ?></h1>
                </header><!-- .entry-header -->
                
                <div class="entry-content">
                    <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'edd-digitalstore' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
                
            <?php endif; ?>

</section>
<?php get_sidebar( 'search' ); ?>
<?php get_footer( 'search' ) ?>
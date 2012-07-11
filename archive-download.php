<?php
/**
 * Downloads Archive Template
 *
 * @package      Digital Store
 * @author       Matt Varone <contact@mattvarone.com>
 * @copyright    Copyright (c) 2012, Matt Varone
 * @link         http://www.mattvarone.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

get_header( 'archive-download' ); ?>

<section id="main" role="main">

            <?php if ( have_posts() ) : ?>
                
                <?php do_action( 'digitalstore_before_template_header' ); ?>

                <header class="page-header downloads-archive">
                    <h1 class="page-title"><?php $post_type_obj = get_post_type_object( 'download' ); printf( __( 'All %s', 'digitalstore-mattvarone' ), $post_type_obj->labels->menu_name ); ?></h1>
                </header>

                <div class="downloads-wrapper">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'content-download' ); ?>
                    <?php endwhile; ?>
                </div>
                
                <?php get_template_part( 'pagination' ); ?>

            <?php else: ?>
                        
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'digitalstore-mattvarone' ); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'digitalstore-mattvarone' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->

            <?php endif; ?>

</section><!-- #main -->
<?php get_sidebar( 'archive-download' ); ?> 
<?php get_footer( 'archive-download' );  ?>
<?php
/**
 * Default Template
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
    die();
}

get_header(); ?>

        <div id="main" role="main">
            
            <?php do_action( 'digitalstore_before_template_header' ); ?>
            
            <?php while ( have_posts() ) : the_post(); ?>
                
                <?php get_template_part( 'content', get_post_format() ); ?>
                
            <?php endwhile; ?>
            
            <?php get_template_part( 'pagination' ); ?>
            
        </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
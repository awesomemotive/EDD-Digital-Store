<?php
/**
 * Default Page Template 
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

if ( ! have_posts() ) {
    get_template_part( '404', 'page' );
}

get_header( 'page' ); ?>

<section id="main" role="main" class="page">
            
            <?php do_action( 'digitalstore_before_template_header' ); ?>
            
            <?php while ( have_posts() ) : the_post(); ?>
                
                <?php get_template_part( 'content', 'page' ); ?>
                
            <?php endwhile; ?>
            
</section><!-- #main -->

<?php get_sidebar( 'page' ); ?>
<?php get_footer( 'page' ); ?>
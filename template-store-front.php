<?php
/**
 * Template Name: Store Front
 *
 * The Store font-page template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

get_header( 'store-front' ); ?>
    <section id="main" role="main">
        
        <?php do_action( 'digitalstore_before_template_header' ); ?>
        
        <?php do_action( 'digitalstore_store_front' ); ?>
        
    </section><!-- #main -->
<?php get_sidebar( 'store-front' ); ?>
<?php get_footer( 'store-front' ); ?>
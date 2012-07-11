<?php
/** 
 * Slideshow
 *
 * @package      Digital Store
 * @subpackage   Slideshow
 * @author       Matt Varone <contact@mattvarone.com>
 * @copyright    Copyright (c) 2012, Matt Varone
 * @link         http://www.mattvarone.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/** 
 * Store Front Slideshow
 *
 * Echoes the Slideshow on the store front page
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_front_slideshow' ) ) {
    function digitalstore_front_slideshow() {
        ?>
        <div class="slideshow">
            <ul class="slides">
                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/slide-3.jpg" alt=""/></li>                
                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/slide-1.jpg" alt=""/></li>
                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/slide-2.jpg" alt=""/></li>
            </ul>
        </div>
        <?php
    }
}
add_action( 'digitalstore_store_front', 'digitalstore_front_slideshow', 1 );


if ( ! function_exists( 'digitalstore_front_slideshow_scripts' ) ) {
    function digitalstore_front_slideshow_scripts() {
        if ( is_front_page() ) {
            wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/inc/jquery.flexslider-min.js', array( 'jquery' ), '1.8', false );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'digitalstore_front_slideshow_scripts' );

/**
 * Theme Slideshow Page
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_theme_slideshow_add_page' ) ) {
    function digitalstore_theme_slideshow_add_page() {
        $page = add_theme_page( __( 'Theme Slideshow', 'digitalstore-mattvarone' ), __( 'Slideshow', 'digitalstore-mattvarone' ), 'edit_theme_options', 'theme_slideshow', 'digitalstore_theme_slideshow_render_page' );
    }
}
add_action( 'admin_menu', 'digitalstore_theme_slideshow_add_page' );

 
/**
 * Theme Slideshow Render Page
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

if ( ! function_exists( 'digitalstore_theme_slideshow_render_page' ) ) {
    function digitalstore_theme_slideshow_render_page() {
        
    }
}
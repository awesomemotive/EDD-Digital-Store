<?php
/** 
 * Digital Store Theme Sidebars
 *
 * @package      Digital Store
 * @subpackage   Sidebars
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/** 
 * Theme Sidebars
 *
 * Registers theme sidebars.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_theme_sidebars' ) ) {
    function digitalstore_theme_sidebars() {
        register_sidebar( array(
            'name' => __( 'Primary | Widget Area', 'edd-digitalstore' ),
            'id' => 'primary-widget-area',
            'description' => __( 'The primary widgets area', 'edd-digitalstore' ),
            'before_widget' => '<div class="%2$s widget">',
            'after_widget' => "</div>",
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
         ) );
         
         register_sidebar( array(
            'name' => __( 'Complementary | Widget Area', 'edd-digitalstore' ),
            'id' => 'complementary-widget-area',
            'description' => __( 'The complementary widgets area', 'edd-digitalstore' ),
            'before_widget' => '<div class="%2$s widget">',
            'after_widget' => "</div>",
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
         ) );
    }
}
add_action( 'widgets_init', 'digitalstore_theme_sidebars' );
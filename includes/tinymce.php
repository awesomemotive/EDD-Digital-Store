<?php
/**
 * Theme Tiny MCE CSS Styles
 *
 * Adds CSS classes to the TinyMCE styles download.
 *
 * @package      Digital Store
 * @subpackage   TinyMCE Styles
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/** 
 * Digital Store Tiny MCE Button
 *
 * Adds the select box to the second row of the visual editor.
 *
 * @return   array
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_theme_mce_button' ) ) {
    function digitalstore_theme_mce_button( $buttons ) {
        array_unshift( $buttons, 'styleselect' );
        return $buttons;
    }
}
add_filter( 'mce_buttons_2', 'digitalstore_theme_mce_button' );


/** 
 * Digital Store Tiny MCE Styles
 *
 * Adds custom classes to the TinyMCE style selector.
 *
 * @return   array
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_theme_mce_styles' ) ) {
    function digitalstore_theme_mce_styles( $settings ) {
      
      $settings['theme_advanced_blockformats'] = 'p, a, div, span, h1, h2, h3, h4, h5, h6, tr, ';
       
      $style_formats = array(
          
          // Buttons
          array( 'title' => __( 'Buttons', 'edd-digitalstore' ) ),
          // Primary Button
          array( 'title' => __( 'Button', 'edd-digitalstore' ), 'inline' => 'span',  'classes' => 'button' ),
          // Smaller Button
          array( 'title' => __( 'Button Small', 'edd-digitalstore' ), 'inline' => 'span',  'classes' => 'button btn-small' ),
          
          // Utilities
          array( 'title' => __( 'Utility', 'edd-digitalstore' ) ),
          // Highlight text
          array( 'title' => __( 'Highlight', 'edd-digitalstore' ), 'inline'   => 'span', 'classes' => 'highlight' ),
      );

      $settings['style_formats'] = json_encode( $style_formats );
      return $settings;
    }
}
add_filter( 'tiny_mce_before_init', 'digitalstore_theme_mce_styles', 10 );
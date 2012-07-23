<?php
/** 
 * Theme Customizer Functions
 *
 * @package      Digital Store
 * @subpackage   Customize
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/** 
 * Digital Store Customize Controls 
 *
 * Adds controls for the WP 3.4+ theme customize feature.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_preview_add_controls' ) ) {
    function digitalstore_preview_add_controls( $wp_customize ) {
        $options = digitalstore_get_theme_options();
        
        // Additional control formats for the customize feature
        locate_template( array( 'includes/customize/class-wp-customize-controls.php' ), true );
        
        /* Image Logo */
        $wp_customize->add_setting( 'digitalstore_theme_options[logo_image]', array(
            'default'    => $options['logo_image'],
            'section'    => 'strings',
            'capability' => digitalstore_option_page_capability(),
            'type'       => 'option',
         ) );

        $wp_customize->add_control( new DigitalStore_WP_Customize_Logo_Image_Control( $wp_customize ) );
        
        /* Skin */
        $wp_customize->add_section( 'digitalstore_skins', array(
            'title'    => __( 'Skins', 'edd-digitalstore' ),
            'priority' => 6,
         ) );
        
        $wp_customize->add_setting( 'digitalstore_theme_options[theme_skin]', array(
            'default'    => $options['theme_skin'],
            'section'    => 'digitalstore_skins',
            'capability' => digitalstore_option_page_capability(),
            'type'       => 'option',
         ) );

        $wp_customize->add_control( 'digitalstore_theme_options[theme_skin]', array(
            'label'      => __( 'Variations', 'edd-digitalstore' ),
            'section'    => 'digitalstore_skins',
            'type'       => 'select',
            'choices'    => digitalstore_theme_skin_options(),
         ) );

        /* Accent Color */
        $wp_customize->add_setting( 'digitalstore_theme_options[accent_color]', array(
            'default'           => $options['accent_color'],
            'control'           => 'color',
            'sanitize_callback' => 'digitalstore_sanitize_hex',
            'capability'        => digitalstore_option_page_capability(),
            'type'              => 'option',
         ) );
        
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'digitalstore_theme_options[accent_color]', array(
            'label'   => __( 'Highlight Color', 'edd-digitalstore' ),
            'section' => 'digitalstore_skins',
         ) ) );
               
        /* Footer Text */
        $wp_customize->add_section( 'digitalstore_footer', array(
            'title'    => __( 'Footer', 'edd-digitalstore' ),
            'priority' => 45,
         ) );

        $wp_customize->add_setting( 'digitalstore_theme_options[footer_text]', array(
            'default'           =>  $options['footer_text'],
            'capability'        =>  digitalstore_option_page_capability(),
            'sanitize_callback' => 'digitalstore_sanitize_footer_text',
            'type'              => 'option',             
            'transport'         => 'postMessage'
         ) );

        $wp_customize->add_control( new DigitalStore_WP_Customize_Textarea_Control( $wp_customize, 'digitalstore_theme_options[footer_text]', array(
            'label'    => __( 'Footer Text', 'edd-digitalstore' ),
            'section'  => 'digitalstore_footer',
         ) ) );
     
    }
}
add_action( 'customize_register', 'digitalstore_preview_add_controls' );


/** 
 * Digital Store Sanitize Footer Text
 *
 * Sanitizes the footer text.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_sanitize_footer_text' ) ) {
    function digitalstore_sanitize_footer_text( $value = "" ) {
        return stripslashes_deep( $value );
    }
}


/** 
 * Digital Store Sanitize Hex Color
 *
 * Sanitizes the color picker color codes
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_sanitize_hex' ) ) {
    function digitalstore_sanitize_hex( $color = "" ) {
        return stripslashes_deep( $color );
    }
}


/** 
 * Digital Store Preview Scripts
 *
 * Enqueues the theme customize script.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_preview_script' ) ) {
    function digitalstore_preview_script() {
        wp_enqueue_script( 'digitalstore-preview-script', get_stylesheet_directory_uri() . '/includes/customize/js/digitalstore-customize-preview.js' );
    }
}
add_action( 'customize_controls_print_footer_scripts', 'digitalstore_preview_script', 10 );
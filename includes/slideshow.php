<?php
/** 
 * Slideshow
 *
 * @package      Digital Store
 * @subpackage   Slideshow
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
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
                <?php 
                $slide_args = array(
                    'post_type' => 'edd_slide',
                    'posts_per_page' => -1,
                    'suppress_filters' => true
                );
                $slides = get_posts( apply_filters('digitalstore_slide_query_args', $slide_args ) );
                if( $slides ) :
                    foreach( $slides as $slide ) :
                        $slide_image_args = apply_filters('digitalstore_slide_image_args', array('alt' => '', 'title' => '') );
                        echo '<li>' . get_the_post_thumbnail( $slide->ID, 'digitalstore_thumb_full', $slide_image_args ) . '</li>';
                    endforeach;
                else :
                    ?>
                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/slide-3.jpg" alt=""/></li>                
                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/slide-1.jpg" alt=""/></li>
                    <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/slide-2.jpg" alt=""/></li>
                    <?php
                endif; 
                ?>
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
 * Theme Slideshow Post Type
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

if ( ! function_exists( 'digitalstore_theme_slideshow_post_type' ) ) {
    function digitalstore_theme_slideshow_post_type() {
        
        $slide_show_labels = array(
            'name'              => _x('Slideshow', 'post type general name', 'edd-digitalstore'),
            'singular_name'     => _x('Slide', 'post type singular name', 'edd-digitalstore'),
            'add_new'           => __('Add Slide', 'edd-digitalstore'),
            'add_new_item'      => __('Add New Slide', 'edd-digitalstore'),
            'edit_item'         => __('Edit Slide', 'edd-digitalstore'),
            'new_item'          => __('New Slide', 'edd-digitalstore'),
            'all_items'         => __('Slideshow', 'edd-digitalstore'),
            'view_item'         => __('View Slide', 'edd-digitalstore'),
            'search_items'      => __('Search Slides', 'edd-digitalstore'),
            'not_found'         =>  __('No Slides found', 'edd-digitalstore'),
            'not_found_in_trash'=> __('No Slides found in Trash', 'edd-digitalstore'), 
            'parent_item_colon' => '',
            'menu_name'         => __('Slideshow', 'edd-digitalstore')
        );

        $slide_show_args = array(
            'labels' => $slide_show_labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true, 
            'show_in_menu' => 'themes.php',
            'show_in_nav_menus' => false,
            'query_var' => false,
            'rewrite' => false,
            'has_archive' => false, 
            'hierarchical' => false,
            'supports' => array( 'thumbnail' ),
            'register_meta_box_cb' => 'digitalstore_slide_add_meta_boxe'
        );

        register_post_type('edd_slide', $slide_show_args);
    }
}
add_action( 'init', 'digitalstore_theme_slideshow_post_type' );


/**
 * Theme Slideshow Meta Boxes
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function digitalstore_slide_add_meta_boxe() {

    // Remove the default featured image meta box
    remove_meta_box( 'postimagediv', 'edd_slide', 'side' );

    // Add a custom featured image meta box
    add_meta_box( 'postimagediv', 'Slide Image', 'post_thumbnail_meta_box', 'edd_slide', 'normal', 'high' );

}
add_action( 'add_meta_boxes_slide',  'digitalstore_slide_add_meta_boxe', 999 );


/**
 * Replace "Featured Image" Labels
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function digitalstore_slide_post_thumbnail_html( $output ) {
    global $post_type;

    // beware of translated admin
    if ( ! empty ( $post_type ) && 'edd_slide' == $post_type ) {
        $output = str_replace( 'Set featured image', 'Select / Upload a slide image', $output );
        $output = str_replace( 'Remove featured image', 'Remove slide image', $output );
    }

    return $output;
}
add_filter( 'admin_post_thumbnail_html', 'digitalstore_slide_post_thumbnail_html' );


/**
 * Edit WP List Table Columns
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function digitalstore_slide_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'thumbnail' => 'Slide',
    );

    return $columns;
}
add_filter( 'manage_edit-edd_slide_columns', 'digitalstore_slide_edit_columns' );


/**
 * Render the Slide columns
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/

function digitalstore_slide_custom_columns( $column ) {
    global $post;
    switch ($column) {
        case 'thumbnail' :
            if ( has_post_thumbnail( $post->ID ) ) { // the current post has a thumbnail
                the_post_thumbnail( $post->ID );
            }
            else { // the current post lacks a thumbnail
               _e('No Image', 'edd-digitalstore');
            }

            // add row_action links for Edit and Trash because there's no title column
            $post_type_object = get_post_type_object( $post->post_type );
            $can_edit_post = current_user_can( $post_type_object->cap->edit_post, $post->ID );
            $always_visible = false; // change to true to make it always show instead of on hover
            $actions = array();

            if ( $can_edit_post && 'trash' != $post->post_status ) {
                $actions['edit'] = '<a href="' . get_edit_post_link( $post->ID, true ) . '" title="' . esc_attr( __( 'Edit this item' ) ) . '">' . __( 'Edit' ) . '</a>';
            }
            if ( current_user_can( $post_type_object->cap->delete_post, $post->ID ) ) {
                if ( 'trash' == $post->post_status )
                    $actions['untrash'] = "<a title='" . esc_attr( __( 'Restore this item from the Trash' ) ) . "' href='" . wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $post->ID ) ), 'untrash-' . $post->post_type . '_' . $post->ID ) . "'>" . __( 'Restore' ) . "</a>";
                elseif ( EMPTY_TRASH_DAYS )
                    $actions['trash'] = "<a class='submitdelete' title='" . esc_attr( __( 'Move this item to the Trash' ) ) . "' href='" . get_delete_post_link( $post->ID ) . "'>" . __( 'Trash' ) . "</a>";
                if ( 'trash' == $post->post_status || !EMPTY_TRASH_DAYS )
                    $actions['delete'] = "<a class='submitdelete' title='" . esc_attr( __( 'Delete this item permanently' ) ) . "' href='" . get_delete_post_link( $post->ID, '', true ) . "'>" . __( 'Delete Permanently' ) . "</a>";
            }

            $action_count = count( $actions );
            $i = 0;
            $out = '<div class="' . ( $always_visible ? 'row-actions-visible' : 'row-actions' ) . '">';
            foreach ( $actions as $action => $link ) {
                ++$i;
                ( $i == $action_count ) ? $sep = '' : $sep = ' | ';
                $out .= "<span class='$action'>$link$sep</span>";
            }
            $out .= '</div>';

            echo $out;
            break;
    }
}
add_action( 'manage_edd_slide_posts_custom_column',  'digitalstore_slide_custom_columns' );
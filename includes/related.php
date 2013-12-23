<?php
/** 
 * Related Entries
 *
 * Retrieves related entries on singular views.
 *
 * @package      Digital Store
 * @subpackage   Related
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/** 
 * Related Entries Callback 
 * 
 * Returns a list of related entries.
 * 
 * @return   void
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_related_entries_callback' ) ) {
    function digitalstore_related_entries_callback( $post ) {
        
        if ( ! is_singular( 'download') )
        return;
        
        // verify there is a post
        if ( ! isset( $post ) )
        return;
        
        // initalize array
        $related_downloads = array();
        
        // get the post taxonomies
        $taxonomies = get_object_taxonomies( $post, 'objects' );
        
        // verify there is a taxonomy
        if ( empty( $taxonomies ) )
        return;
        
        // loop and get terms
        $terms_in = array();
        $i = 0;
        foreach ( $taxonomies as $taxonomy ) {
            $terms = get_the_terms( $post->ID, $taxonomy->name );
            $terms_in[$i]['tax'] = $taxonomy->name;
            if ( ! empty( $terms ) ) 
            foreach ( $terms as $term ) {
                $terms_in[$i]['terms'][] = $term->term_id;
            }
            $i++;
        }
        
        $post_id = $post->ID;
        $post_type = $post->post_type;
        $c = 0;
        while ( count( $related_downloads ) < 4 && isset( $terms_in[$c] ) ) {
            
            // check for tax and terms
            if ( ! isset( $terms_in[$c]['tax'] ) || ! isset( $terms_in[$c]['terms'] ) ) {
                $c = $c + 1;
                continue;
            }
            
            // loop with a max of 4 posts per query
            foreach ( $terms_in[$c]['terms'] as $key => $value ) {
                $params = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => $terms_in[$c]['tax'],
                            'field' => 'id',
                            'terms' => $value
                         )
                    ),
                    'post_type' => $post_type,
                    'post__not_in' => array( $post_id ),
                    'numberposts' => 4,
                    'ignore_sticky_posts' => 1,
                    'post_status' => 'publish',
                    'orderby' => 'rand',
                );
                
                $related = get_posts( $params );
                
                if ( ! empty( $related ) ) {
                    foreach ( $related as $related_download ) {
                        if ( count( $related_downloads ) == 4 )  break;
                        $related_downloads[$related_download->ID] = $related_download;
                    }
                }
            }
            
            $c = $c + 1;
            
            // limit to 5 loops
            if ( $c > 5 ) break;
        }
        
        if ( empty( $related_downloads ) )
        return;
        
        $post_type_obj = get_post_type_object( $post_type );
        
        $out = '<h3 class="section-title related-entries-title">' . sprintf( __( 'Related %s', 'edd-digitalstore' ), $post_type_obj->labels->menu_name  ) . '</h3>';
        $out .= '<ul class="related-entries">';
        
        $link  = '<a href="%s" title="%s" rel="bookmark" class="%s">%s</a>';
        
        foreach ( $related_downloads as $download ) {
            
            $permalink = get_permalink( $download->ID );
            $price = '<div class="edd-the-price">' . digitalstore_edd_the_price( $download->ID ). '</div>';
            $thumb = "";
            
            $out .= '<li>';
                
            if ( has_post_thumbnail( $download->ID ) ) {
                $thumb = sprintf( $link, 
                    $permalink, 
                    $download->post_title, 
                    'related-entry-thumb', 
                    get_the_post_thumbnail( $download->ID, 'digitalstore_thumb_155x156', array( 'title' => $download->post_title ) ) . $price );
            } else {
                $thumb = sprintf( $link, 
                $permalink, 
                $download->post_title, 
                'related-entry-thumb', 
                '<img src="'.get_stylesheet_directory_uri().'/img/nopic.gif" alt="'.$download->post_title.'"/>' . $price );
            }
            
            $out .= $thumb;
                
            $out .= sprintf( $link, $permalink, $download->post_title, 'related-entry-title', $download->post_title );
            
            $out .= '</li>';
        }
        
        $out .= '</ul>';
        
        wp_reset_query();
        
        echo $out;
    }
}
// Hooks into the Digital Store Theme
add_action( 'digitalstore_after_content', 'digitalstore_related_entries_callback' );
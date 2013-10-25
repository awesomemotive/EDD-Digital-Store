<?php
/**
 * Theme Pagination
 *
 * @package      Digital Store
 * @subpackage   Pagination
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/**
 * Pagination
 *
 * Echoes the pagination for the theme.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

function digitalstore_pagination( $range = 4, $return = false, $_wp_query = null  ) {

    global $paged, $wp_query, $wp_rewrite;

    $wpq = ( $_wp_query ) ? $_wp_query : $wp_query;
    $max_page = $wpq->max_num_pages;
    $paged = $paged ? $paged : 1;

    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

    $out = '<p class="digitalstore-pagination">';

    $pages_text = sprintf( __( 'Page %d of %d', 'edd-digitalstore' ), number_format_i18n( $paged ), number_format_i18n( $max_page ) );

    $out .= '<span class="pages">' . $pages_text . '</span>';

    $pagination = array(
      'base'        => add_query_arg( 'paged', '%#%' ),
      'format'      => '',
      'total'       => $wp_query->max_num_pages,
      'current'     => $current,
      'end_size'    => $range,
      'prev_text'   => __( '&laquo;', 'edd-digitalstore' ),
      'next_text'   => __( '&raquo;', 'edd-digitalstore' ),
      'type'        => 'plain'
    );

    if ( $wp_rewrite->using_permalinks() ) {
        $base_url = get_pagenum_link( 1 );
        if ( is_search() )
          $base_url = preg_replace( '/\?.*/', '', $base_url );
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( array( 's' ), $base_url ) ) . 'page/%#%/', 'paged' );
    }

    if ( ! empty( $wp_query->query_vars['s'] ) )
      $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

    $out .= paginate_links( $pagination );

    $out .= '</p>';

    if ( $return )
        return $out;
    else
        echo $out;
}
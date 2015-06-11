<?php
/**
 * Pagination Partial
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

if (  function_exists( 'digitalstore_pagination' ) ) {

    digitalstore_pagination();

}  else if (  $wp_query->max_num_pages > 1 ) { ?>
    
    <nav class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'edd-digitalstore' ) ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'edd-digitalstore' ) ); ?></div>
    </nav><!-- #nav-below -->
    
<?php };  ?>
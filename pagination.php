<?php
/**
 * Pagination Partial
 *
 * @package      Digital Store
 * @author       Matt Varone <contact@mattvarone.com>
 * @copyright    Copyright (c) 2012, Matt Varone
 * @link         http://www.mattvarone.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

if (  function_exists( 'digitalstore_pagination' ) ) {

    digitalstore_pagination();

}  else if (  $wp_query->max_num_pages > 1 ) { ?>
    
    <nav class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'digitalstore-mattvarone' ) ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'digitalstore-mattvarone' ) ); ?></div>
    </nav><!-- #nav-below -->
    
<?php };  ?>
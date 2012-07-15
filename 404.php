<?php
/**
 * 404 Template.
 *
 * This file will be loaded by WordPress for all 404 views.
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

get_header( '404' ); ?>

<section id="main" role="main" class="page">

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="entry">

                <?php do_action( 'digitalstore_before_template_header' ); ?>

                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Error 404', 'edd-digitalstore' ); ?></h1><!-- entry-header -->
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p><?php _e( 'Sorry, but the content you are looking for could not be found. It may have been moved or even deleted. Please try searching or use one of the links below.', 'edd-digitalstore' ); ?></p>

                    <?php get_search_form(); ?>

                    <h3><?php _e( 'Recent Posts', 'edd-digitalstore' ); ?></h3>

                    <ul>
                    <?php
                        $args = array( 'numberposts' => '5' );
                        $recent_posts = wp_get_recent_posts( $args );
                        foreach( $recent_posts as $post )
                            if ( $post['post_title'] )
                            echo '<li><a href="' . get_permalink( $post["ID"] ) . '" title="' . $post["post_title"] . '" >' .   $post["post_title"] . '</a></li>';
                    ?>
                    </ul>

                    <h3><?php _e( 'Topics', 'edd-digitalstore' ); ?></h3>

                    <div class="topics">
                    <?php
                        $params = array( 'largest' => '18', 'taxonomy'  => array( 'post_tag', 'category' ), 'orderby' => 'count', 'order' => 'DESC', 'number' => 0 ); 
                        wp_tag_cloud( $params ); ?>
                    </div><!-- .topics -->

                </div><!-- .entry-content -->

        </div><!-- .entry -->

    </article><!-- .post -->

</section><!-- #main -->
<?php get_sidebar( '404' ); ?>
<?php get_footer( '404' ); ?>
<?php exit; ?>
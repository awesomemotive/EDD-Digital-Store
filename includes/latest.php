<?php
/**
 * Latest Downloads
 *
 * @package      Digital Store
 * @subpackage   Latest Downloads
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/**
 * Latest Downloads
 *
 * Retrieves the latest downloads.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_latest_downloads' ) ) {
    function digitalstore_latest_downloads( $args = array() ) {

        // parse attributes
        $atts = wp_parse_args( $args, array(
            'title'    =>  __( 'Latest %s', 'edd-digitalstore' ),
            'all'      => 1,
            'limit'    => get_option( 'posts_per_page' ),
            'thumb'    => 1,
            'size'     => 'digitalstore_thumb_small',
            'fallback' => get_stylesheet_directory_uri() . '/img/nopic.gif',
         ) );

        // filter atts
        $atts = apply_filters( 'digitalstore_latest_downloads_atts', $atts );

        // get post type object
        $post_type_obj = get_post_type_object( 'download' );

        // check if it's valid
        if ( is_null( $post_type_obj ) )
        return;

        // set query arguments
        $params = array(
            'post_type'      => 'download',
            'post_status'    => 'publish',
            'posts_per_page' => $atts['limit']
        );

        // create query
        $downloads = new WP_Query( $params );

        // loop
        if ( $downloads->have_posts() ) { $i = 1; ?>
        <div class="section-latest latest-<?php echo strtolower( $post_type_obj->label ); ?>">
            <div class="section-title">
                <h3 class="latest-title"><?php  printf( $atts['title'], $post_type_obj->labels->menu_name ); ?></h3>
                <?php if ( $atts['all'] == 1 ): ?>
                    <a href="<?php echo get_post_type_archive_link( 'download' ); ?>" class="view-all" ><span><?php _e( 'View All', 'edd-digitalstore' ); ?></span></a><!-- .view-all -->
                <?php endif; ?>
            </div><!-- .section-title -->
            <ul class="latest-listing">
            <?php while ( $downloads->have_posts() ) : $downloads->the_post(); ?>
                <li<?php if( $i % 4 == 0 ) echo ' class="last"'; ?>>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="latest-thumbnail">
                    <div class="edd-the-price">
                        <?php echo digitalstore_edd_the_price( get_the_ID() ); ?>
                    </div>
                    <?php if ( has_post_thumbnail() && $atts['thumb'] == 1 ): ?>
                        <?php the_post_thumbnail( $atts['size'] ); ?>
                    <?php elseif ( $atts['fallback'] != "" ): ?>
                        <img src="<?php echo $atts['fallback']; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                    <?php endif; ?>
                    </a><!-- latest-thumbnail -->

                    <div class="latest-meta">
                        <h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
                    </div><!-- latest-meta -->

                </li>
            <?php $i++; endwhile; ?>
            </ul><!-- .latest-listing -->
        </div><!-- .section-latest.<?php echo $class ?> -->
        <?php
        }
        wp_reset_query();
        wp_reset_postdata();
    }
}


/**
 * Store Front Latest Downloads
 *
 * Echoes the latest downloads on the store front page
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_front_latest_downloads' ) ) {
    function digitalstore_front_latest_downloads() {
        digitalstore_latest_downloads();
    }
}
add_action( 'digitalstore_store_front', 'digitalstore_front_latest_downloads', 2 );
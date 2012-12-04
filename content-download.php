<?php
/**
 * Partial: Content Download
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

global $edd_options;

do_action( 'digitalstore_before_content', $post ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'display-listing' ); ?>>

        <div class="entry">

            <div class="entry-image">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php if ( has_post_thumbnail() ): ?>
                        <?php the_post_thumbnail( 'digitalstore_thumb_216x217' ); ?>
                    <?php else: ?>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/nopic-medium.gif" alt="<?php the_title(); ?>"/>
                    <?php endif ?>
                </a>
            </div><!-- entry-image -->

            <header class="entry-header">
                <h3 class="entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </h3><!-- .entry-title -->
            </header><!-- .entry-header -->

            <div class="entry-meta">
                <?php
                    if ( ! edd_item_in_cart( $post->ID ) ) {
                        if ( edd_has_variable_prices( $post->ID ) ) {
                            echo '<a href="' . get_permalink() . '" class="button edd_button">' . __( 'View Details', 'edd-digitalstore' ) . '</a>';
                        } else {
                            echo do_shortcode( '[purchase_link id="' . $post->ID . '" price="0" text="' . __( 'Add To Cart', 'edd-digitalstore' ) . '" style="blue"]' );
                        }
                    } else {
                        echo '<a href="' . get_permalink( $edd_options['purchase_page'] ) . '" class="edd_go_to_checkout edd_button">' . __( 'Checkout', 'edd-digitalstore' ) . '</a>';
                    }
                ?>                
                <span class="entry-price"><?php echo digitalstore_edd_the_price( $post->ID ); ?></span>
            </div><!-- .entry-meta -->

        </div><!-- .entry -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'digitalstore_after_content', $post ); ?>
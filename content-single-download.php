<?php
/**
 * Partial: Content Single Download
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

do_action( 'digitalstore_before_content', $post ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="entry">

            <div class="entry-image">
                <?php if ( has_post_thumbnail() ): ?>
                    <?php the_post_thumbnail( 'digitalstore_thumb_321x292' ); ?>
                <?php else: ?>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/nopic-large.gif" alt="<?php the_title_attribute(); ?>"/>
                <?php endif ?>
            </div><!-- entry-image -->

            <header class="entry-header">

                <h1 class="entry-title">
                    <?php the_title(); ?>
                </h1><!-- entry-title -->

                <div class="entry-price">
                    <div class="price"><?php echo digitalstore_edd_the_price( $post->ID ); ?></div>
                    <?php do_action( 'digitalstore_after_price', $post ); ?>
                </div><!-- entry-price -->

                <?php do_action( 'digitalstore_add_to_cart', $post ); ?>

                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div><!-- .entry-summary -->

            </header><!-- .entry-header -->

            <h3 class="section-title">
                <?php _e( 'Description', 'edd-digitalstore' ); ?>
            </h3><!-- section-title -->

            <div class="entry-content">
                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'edd-digitalstore' ) ); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'edd-digitalstore' ), 'after' => '</div>' ) ); ?>
            </div><!-- .entry-content -->

            <footer class="entry-utility">
                <?php
                    $tag_list = get_the_term_list( $post->ID, 'download_tag', '', ', ', '' );
                    if ( '' != $tag_list ) {
                        $utility_text = __( 'Posted in %1$s and tagged %2$s.', 'edd-digitalstore' );
                    } else {
                        $utility_text = __( 'Posted in %1$s.', 'edd-digitalstore' );
                    }
                    printf(
                        $utility_text,
                        get_the_term_list( $post->ID, 'download_category', '', ', ', '' ),
                        $tag_list
                     );
                ?>
            </footer><!-- .entry-meta -->

        </div><!-- .entry -->

        <?php get_template_part( 'entry-meta' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php do_action( 'digitalstore_after_content', $post ); ?>
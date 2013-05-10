<?php
/**
 * Single Post Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

$post_type = get_post_type();

get_header( $post_type ); ?>

    <section id="main" role="main">

        <?php do_action( 'digitalstore_before_template_header' ); ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <?php if ( $post_type == 'post' ): ?>
                <?php get_template_part( 'content-single', get_post_format() ); ?>
            <?php else: ?>
                <?php get_template_part( 'content-single', $post_type ); ?>
            <?php endif ?>

            <?php if ( comments_open() ): ?>
                <?php comments_template( '', true ); ?>
            <?php endif ?>

        <?php endwhile; ?>

    </section><!-- #main -->

<?php get_sidebar( $post_type ); ?>
<?php get_footer( $post_type ); ?>
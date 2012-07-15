<?php
/**
 * Default Author Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

get_header( 'author' ); ?>

<section id="main" role="main">

            <?php if ( have_posts() ) : ?>

                <?php $curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) ); ?>

                <?php do_action( 'digitalstore_before_template_header' ); ?>

                <header class="page-header">
                    <h1 class="page-title author"><?php printf( __( 'Author Archives: <span class="vcard">%s</span>', 'edd-digitalstore' ), "<a class='url fn n' href='" . get_author_posts_url( $curauth->ID ) . "' title='" . esc_attr( $curauth->display_name ) . "' rel='me'>" . $curauth->display_name . "</a>" ); ?></h1>
                </header>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', get_post_format() ); ?>

                <?php endwhile; ?>

                <?php get_template_part( 'pagination' ); ?>

            <?php else: ?>

                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'edd-digitalstore' ); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested author. Perhaps searching will help find a related post.', 'edd-digitalstore' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->

            <?php endif; ?>

</section><!-- #main -->

<?php get_sidebar( 'author' ); ?>
<?php get_footer( 'author' ); ?>
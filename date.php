<?php
/**
 * Default Date Archive Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

if ( ! have_posts() ) {
    get_template_part( '404', 'archive-date' );
}

get_header( 'archive-date' ); ?>

<section id="main" role="main">

            <?php if ( have_posts() ) : ?>

                <?php do_action( 'digitalstore_before_template_header' ); ?>

                <header class="page-header">

                    <h1 class="page-title">
                        <?php if ( is_day() ) : ?>
                            <?php printf( __( 'Daily Archives: <span>%s</span>', 'edd-digitalstore' ), get_the_date() ); ?>
                        <?php elseif ( is_month() ) : ?>
                            <?php printf( __( 'Monthly Archives: <span>%s</span>', 'edd-digitalstore' ), get_the_date( 'F Y' ) ); ?>
                        <?php elseif ( is_year() ) : ?>
                            <?php printf( __( 'Yearly Archives: <span>%s</span>', 'edd-digitalstore' ), get_the_date( 'Y' ) ); ?>
                        <?php else : ?>
                            <?php _e( 'Archives', 'edd-digitalstore' ); ?>
                        <?php endif; ?>
                    </h1><!-- .page-title -->

                    <?php

                        $total = $wp_query->found_posts;

                        if ( is_year() )
                            $date_archive_meta = sprintf( _n( 'One entry was published in %2$s.', '%1$s entries were published in %2$s.', $total, 'edd-digitalstore' ), number_format_i18n( $total ), get_the_date( 'Y' ) );
                        else if ( is_day() )
                            $date_archive_meta = sprintf( _n( 'One entry was published on %2$s.', '%1$s entries were published on %2$s.', $total, 'edd-digitalstore' ), number_format_i18n( $total ), get_the_date() );
                        else if ( is_month() )
                            $year = get_query_var( 'year' );
                        if ( empty( $year ) ) {
                            $date_archive_meta = sprintf( _n( 'One entry was published in the month of %2$s.', '%1$s entries were published in the month of %2$s.', $total, 'edd-digitalstore' ), number_format_i18n( $total ), get_the_date( 'F' ) );
                        } else {
                            $date_archive_meta = sprintf( _n( 'One entry was published in %2$s of %3$s.', '%1$s entries were published in %2$s of %3$s.', $total, 'edd-digitalstore' ), number_format_i18n( $total ), get_the_date( 'F' ), get_the_date( 'Y' ) );
                        }

                        echo apply_filters( 'date_archive_meta', '<div class="intro-meta">' . $date_archive_meta . '</div>' );
                    ?>

                </header><!-- .page-title -->

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content' ); ?>

                <?php endwhile; ?>

                    <?php get_template_part( 'pagination' ); ?>

            <?php else: ?>

                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'edd-digitalstore' ); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'edd-digitalstore' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->

            <?php endif; ?>

</section><!-- #main --> 

<?php get_sidebar( 'date' ); ?>
<?php get_footer( 'archive-date' ); ?>
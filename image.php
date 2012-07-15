<?php
/**
 * Image Attachment
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

get_header('image'); ?>

        <section id="main" role="main">
            
            <?php while ( have_posts() ) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            
                            <div class="entry-meta">
                                <?php
                                    $metadata = wp_get_attachment_metadata();
                                    printf( __( '<span class="meta-prep meta-prep-entry-date">Published </span> <span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>', 'edd-digitalstore' ),
                                        esc_attr( get_the_time() ),
                                        get_the_date(),
                                        esc_url( wp_get_attachment_url() ),
                                        $metadata['width'],
                                        $metadata['height'],
                                        esc_url( get_permalink( $post->post_parent ) ),
                                        esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
                                        get_the_title( $post->post_parent )
                                     );
                                ?>
                            </div><!-- .entry-meta -->

                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            
                            <div class="entry-attachment">
                                <div class="attachment">
                                    
                                    <?php

                                        $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
                                        foreach ( $attachments as $k => $attachment ) {
                                            if ( $attachment->ID == $post->ID )
                                                break;
                                        }
                                        $k++;

                                        if ( count( $attachments ) > 1 ) {
                                            if ( isset( $attachments[ $k ] ) )
                                                $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
                                            else
                                                $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
                                        } else {
                                            $next_attachment_url = wp_get_attachment_url();
                                        }
                                    ?>
                                    
                                    <a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php echo wp_get_attachment_image( $post->ID, array( 710, 1024 ) ); ?></a>

                                    <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                                    <div class="entry-caption">
                                        <?php the_excerpt(); ?>
                                    </div><!-- .entry-caption -->
                                    <?php endif; ?>
                                    
                                </div><!-- .attachment -->

                            </div><!-- .entry-attachment -->

                            <div class="entry-description">
                                <?php the_content(); ?>
                                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'edd-digitalstore' ) . '</span>', 'after' => '</div>' ) ); ?>
                            </div><!-- .entry-description -->

                        </div><!-- .entry-content -->

                    </article><!-- #post-<?php the_ID(); ?> -->

                    <?php if ( comments_open() ): ?>
                        <?php comments_template( '', true ); ?>
                    <?php endif ?>

                <?php endwhile; // end of the loop. ?>

        </section><!-- #primary -->
<?php get_sidebar( 'image' ); ?>
<?php get_footer( 'image' ); ?>
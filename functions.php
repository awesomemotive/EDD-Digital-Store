<?php
/**
 * Digital Store Theme Functions
 *
 * @package      Digital Store
 * @subpackage   Functions
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

/*
|--------------------------------------------------------------------------
| Start of Functions.php
|--------------------------------------------------------------------------
*/

// Make sure EDD is active
if( !class_exists( 'Easy_Digital_Downloads' ) ) return;

define( 'EDD_DIGITAL_STORE_STORE_URL', 'https://easydigitaldownloads.com' );
define( 'EDD_DIGITAL_STORE_THEME_NAME', 'Digital Store Theme' );
define( 'EDD_DIGITAL_STORE_VERSION', '1.2.3' );


// Set content width
if ( ! isset( $content_width ) )
    $content_width = 710;


/**
 * Digital Store Theme Setup
 *
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_theme_setup' ) ) {
    function digitalstore_theme_setup() {

        /**
         * Make the theme available for translation.
         * Translations can be added in the /lang/ directory.
         */
        load_theme_textdomain( 'edd-digitalstore', get_template_directory() . '/lang' );

        $locale = get_locale();
        $locale_file = get_template_directory() . "/lang/$locale.php";
        if ( is_readable( $locale_file ) )
            require_once( $locale_file );

        // Add support for specific features
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'menus' );

        // Add support to pages for specific features
        add_post_type_support( 'page', 'excerpt' );
        add_post_type_support( 'download', 'excerpt' );

        // Add support for custom backgrounds in 3.4+
        add_theme_support( 'custom-background' );

        // Add TinyMCE editor style
        add_editor_style( 'style-editor.css' );

        // Define image sizes
        set_post_thumbnail_size( 710, 388, true );
        add_image_size( 'digitalstore_thumb_full', 707, 388, true );
        add_image_size( 'digitalstore_thumb_large', 321, 292, true );
        add_image_size( 'digitalstore_thumb_medium', 215, 217, true );
        add_image_size( 'digitalstore_thumb_small', 155, 156, true );
        add_image_size( 'digitalstore_thumb_thumb', 55, 55, true );

        // Register theme navigations
        register_nav_menu( 'primary', __( 'Primary Menu', 'edd-digitalstore' ) );
        register_nav_menu( 'secondary', __( 'Secondary Menu', 'edd-digitalstore' ) );

        // Set the title
        add_filter( 'wp_title', 'digitalstore_site_title', 10, 3 );

        // Enqueue Scripts
        add_action( 'wp_enqueue_scripts', 'digitalstore_theme_scripts', 100 );

        // Enqueue Styles
        add_action( 'wp_enqueue_scripts', 'digitalstore_theme_styles', 100 );

        // Menu CSS Class
        add_filter( 'nav_menu_css_class' , 'digitalstore_nav_checkout_class' , 10 , 2 );

        // Post class
        add_filter( 'post_class', 'digitalstore_post_class' );

        // Disable the automatic purchase button
        remove_filter( 'the_content', 'edd_append_purchase_link' );

        // Remove default EDD CSS
        remove_action( 'wp_enqueue_scripts', 'edd_register_styles' );

        // Add to cart button
        add_action( 'digitalstore_add_to_cart', 'digitalstore_add_to_cart_callback' );

        // Auto excerpt more
        add_filter( 'excerpt_more', 'digitalstore_auto_excerpt_more' );

        // Custom excerpt more
        add_filter( 'get_the_excerpt', 'digitalstore_custom_excerpt_more' );

        // Modify the excerpt length
        add_filter( 'excerpt_length', 'digitalstore_excerpt_length' );

        // Set EDD Widgets Pack default image size
        add_filter( 'edd_widgets_top_sellers_thumbnail_size', 'digitalstore_edd_widgets_thumbnail_size' );
        add_filter( 'edd_widgets_most_recent_thumbnail_size', 'digitalstore_edd_widgets_thumbnail_size' );
        add_filter( 'edd_widgets_most_commented_thumbnail_size', 'digitalstore_edd_widgets_thumbnail_size' );
        add_filter( 'edd_widgets_related_downloads_thumbnail_size', 'digitalstore_edd_widgets_thumbnail_size' );

        // Set EDD Widgets Pack default image size
        add_filter( 'edd_widgets_random_download_thumbnail_size', 'digitalstore_edd_widgets_single_thumbnail_size' );
        add_filter( 'edd_widgets_featured_download_thumbnail_size', 'digitalstore_edd_widgets_single_thumbnail_size' );

        // Increse thumbnails quality
        add_filter( 'jpeg_quality', 'digitalstore_theme_thumbs_quality' );

        // Set the footer text
        add_action( 'digitalstore_colophon_credits', 'digitalstore_add_colophon_credits' );

        // Theme filterable functions
        $filterable_includes = array(
            'sidebar'           => 'includes/sidebars.php',    // Sidebars
            'nav-walker'        => 'includes/walker.php',      // Nav Walker
            'slideshow'         => 'includes/slideshow.php',   // Slideshow
            'tinymce-styles'    => 'includes/tinymce.php',     // TinyMCE styles
            'comments'          => 'includes/comments.php',    // Comments
            'pagination'        => 'includes/pagination.php',  // Pagination
            'breadcrumbs'       => 'includes/breadcrumbs.php', // Breadcrumbs
            'related-downloads' => 'includes/related.php',     // Related downloads
            'customizer'        => 'includes/customize.php',   // Customizer ( 3.4+ )
            'latest-downloads'  => 'includes/latest.php',      // Latest Downloads
            'options'           => 'includes/options.php',     // Theme Options
        );

        // Allow child themes and plugins to filter the theme includes
        $includes = apply_filters( 'digitalstore_theme_includes', $filterable_includes );

        // Include the theme functions files
        foreach ( $includes as $key => $include ) {
            locate_template( $include, true );
        }
    }
}
add_action( 'after_setup_theme', 'digitalstore_theme_setup' );


/**
 * Theme Scripts
 *
 * Enqueues and Localizes Javascript.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_theme_scripts' ) ) {
    function digitalstore_theme_scripts() {
        // Modernizr
        wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/libs/modernizr.js', array(), '2.0.6', false );

        // Comment form validation
        if ( is_singular() && comments_open() && ! is_front_page() && ! is_page() )
        wp_enqueue_script( 'validate', get_template_directory_uri() . '/js/inc/jquery.validate.min.js', array( 'jquery' ), '1.9.0', true );

        // Theme script file
        if ( WP_DEBUG )
            $digitalstore_theme_script = 'scripts.dev.js';
        else
            $digitalstore_theme_script = 'scripts.min.js';

        wp_enqueue_script( 'digitalstore-theme-script', get_template_directory_uri() . '/js/' . $digitalstore_theme_script, array( 'jquery' ), '1.0' , true );

        // JS internationalization
        $params = array(
            'theme_uri'         => get_template_directory_uri(),
            // Drop down menu
            'in_goto'           => __( 'Go to...', 'edd-digitalstore' ),
            // EDD widget
            'in_gotocheckout'   => __( 'Go to Checkout', 'edd-digitalstore' ),
            'checkout_uri'      => edd_get_checkout_uri(),
            // Comments validation
            'in_author'         => __( 'Please enter a valid name.', 'edd-digitalstore' ),
            'in_email'          => __( 'Please enter a valid email address.', 'edd-digitalstore' ),
            'in_url'            => __( 'Please use a valid website address.', 'edd-digitalstore' ),
            'in_comment'        => __( 'Message must be at least 2 characters long.', 'edd-digitalstore' ),
        );

        // Script localization
        wp_localize_script( 'digitalstore-theme-script', 'digitalstore_theme_js_params', apply_filters( 'digitalstore_theme_js_params', $params ) );
    }
}


/**
 * Theme Styles
 *
 * Enqueues Styles.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_theme_styles' ) ) {
    function digitalstore_theme_styles() {
        // enqueue the main stylesheet
        wp_enqueue_style( 'style', get_stylesheet_uri() );
    }
}


/**
 * Load Selectivizr
 *
 * Enqueues the comment reply script.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

function digitalstore_ie_selectivizr() {
    echo '<!--[if ( lt IE 10 ) & ( ! IEMobile )]>';
    echo '<script src="'.get_template_directory_uri() . '/js/inc/selectivizr-min.js"></script>';
    echo '<! [endif]-->';
}
add_action( 'wp_head', 'digitalstore_ie_selectivizr' );


/**
 * Enqueue Comment Reply Script
 *
 * Enqueues the comment reply script.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

function digitalstore_enqueue_comment_reply_script() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'comment_form_before', 'digitalstore_enqueue_comment_reply_script' );


/**
 * Site Title
 *
 * The site title of the current page.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_site_title' ) ) {
    function digitalstore_site_title( $title, $sep, $seplocation ) {
        global $wp_query;

        $separator = apply_filters( 'digitalstore_page_title_separator', ' | ' );

        $on_front = get_option( 'show_on_front' );

        $out = "";

        if ( ( $on_front == "page" && is_front_page() ) || ( $on_front == "post" && is_home() ) ) {
            $out = get_bloginfo( 'name' ) . $separator .  get_bloginfo( 'description' );
        }

        elseif ( ( $on_front == "page" && is_home() ) || ( $on_front == "post" && is_front_page() ) || is_singular() ) {
            $id = $wp_query->get_queried_object_id();

            if ( is_front_page() )
                $out = get_bloginfo( 'name' ) . $separator . get_bloginfo( 'name' );
            elseif ( ! $out )
                $out = get_post_field( 'post_title', $id );

            $out .= $separator. get_bloginfo( 'name' );
        }

        elseif ( is_archive() ) {

            if ( is_category() ) {
                $term = $wp_query->get_queried_object();
                $out = $term->name;
            }
            elseif ( is_tag() ) {
                $term = $wp_query->get_queried_object();
                $out = $term->name;
            }
            elseif ( is_tax() ) {
                $term = $wp_query->get_queried_object();
                $out = $term->name;
            }
            elseif ( is_post_type_archive() ){
                $cpt = $wp_query->get_queried_object();
                $out = $cpt->label;
            }

            elseif ( is_author() )
                $out = get_the_author_meta( 'display_name', get_query_var( 'author' ) );

            elseif ( is_date () ) {
                if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
                    $out = sprintf( __( 'Archive for %1$s', 'edd-digitalstore' ), get_the_time( __( 'g:i a', 'edd-digitalstore' ) ) );

                elseif ( get_query_var( 'minute' ) )
                    $out = sprintf( __( 'Archive for minute %1$s', 'edd-digitalstore' ), get_the_time( __( 'i', 'edd-digitalstore' ) ) );

                elseif ( get_query_var( 'hour' ) )
                    $out = sprintf( __( 'Archive for %1$s', 'edd-digitalstore' ), get_the_time( __( 'g a', 'edd-digitalstore' ) ) );

                elseif ( is_day() )
                    $out = sprintf( __( 'Archive for %1$s', 'edd-digitalstore' ), get_the_time( __( 'F jS, Y', 'edd-digitalstore' ) ) );

                elseif ( get_query_var( 'w' ) )
                    $out = sprintf( __( 'Archive for week %1$s of %2$s', 'edd-digitalstore' ), get_the_time( __( 'W', 'edd-digitalstore' ) ), get_the_time( __( 'Y', 'edd-digitalstore' ) ) );

                elseif ( is_month() )
                    $out = sprintf( __( 'Archive for %1$s', 'edd-digitalstore' ), single_month_title( ' ', false ) );

                elseif ( is_year() )
                    $out = sprintf( __( 'Archive for %1$s', 'edd-digitalstore' ), get_the_time( __( 'Y', 'edd-digitalstore' ) ) );
            }

            $out .= $separator. get_bloginfo( 'name' );
        }

        elseif ( is_search() ){
            $out = sprintf( __( 'Search results for &quot;%1$s&quot;', 'edd-digitalstore' ), esc_attr( get_search_query() ) );
            $out .= $separator. get_bloginfo( 'name' );
        }

        elseif ( is_404() ) {
            $out = __( '404 Not Found', 'edd-digitalstore' );
            $out .= $separator. get_bloginfo( 'name' );
        }

        if ( ( ( $page = $wp_query->get( 'paged' ) ) || ( $page = $wp_query->get( 'page' ) ) ) && $page > 1 )
            $out = sprintf( __( '%1$s Page %2$s', 'edd-digitalstore' ), $out . $separator, $page );

        echo apply_filters( 'digitalstore_site_title_output', $out );
    }
}


/**
 * Nav Checkout Class
 *
 * Adds a special class to the navigation checkout page.
 *
 * @return   array
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_nav_checkout_class' ) ) {
    function digitalstore_nav_checkout_class( $classes, $item ){
        global $edd_options;
        if ( isset( $edd_options['purchase_page'] ) ) {
            if ( $item->object_id == $edd_options['purchase_page'] ) {
                $classes[] = 'digitalstore-checkout';
            }
        }
         return $classes;
    }
}



/**
 * Digital Store Theme Header
 *
 * Filters and return the theme header branding.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_get_theme_header' ) ) {
    function digitalstore_get_theme_header() {
        global $post;

        $on_front = get_option( 'show_on_front' );

        if ( ( ( $on_front == "post" && is_home() ) || ( $on_front == "page" && is_front_page() ) ) && ! is_paged() ) {
            // Homepage
            $output = apply_filters( 'digitalstore_brand_home', '<h1>%1$s</h1>' );
        } else {
            // Inner page
            $output = apply_filters( 'digitalstore_brand_inner', '<h1><a href="%2$s" title="%3$s">%1$s</a></h1>' );
        }

        $image = false;
        if ( function_exists('digitalstore_get_theme_options') ) {
            $options = digitalstore_get_theme_options();
            $image = ( $options['logo_image'] != '' ) ? $options['logo_image'] : false;
        }

        if ( $image !== false ) {
            $brand = sprintf( '<img src="%s" alt="%s"/>', $image, esc_attr( get_bloginfo( 'name' ) ) );
        } else {
            $brand = get_bloginfo( 'name' );
        }

        printf( $output, $brand, get_site_url(), esc_attr( get_bloginfo( 'name' ) ) );
    }
}
add_action( 'digitalstore_theme_brand', 'digitalstore_get_theme_header' );


/**
 * Exceprt Length
 *
 * Sets the post excerpt length to 40 words.
 *
 * @return   integer
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_excerpt_length' ) ) {
    function digitalstore_excerpt_length( $length ) {
        return 40;
    }
}


/**
 * Continue reading link
 *
 * Returns a "Continue Reading" link for excerpts.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_continue_reading_link' ) ) {
    function digitalstore_continue_reading_link() {
        global $post;

        if ( is_singular( 'download' ) )
        return;

        return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'edd-digitalstore' ) . '</a>';
    }
}


/**
 * Auto Excerpt More
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_auto_excerpt_more' ) ) {
    function digitalstore_auto_excerpt_more( $more ) {
        return ' &hellip;' . digitalstore_continue_reading_link();
    }
}


/**
 * Custom Excerpt More
 *
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_custom_excerpt_more' ) ) {
    function digitalstore_custom_excerpt_more( $output ) {
        if ( has_excerpt() && ! is_attachment() ) {
            $output .= digitalstore_continue_reading_link();
        }
        return $output;
    }
}


/**
 * Digital Store Thumbs Quality
 *
 * Increases the default quality of WordPress thumbnails.
 *
 * @return   integer
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_theme_thumbs_quality' ) ) {
    function digitalstore_theme_thumbs_quality() {
        return 99;
    }
}


/**
 * Digital Store Widgets Thumbs Size
 *
 * Sets a custom size for the EDD widgets pack.
 *
 * @return   array
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_edd_widgets_thumbnail_size' ) ) {
    function digitalstore_edd_widgets_thumbnail_size( $size ) {
        return array( '55', '55' );
    }
}


/**
 * Digital Store Widgets Single Thumbs Size
 *
 * Sets a custom size for the EDD widgets pack.
 *
 * @return   array
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_edd_widgets_single_thumbnail_size' ) ) {
    function digitalstore_edd_widgets_single_thumbnail_size( $size ) {
        return array( '155', '156' );
    }
}


/**
 * Digital Post Class
 *
 * Adds a custom class to posts with thumbnails.
 *
 * @return   array
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_post_class' ) ) {
    function digitalstore_post_class( $classes ) {
        global $post;
        if ( has_post_thumbnail() ) {
            $classes[] = 'has-post-thumbnail';
        }
        return $classes;
    }
}


/**
 * Posted On
 *
 * Generates the entry meta for posts on single view.
 *
 * @return   string
 * @access   public
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_posted_on' ) ) {
    function digitalstore_posted_on() {
        global $post;

        // Allow filtering
        $features = apply_filters( 'digitalstore_posted_on_features', array(
            'show_date' => 1,
            'show_author' => 1,
            'show_cats' => 0,
            'show_tags' => 0,
         ) );

        $out = "";

        if ( $features['show_date'] == 1 )
            $out .= '<time class="entry-date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'F j, Y' ) . '</time>';

        if ( $features['show_author'] == 1 ) {
            $out .= ( $out != "" ) ? ' ' : '';
            $url  = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
            $out .= __( 'by ', 'edd-digitalstore' );
            $out .= '<a href="' . $url . '" title="' . esc_attr__( 'View all posts by this author' , 'edd-digitalstore' ) . '" >' . get_the_author() . '</a>';
        }

        if ( $features['show_cats'] == 1 ) {
            $categories_list = get_the_category_list( __( ', ', 'edd-digitalstore' ) );
            if ( $categories_list ){
                $out .= ( $out != "" ) ? ' ' : '';
                $out .= __( 'under ', 'edd-digitalstore' ) . $categories_list;
            }
        }

        if ( $features['show_tags'] == 1 ) {
            $tag_list = get_the_tag_list( '', __( ', ', 'edd-digitalstore' ) );
            if ( $tag_list ) {
                $out .= ( $out != "" ) ? __( ', ', 'edd-digitalstore' ) : '';
                $out .= __( 'tagged: ', 'edd-digitalstore' ) . $tag_list;
            }
        }

        echo $out . '.';
    }
}


/**
 * Add Footer Credits
 *
 * Echoes the footer credits option.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_add_colophon_credits' ) ) {
    function digitalstore_add_colophon_credits() {
        $options = digitalstore_get_theme_options();
        echo $options['footer_text'];
    }
}


/**
 * Add to Cart Button
 *
 * Echoes the custom digital store add-to-cart button.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_add_to_cart_callback' ) ) {
    function digitalstore_add_to_cart_callback( $post ) {
        global $edd_options;

        $out = '<div class="button-group add-to-cart clearfix">';

        if ( ! edd_item_in_cart( $post->ID ) ) {
            $show_price = edd_has_variable_prices( $post->ID ) ? '' : ' price="0"';
            $out .= do_shortcode( '[purchase_link id="' . $post->ID . '"' . $show_price . ' text="' . esc_attr__( 'Add To Cart', 'edd-digitalstore' ) . '" style="text"]' );
        } else {
            $out .= '<a href="' . get_permalink( $edd_options['purchase_page'] ) . '" class="edd_go_to_checkout edd_button">' . __( 'Checkout', 'edd-digitalstore' ) . '</a>';
        }

        $out .= '<button class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu">';

        $title = urlencode( get_the_title( $post->ID ) );
        $permalink = urlencode( get_permalink( $post->ID ) );

        if ( ! edd_item_in_cart( $post->ID ) ) {
            $actions = array(
                'buy' => array(
                    'href' => '#addtocart',
                    'title' => sprintf( __( 'Buy %s', 'edd-digitalstore' ), $title ),
                    'text' => __( 'Buy this File', 'edd-digitalstore' ),
            ) );
        } else {
            $actions = array(
                'checkout' => array(
                    'href' => get_permalink( $edd_options['purchase_page'] ),
                    'title' => __( 'Checkout', 'edd-digitalstore' ),
                    'text' => __( 'Go to Checkout', 'edd-digitalstore' ),
            ) );
        }

        $filterable_actions = array(
            'twitter' => array(
                'href' => sprintf( 'http://twitter.com/home?status=%s', urlencode( sprintf( __( 'Check this out: %s', 'edd-digitalstore' ), $permalink ) ) ),
                'title' => sprintf( __( 'Share %s on Twitter', 'edd-digitalstore' ), $title ),
                'text' => __( 'Share on Twitter', 'edd-digitalstore' ),
            ),
            'googleplus' => array(
                'href' => sprintf( 'https://plus.google.com/share?url=%s', urlencode( $permalink ) ),
                'title' => sprintf( __( 'Add %s to Google Plus', 'edd-digitalstore' ), $title ),
                'text' => __( 'Add to Google+', 'edd-digitalstore' ),
            ),
            'facebook' => array(
                'href' => sprintf( 'http://www.facebook.com/sharer.php?u=%s&t=%s', urlencode( $permalink ), urlencode( __( 'Check this out', 'edd-digitalstore' ) ) ),
                'title' => sprintf( __( 'Share %s on Facebook', 'edd-digitalstore' ), $title ),
                'text' => __( 'Share on Facebook', 'edd-digitalstore' ),
            )
        );

        $actions = array_merge( $actions, apply_filters( 'digitalstore_add_to_cart_actions', $filterable_actions, $post, $title, $permalink ) );

        foreach ( $actions as $action ) {
            $out .= '<li><a href="' . $action['href'] . '" title="' . esc_attr( $action['title'] ) . '">' . $action['text'] . '</a></li>';
        }

        $out .= '</ul>';
        $out .= '</div>';

        echo $out;
    }
}


/**
 * Digital Store The Price
 *
 * Echoes the price with a custom format.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_edd_the_price' ) ) {
    function digitalstore_edd_the_price( $download_id ) {
        if ( edd_has_variable_prices( $download_id ) ) {
             $prices = get_post_meta( $download_id, 'edd_variable_prices', true );
             digitalstore_sort_prices_by( $prices, 'amount' );
             $total = count( $prices ) - 1;
             if ( $prices[0]['amount'] < $prices[$total]['amount'] ) {
                 $min = $prices[0]['amount'];
                 $max = $prices[$total]['amount'];
             } else {
                 $min = $prices[$total]['amount'];
                 $max = $prices[0]['amount'];
             }
             return sprintf( '%s - %s', edd_currency_filter( $min ), edd_currency_filter( $max ) );
         } else {
             return edd_currency_filter( edd_format_amount( edd_get_download_price( $download_id ) ) );
         }
    }
}


/**
 * Digital Store Sort Prices By
 *
 * @access      private
 * @since       1.0.2
 * @return      void
*/
if ( ! function_exists( 'digitalstore_sort_prices_by' ) ) {
    function digitalstore_sort_prices_by( &$arr, $col ) {
        $sort_col = array();
        foreach ( $arr as $key => $row ) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort( $sort_col, SORT_ASC, $arr );
    }
}


/**
 * Digital Store Browser Body Classes
 *
 * @access      private
 * @since       1.0.7
 * @return      array
*/
if ( ! function_exists( 'digitalstore_browser_body_class' ) ) {
    function digitalstore_browser_body_class( $classes ) {

        // A little Browser detection shall we?
        $browser = $_SERVER[ 'HTTP_USER_AGENT' ];

        // Mac, PC ...or Linux
        if ( preg_match( "/Mac/", $browser ) ){
            $classes[] = 'mac';

        } elseif ( preg_match( "/Windows/", $browser ) ){
            $classes[] = 'windows';

        } elseif ( preg_match( "/Linux/", $browser ) ) {
            $classes[] = 'linux';

        } else {
            $classes[] = 'unknown-os';
        }

        // Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
        if ( preg_match( "/Chrome/", $browser ) ) {
            $classes[] = 'chrome';

            preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches);

            if( empty( $matches ) )
                $matches = array('', '');

            $classesh_version = 'ch' . str_replace( '.', '-', $matches[1] );
            $classes[] = $classesh_version;

            } elseif ( preg_match( "/Safari/", $browser ) ) {
                $classes[] = 'safari';

                preg_match( "/Version\/(\d.\d)/si", $browser, $matches);
                $sf_version = 'sf' . str_replace( '.', '-', $matches[1] );
                $classes[] = $sf_version;

             } elseif ( preg_match( "/Opera/", $browser ) ) {
                $classes[] = 'opera';

                preg_match( "/Opera\/(\d.\d)/si", $browser, $matches);
                $op_version = 'op' . str_replace( '.', '-', $matches[1] );
                $classes[] = $op_version;

             } elseif ( preg_match( "/MSIE/", $browser ) ) {
                $classes[] = 'msie';

                if( preg_match( "/MSIE 6.0/", $browser ) ) {
                    $classes[] = 'ie6';
                } elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
                    $classes[] = 'ie7';
                } elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
                    $classes[] = 'ie8';
                } elseif ( preg_match( "/MSIE 9.0/", $browser ) ){
                    $classes[] = 'ie9';
                }

                } elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
                    $classes[] = 'firefox';

                    preg_match( "/Firefox\/(\d)/si", $browser, $matches);
                    $ff_version = 'ff' . str_replace( '.', '-', $matches[1] );
                    $classes[] = $ff_version;

                } else {
                    $classes[] = 'unknown-browser';
                }

        return $classes;
    }
}
add_filter('body_class','digitalstore_browser_body_class');


/**
 * Digital Store Theme Updater
 *
 * @access      private
 * @since       1.1
 * @return      void
*/

function digitalstore_theme_updater() {

    if ( !class_exists( 'EDD_SL_Theme_Updater' ) ) {
        // Load our custom theme updater
        include( dirname( __FILE__ ) . '/EDD_SL_Theme_Updater.php' );
    }

    $options = digitalstore_get_theme_options();

    $license = trim( $options['license_key'] );

    if( empty( $license ) )
        return;

    $edd_updater = new EDD_SL_Theme_Updater( array(
            'remote_api_url'    => EDD_DIGITAL_STORE_STORE_URL,
            'version'           => EDD_DIGITAL_STORE_VERSION,
            'license'           => $license,
            'item_name'         => EDD_DIGITAL_STORE_THEME_NAME,
            'author'            => 'Matt Varone and Pippin Williamson'
        )
    );
}
add_action( 'admin_init', 'digitalstore_theme_updater' );


/*
|--------------------------------------------------------------------------
| End of Functions.php
|--------------------------------------------------------------------------
*/

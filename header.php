<?php
/**
 * Header Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/
?><!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta name="viewport" content="width=device-width" />
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php bloginfo( 'name' ); ?> <?php wp_title(); ?></title>
    
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <?php wp_head(); ?>
    
</head>
<body <?php body_class(); ?>>
    
    <?php do_action( 'digitalstore_before_header' ); ?>
    
    <header id="masthead" class="clearfix" role="banner">
        
        <div id="branding">
            <?php do_action( 'digitalstore_theme_brand' ); ?>
        </div><!-- #branding -->
        
        <nav id="access" role="navigation">
            <?php            
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'container' => false,
                            'walker' => class_exists( 'DigitalStore_Walker_Nav_Menu' ) ? new DigitalStore_Walker_Nav_Menu : new Walker_Nav_Menu
                    ) );
                } else {
                    wp_page_menu();
                }
            ?>
        </nav><!-- #access -->
        
    </header><!-- #masterhead -->
    
    <?php do_action( 'digitalstore_after_header' ); ?>
    
    <div id="container">

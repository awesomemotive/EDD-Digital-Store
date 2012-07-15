<?php
/**
 * Footer Template
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

?>

    </div><!-- #container -->
    
    <?php do_action( 'digitalstore_before_complementary' ); ?>
    
    <?php get_sidebar( 'complementary' ); ?>
    
    <?php do_action( 'digitalstore_after_complementary' ); ?>
    
    <footer id="colophon" role="contentinfo">
        
        <div id="credits">
            <p><?php do_action( 'digitalstore_colophon_credits' ); ?></p>
        </div><!-- #credits -->
        
        <nav id="access-secondary" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'secondary' , 'container' => false ) ); ?>
        </nav><!-- #access-secondary -->
        
    </footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
<?php
/**
 * Complementary Widgets Area.
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/

if ( ! is_active_sidebar( 'complementary-widget-area' ) ) {
    return;
}

?>
<aside id="complementary" class="sidebar">
    
    <?php dynamic_sidebar( 'complementary-widget-area' ); ?>
    
</aside>
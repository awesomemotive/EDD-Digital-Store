<?php
/**
 * Search Form Partial
 *
 * @package      Digital Store
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/
?>

<form action="<?php echo site_url('/'); ?>" method="get" class="search-form" role="search">
    <fieldset>
        <label for="search"><?php _e( 'Search For', 'edd-digitalstore' ); ?></label>
        <input type="text" name="s" id="search" placeholder="<?php _e( 'Search this site', 'edd-digitalstore' ); ?>" value="<?php the_search_query(); ?>" />
        <input type="submit" class="button" name="submit" value="<?php _e( 'Search', 'edd-digitalstore' ) ?>" />
    </fieldset>
</form>
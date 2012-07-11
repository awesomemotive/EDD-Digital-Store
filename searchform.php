<?php
/**
 * Search Form Partial
 *
 * @package      Digital Store
 * @author       Matt Varone <contact@mattvarone.com>
 * @copyright    Copyright (c) 2012, Matt Varone
 * @link         http://www.mattvarone.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/
?>

<form action="<?php echo site_url('/'); ?>" method="get" class="search-form" role="search">
    <fieldset>
        <label for="search"><?php _e( 'Search For', 'digitalstore-mattvarone' ); ?></label>
        <input type="text" name="s" id="search" placeholder="<?php _e( 'Search this site', 'digitalstore-mattvarone' ); ?>" value="<?php the_search_query(); ?>" />
        <input type="submit" class="button" name="submit" value="<?php _e( 'Seach', 'digitalstore-mattvarone' ) ?>" />
    </fieldset>
</form>
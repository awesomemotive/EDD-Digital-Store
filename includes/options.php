<?php
/**
 * Theme Options
 *
 * @package      Digital Store
 * @subpackage   Options
 * @author       Easy Digital Downloads - http://easydigitaldownloads.com
 * @copyright    Copyright (c) 2012, Easy Digital Downloads
 * @link         http://www.easydigitaldownloads.com.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


/**
 * Theme Options Init
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_theme_options_init' ) ) {
    function digitalstore_theme_options_init() {
        register_setting( 'digitalstore_options', 'digitalstore_theme_options', 'digitalstore_theme_options_validate' );
        add_settings_section( 'display',  __( 'Display Options', 'edd-digitalstore' ), '__return_false', 'theme_options' );
        add_settings_section( 'branding',  __( 'Branding', 'edd-digitalstore' ), '__return_false', 'theme_options' );
        add_settings_field( 'logo_image', __( 'Logo Image', 'edd-digitalstore' ), 'digitalstore_settings_field_logo_image', 'theme_options', 'branding' );
        add_settings_field( 'theme_skin', __( 'Color Scheme', 'edd-digitalstore' ), 'digitalstore_settings_field_skin', 'theme_options', 'display' );
        add_settings_field( 'accent_color', __( 'Accent Color', 'edd-digitalstore' ), 'digitalstore_settings_field_accent_color', 'theme_options', 'display' );
        add_settings_field( 'footer_text', __( 'Footer Text', 'edd-digitalstore' ), 'digitalstore_settings_field_footer_text', 'theme_options', 'branding' );
        add_settings_field( 'license_key', __( 'License Key', 'edd-digitalstore' ), 'digitalstore_settings_field_license_key', 'theme_options', 'branding' );
    }
}
add_action( 'admin_init', 'digitalstore_theme_options_init' );


/**
 * Theme Option Page Capability
 *
 * @access      private
 * @since       1.0
 * @return      string
*/

if ( ! function_exists( 'digitalstore_option_page_capability' ) ) {
    function digitalstore_option_page_capability( $capability = "" ) {
        return 'edit_theme_options';
    }
}
add_filter( 'option_page_capability_digitalstore_options', 'digitalstore_option_page_capability' );


/**
 * Theme Options Add Page
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_theme_options_add_page' ) ) {
    function digitalstore_theme_options_add_page() {
        $page = add_theme_page( __( 'Theme Options', 'edd-digitalstore' ), __( 'Options', 'edd-digitalstore' ), 'edit_theme_options', 'theme_options', 'digitalstore_theme_options_render_page' );
        add_action( "load-$page", 'digitalstore_options_take_action', 49 );
        add_filter( 'attachment_fields_to_edit', 'digitalstore_attachment_fields_to_edit', 10, 2 );
		add_filter( 'media_upload_tabs', 'digitalstore_options_filter_upload_tabs' );
    }
}
add_action( 'admin_menu', 'digitalstore_theme_options_add_page' );


/**
 * Admin Enqueue Scripts
 *
 * Properly enqueue styles and scripts for our theme options page.
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_admin_enqueue_scripts' ) ) {
    function digitalstore_admin_enqueue_scripts( $hook_suffix ) {
        wp_enqueue_style( 'digitalstore-theme-options', get_template_directory_uri() . '/includes/options/digitalstore.theme.options.css', false );
        wp_enqueue_script( 'digitalstore-theme-options', get_template_directory_uri() . '/includes/options/digitalstore.theme.options.js', array( 'farbtastic', 'thickbox' ) );
        add_thickbox();
		wp_enqueue_style( 'farbtastic' );
    }
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'digitalstore_admin_enqueue_scripts' );


/**
 * Options Take Action
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_options_take_action' ) ) {
    function digitalstore_options_take_action() {

        if ( empty($_POST) )
			return;

		if ( isset($_POST['digitalstore-remove-logo-image']) && isset($_POST['action']) && $_POST['action'] == 'update' ) {
			check_admin_referer('custom-logo-image-remove', '_wpnonce-logo-image-remove');
		    digitalstore_theme_update_logo_image();
			wp_safe_redirect( $_POST['_wp_http_referer'] );
			return;
		}
    }
}
add_action( 'admin_init', 'digitalstore_options_take_action' );


/**
 * Options Handle Upload
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_options_handle_upload' ) ) {
    function digitalstore_options_handle_upload() {

        if ( empty( $_FILES ) )
			return;

        if ( isset($_POST['digitalstore-upload-logo-image']) && isset($_POST['action']) && $_POST['action'] == 'update' ) {

    		check_admin_referer( 'digitalstore-custom-logo-image-upload', '_wpnonce-custom-logo-image-upload' );

    		$overrides = array( 'test_form' => false );
    		$file = wp_handle_upload( $_FILES['import'], $overrides );

         	if ( isset( $file['error'] ) )
    			wp_die( $file['error'] );

    		$url = $file['url'];
    		$type = $file['type'];
    		$file = $file['file'];
    		$filename = basename( $file );

    		// Construct the object array
    		$object = array(
    			'post_title' => $filename,
    			'post_content' => $url,
    			'post_mime_type' => $type,
    			'guid' => $url,
    			'context' => 'custom-background'
    		 );

    		// Save the data
    		$id = wp_insert_attachment( $object, $file );

    		// Add the meta-data
    		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );
    		digitalstore_theme_update_logo_image( $url );

	    }

    }

}
add_action( 'admin_init', 'digitalstore_options_handle_upload' );


/**
 * Options Filter Upload Tabs
 *
 * @access      private
 * @since       1.0
 * @return      array
*/

if ( ! function_exists( 'digitalstore_options_filter_upload_tabs' ) ) {
    function digitalstore_options_filter_upload_tabs( $tabs ) {
        if ( isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'custom-logo-image' )
			return array( 'library' => __( 'Media Library', 'edd-digitalstore' ) );

		return $tabs;
    }
}


/**
 * Attachment Fields To Edit
 *
 * @access      private
 * @since       1.0
 * @return      array
*/

if ( ! function_exists( 'digitalstore_attachment_fields_to_edit' ) ) {
    function digitalstore_attachment_fields_to_edit( $form_fields, $post ) {
    	if ( isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'custom-logo-image' ) {
    		$form_fields = array( 'image-size' => $form_fields['image-size'] );
    		$form_fields['buttons'] = array( 'tr' => '<tr class="submit"><td></td><td><a data-attachment-id="' . $post->ID . '" class="wp-set-logo-image" href="#">' . __( 'Set as logo', 'edd-digitalstore' ) . '</a></td></tr>' );
    		$form_fields['context'] = array( 'input' => 'hidden', 'value' => 'custom-logo-image' );
    	}

    	return $form_fields;
    }
}


/**
 * Get The Theme Options
 *
 * @access      public
 * @since       1.0
 * @return      array
*/

if ( ! function_exists( 'digitalstore_get_theme_options' ) ) {
    function digitalstore_get_theme_options() {
        $saved = ( array ) get_option( 'digitalstore_theme_options' );

        $defaults = apply_filters( 'digitalstore_default_theme_options', array(
            'logo_image' => '',
            'footer_text' => sprintf( '<strong>EDD Digital Store</strong> %s <a href="http://easydigitaldownloads.com">Easy Digital Downloads</a>.', __( 'by' , 'edd-digitalstore' ) ),
            'theme_skin' => 'light',
            'accent_color' => digitalstore_get_default_accent_color( 'light' ),
            'license_key' => '',
         ) );

        $options = wp_parse_args( $saved, $defaults );
        $options = array_intersect_key( $options, $defaults );
        if ( $options['logo_image'] == 'removed' ) {
            $options['logo_image'] = '';
            delete_option( 'digitalstore_theme_options' );
            add_option( 'digitalstore_theme_options', $options );
        }
        return $options;
    }
}


/**
 * Theme Update Image Logo
 *
 * @access      public
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_theme_update_logo_image' ) ) {
    function digitalstore_theme_update_logo_image( $value = "" ) {
        $options = digitalstore_get_theme_options();
        $options['logo_image'] =  ( $value ) ? esc_url( $value ) : '';
        delete_option( 'digitalstore_theme_options' );
        add_option( 'digitalstore_theme_options', $options );
    }
}


/**
 * Theme Skin Options
 *
 * @access      public
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_theme_skin_options' ) ) {
    function digitalstore_theme_skin_options() {
        $options = array(
            'light' => __( 'Light', 'edd' ),
            'dark'  => __( 'Dark', 'edd' ),
        );
        return apply_filters( 'digitalstore_theme_skin_options_array', $options );
    }
}


/**
 * Theme Accent Color
 *
 * @access      public
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_get_default_accent_color' ) ) {
    function digitalstore_get_default_accent_color( $skin ) {
        $defaults = apply_filters( 'digitalstore_default_accent_colors', array(
            'light' => '3c9be3',
            'dark'  => '3c9be3'
        ) );
        if ( array_key_exists( $skin, $defaults ) ) {
            return $defaults[$skin];
        } else {
            return '3c9be3';
        }
    }
}


/**
 * Theme Options Render Page
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_theme_options_render_page' ) ) {
    function digitalstore_theme_options_render_page() {
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php printf( __( '%s Theme Options', 'edd-digitalstore' ), wp_get_theme() ); ?></h2>
            <?php settings_errors(); ?>

            <form method="post" action="options.php" class="digitalstore-options-form" enctype="multipart/form-data">
                <?php
                    settings_fields( 'digitalstore_options' );
                    do_settings_sections( 'theme_options' );
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}


/**
 * Theme Options Validate
 *
 * @access      private
 * @since       1.0
 * @return      array
*/

if ( ! function_exists( 'digitalstore_theme_options_validate' ) ) {
    function digitalstore_theme_options_validate( $input ) {
        $output = $defaults = digitalstore_get_theme_options();

        if ( isset( $input['logo_image'] ) && ! empty( $input['logo_image'] ) )
            $output['logo_image'] = stripslashes_deep( $input['logo_image'] );

        if ( isset( $input['theme_skin'] ) && array_key_exists( $input['theme_skin'], digitalstore_theme_skin_options() ) )
            $output['theme_skin'] = stripslashes_deep( $input['theme_skin'] );

        $output['accent_color'] = $defaults['accent_color'] = digitalstore_get_default_accent_color( $output['theme_skin'] );

        if ( isset( $input['accent_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['accent_color'] ) )
            $output['accent_color'] = strtolower( ltrim( $input['accent_color'], '#' ) );

        if ( isset( $input['footer_text'] ) && ! empty( $input['footer_text'] ) )
            $output['footer_text'] = stripslashes_deep( $input['footer_text'] );

        if ( isset( $input['license_key'] ) && ! empty( $input['license_key'] ) )
            $output['license_key'] = stripslashes_deep( trim( $input['license_key'] ) );

        return apply_filters( 'digitalstore_theme_options_validate',  $output, $input, $defaults );
    }
}


/**
 * Settings Field Logo Image
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_settings_field_logo_image' ) ) {
    function digitalstore_settings_field_logo_image() {
        $options = digitalstore_get_theme_options();
        ?>

        <?php if ( isset( $options['logo_image'] ) && $options['logo_image'] != "" ): ?>
            <img class="digitalstore-image-logo" src="<?php echo $options['logo_image']; ?>" alt="<?php esc_attr_e( 'Logo Image', 'edd-digitalstore' ); ?>"/>
            <br/>
            <?php wp_nonce_field( 'custom-logo-image-remove', '_wpnonce-logo-image-remove' ); ?>
            <?php submit_button( __( 'Remove Logo Image', 'edd-digitalstore' ), 'delete', 'digitalstore-remove-logo-image', false ); ?><br/>
            <p class="description"><?php _e( 'This will remove the logo image.', 'edd-digitalstore' ) ?></p>
            <br/>
        <?php endif; ?>

        <div id="upload-form">
            <label for="upload"><?php _e( 'Choose an image from your computer:', 'edd-digitalstore' ); ?></label>
            <br/>
            <input type="file" id="upload" name="import" />
            <?php wp_nonce_field( 'digitalstore-custom-logo-image-upload', '_wpnonce-custom-logo-image-upload' ); ?>
            <?php submit_button( __( 'Upload', 'edd-digitalstore' ), 'button', 'digitalstore-upload-logo-image', false ); ?>
            <?php
                $image_library_url = get_upload_iframe_src( 'image', null, 'library' );
        	    $image_library_url = remove_query_arg( 'TB_iframe', $image_library_url );
        	    $image_library_url = add_query_arg( array( 'context' => 'custom-logo-image', 'TB_iframe' => 1 ), $image_library_url );
            ?>
            <span class="howto">or</span>
            <a class="thickbox" href="<?php echo $image_library_url; ?>"><?php _e( 'Choose from image library', 'edd-digitalstore' ); ?></a>
        </div>
        <?php
    }
}


/**
 * Settings Field Theme Skin
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_settings_field_skin' ) ) {
    function digitalstore_settings_field_skin() {
        $options = digitalstore_get_theme_options();
        ?>
        <select name="digitalstore_theme_options[theme_skin]" id="theme-skin">
            <?php
                $stored = $options['theme_skin'];
                foreach ( digitalstore_theme_skin_options() as $value => $label ) {
                    $selected = ( $stored === $value ) ? ' selected="selected" ' : '';
                    printf( '<option value="%s" data-default-color="%s"%s>%s</option>',
                        esc_attr( $value ),
                        digitalstore_get_default_accent_color( $value ),
                        $selected,
                        $label
                    );
                }
            ?>
        </select>
        <label class="description" for="digitalstore_theme_options[theme_skin]"><?php _e( 'Select the theme color scheme', 'edd-digitalstore' ); ?>.</label>
        <?php
    }
}


/**
 * Settings Field Acccent Color
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_settings_field_accent_color' ) ) {
    function digitalstore_settings_field_accent_color() {
        $options = digitalstore_get_theme_options();
        ?>
        <input type="text" name="digitalstore_theme_options[accent_color]" id="accent-color" value="<?php echo '#' . esc_attr( $options['accent_color'] ); ?>" />
        <a href="#" class="pickcolor hide-if-no-js" id="accent-color-example"></a>
        <input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'edd-digitalstore' ); ?>" />
        <div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
        <br />
        <span><?php printf( __( 'Default color: %s', 'edd-digitalstore' ), '<span id="default-color">' . digitalstore_get_default_accent_color( $options['theme_skin'] ) . '</span>' ); ?></span>
        <?php
    }
}


/**
 * Settings Field Footer Text
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_settings_field_footer_text' ) ) {
    function digitalstore_settings_field_footer_text() {

        $options = digitalstore_get_theme_options(); ?>

        <?php if ( function_exists( 'wp_editor' ) ): ?>
            <?php wp_editor( $options['footer_text'], 'digitalstore_theme_options[footer_text]', array( 'textarea_rows' => 4, 'teeny' => true ) ); ?>
        <?php else: ?>
            <textarea class="large-text" name="digitalstore_theme_options[footer_text]" id="footer-text" cols="50" rows="4"><?php echo esc_textarea( $options['footer_text'] ); ?></textarea>
        <?php endif ?>

        <label class="description" for="sample-text-input"><?php _e( 'The footer bottom left text', 'edd-digitalstore' ); ?>.</label>
        <?php
    }
}


/**
 * Settings Field License Key
 *
 * @access      private
 * @since       1.1
 * @return      void
*/

if ( ! function_exists( 'digitalstore_settings_field_license_key' ) ) {
    function digitalstore_settings_field_license_key() {

        $options = digitalstore_get_theme_options(); ?>
        <input class="regular-text" type="text" name="digitalstore_theme_options[license_key]" id="license-text" value="<?php echo esc_textarea( $options['license_key'] ); ?>"/>
        <label class="description" for="sample-text-input"><?php _e( 'Theme license key for automatic updatess', 'edd-digitalstore' ); ?>.</label>
        <?php
    }
}


/**
 * Ajax Set Logo Image
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

if ( ! function_exists( 'digitalstore_ajax_set_logo_image' ) ) {
    function digitalstore_ajax_set_logo_image() {
		if ( ! current_user_can( digitalstore_option_page_capability() ) || ! isset( $_POST['attachment_id'] ) ) exit;

		$attachment_id = absint( $_POST['attachment_id'] );

		$sizes = array_keys( apply_filters( 'image_size_names_choose', array( 'thumbnail' => __( 'Thumbnail' ), 'medium' => __( 'Medium' ), 'large' => __( 'Large' ), 'full' => __( 'Full Size' ) ) ) );
		$size = 'thumbnail';
		if ( in_array( $_POST['size'], $sizes ) )
			$size = esc_attr( $_POST['size'] );

		$url = wp_get_attachment_image_src( $attachment_id, $size );
		$thumbnail = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );

		digitalstore_theme_update_logo_image( esc_url( $url[0] ) );

		exit;
    }
}
add_action( 'wp_ajax_digital-store-set-logo-image', 'digitalstore_ajax_set_logo_image' );


/**
 * Media Uploader JS
 *
 * Prints custom JS for the media uploader.
 *
 * @return   void
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_media_uploader_js' ) ) {
    function digitalstore_media_uploader_js() {
        if ( isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'custom-logo-image' ) {
            ?>
            <script type="text/javascript" charset="utf-8">
               jQuery(function($) {
                   console.log('aaa');
                    $( 'body' ).bind( 'click.wp-gallery', function(e){
                        var target = $( e.target ), id, img_size;

                        if ( target.hasClass( 'wp-set-logo-image' ) ) {
                            e.preventDefault();
                			id = target.data( 'attachment-id' );
                			img_size = $( 'input[name="attachments[' + id + '][image-size]"]:checked').val();

                			$.post(ajaxurl, {
                				action: 'digital-store-set-logo-image',
                				attachment_id: id,
                				size: img_size
                			}, function(){
                				var win = window.dialogArguments || opener || parent || top;
                				win.tb_remove();
                				win.location.reload();
                			});

                			e.preventDefault();
                		}
                    });
                });
            </script>
            <?php
        }
    }
}
add_action( 'admin_head', 'digitalstore_media_uploader_js' );


/**
 * Enqueue Theme Skin
 *
 * Enqueues the css skin if necessary.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_print_theme_skin' ) ) {
    function digitalstore_print_theme_skin() {
        $options = digitalstore_get_theme_options();
        if ( $options['theme_skin'] != 'light' ) {
            wp_enqueue_style( 'digitalstore-theme-' . $options['theme_skin'], get_stylesheet_directory_uri() . '/css/' . $options['theme_skin'] .'.css', array( 'style' ) );
            do_action( 'digitalstore_enqueue_theme_skin', $options['theme_skin'] );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'digitalstore_print_theme_skin' );


/**
 * Print Accent Color
 *
 * Prints theme accent color.
 *
 * @return   string
 * @access   private
 * @since    1.0
*/

if ( ! function_exists( 'digitalstore_print_theme_accent' ) ) {
    function digitalstore_print_theme_accent() {
        $options = digitalstore_get_theme_options();

        if ( $options['accent_color'] === digitalstore_get_default_accent_color( $options['theme_skin'] ) )
        return;

        ?>

        <style type="text/css" media="screen">
            #masthead a, #container a, #colophon a, #branding h1 a:hover, #access li a:hover, #access ul li:hover a, #access ul li:hover li a:hover, #access .digitalstore-checkout a:hover, #access-secondary a:hover, .entry-utility a:hover, .type-post .entry-meta a:hover, .breadcrumbs a:hover, .view-all:hover, #comments a:hover, .latest-add-to-cart:hover, #colophon #credits a:hover, .entry-content a:hover, .widget a:hover,  .related-entry-title:hover, .related-entry-title, .display-listing h3 a:hover, .display-listing h4 a:hover, .downloads-meta h5 a:hover, h2.entry-title a:hover, #complementary ul.menu li a { color: #<?php echo $options['accent_color']; ?>!important }
            body, #masthead a, #container a, #colophon a, .entry-add-to-cart, a.edd-remove-from-cart, a.widget-download-title:hover, .entry-content a:hover, .widget a:hover, #access-secondary a:hover, .entry-utility a:hover, .type-post .entry-meta a:hover, .breadcrumbs a:hover, .view-all:hover, #comments a:hover, .latest-add-to-cart:hover, #colophon #credits a:hover, .digitalstore-pagination a:hover, #complementary ul.menu li a:hover { border-color: #<?php echo $options['accent_color']; ?> }
        </style>
        <?php
    }
}
add_action( 'wp_head', 'digitalstore_print_theme_accent' );


/**
 * Digital Store Theme License
 *
 * @access      private
 * @since       1.1
 * @return      void
*/
function digitalstore_activate_license() {

    if( isset( $_POST['digitalstore_theme_options'] ) ) {

        if( isset( $_POST['digitalstore_theme_options']['license_key'] ) )
            $key = trim( $_POST['digitalstore_theme_options']['license_key'] );
        else
            return;

        if( get_option('digitalstore_license_key_status') == 'valid' )
            return; // License already activated

        $api_params = array(
            'edd_action' => 'activate_license',
            'license'    => $key,
            'item_name'  => urlencode( EDD_DIGITAL_STORE_THEME_NAME )
        );

        $response = wp_remote_get( add_query_arg( $api_params, EDD_DIGITAL_STORE_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

        if ( is_wp_error( $response ) )
            return false;

        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

        update_option( 'digitalstore_license_key_status', $license_data->license );

    }
}
add_action( 'admin_init', 'digitalstore_activate_license' );
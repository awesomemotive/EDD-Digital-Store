<?php
/**
 * Digital Store Customize Controls
 *
 * Adds control inputs to the theme customize feature.
 * 
 * @package      Digital Store
 * @author       Matt Varone <contact@mattvarone.com>
 * @copyright    Copyright (c) 2012, Matt Varone
 * @link         http://www.mattvarone.com
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0
*/


if ( ! class_exists( 'DigitalStore_WP_Customize_Textarea_Control' ) ) {
    
    class DigitalStore_WP_Customize_Textarea_Control extends WP_Customize_Control {
    	public $type = 'textarea';

    	public function render_content() {
    		?>
    		<label>
    			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    			<textarea style="width: 100%;" rows="5" <?php $this->link(); ?>><?php echo esc_attr( $this->value() ); ?></textarea>
    		</label>
    		<?php
    	}
    }    
}


if ( ! class_exists( 'DigitalStore_WP_Customize_Logo_Image_Control' ) ) {
    
    class DigitalStore_WP_Customize_Logo_Image_Control extends WP_Customize_Image_Control {
    	
    	public function __construct( $manager ) {
    		parent::__construct( $manager, 'digitalstore_theme_options[logo_image]', array( 
    			'label'    => __( 'Logo Image' ), 
    			'section'  => 'strings', 
    			'context'  => 'custom-logo-image', 
    			'removed'  => 'removed', 
    			'statuses' => array( 
    			    '' => __( 'No Image', 'edd-digitalstore' ),
    			    'removed' => __( 'Removed', 'edd-digitalstore' )
    			)
    		 ) );
    	}

    }    
}
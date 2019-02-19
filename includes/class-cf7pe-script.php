<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package Contact Form 7 - PayPal Extension
 * @since 2.4
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Cf7pe_Script {
	
    function __construct() {

        // Action to add style and js at front side
        add_action( 'wp_enqueue_scripts',    array( &$this, 'cf7pe_front_style_js') );

        // Action to add style and js in backend
        add_action( 'admin_enqueue_scripts', array( &$this, 'cf7pe_admin_style_js') );

    }


    /**
     * Function to add style AND js at front side
     * 
     * @package Contact Form 7 - PayPal Extension
     * @since 2.4
     */
    function cf7pe_front_style_js( ) {

        // Registring and enqueing cf7pe paypal front css
        if ( !wp_style_is( 'cf7pe-paypal-front-style', 'registered' ) ) {
            wp_register_style( 'cf7pe-paypal-front-style', CF7PE_URL.'assets/css/cf7pe-paypal-front-style.css',  CF7PE_VERSION );               
            wp_enqueue_style( 'cf7pe-paypal-front-style' );
        }
        
        // Registring and enqueing cf7pe paypal front js
        if ( !wp_script_is( 'cf7pe-paypal-front', 'registered' ) ) {
            wp_register_script( 'cf7pe-paypal-front', CF7PE_URL. 'assets/js/cf7pe-paypal-front.js', CF7PE_VERSION, true);
            wp_enqueue_script( 'cf7pe-paypal-front' );
        }

    }

    /**
     * Enqueue admin style and Js
     * 
     * @package Contact Form 7 - PayPal Extension
     * @since 2.4
     */
    function cf7pe_admin_style_js( $hook ) {

        $pages_array = array( 'toplevel_page_wpcf7' ) ;
       
        // check if contact form 7 page
        if ( in_array( $hook, $pages_array ) ) {
          
            // Registring admin style
            if ( !wp_style_is( 'cf7pe-paypal-admin-style', 'registered' ) ) {
                wp_register_style( 'cf7pe-paypal-admin-style', CF7PE_URL.'assets/css/cf7pe-paypal-admin-style.css',false,  CF7PE_VERSION );       
                wp_enqueue_style( 'cf7pe-paypal-admin-style' ); 
            }
            
             // Registering and enque the admin js
            if ( !wp_script_is( 'cf7pe-paypal-admin', 'registered' ) ) {
                wp_register_script( 'cf7pe-paypal-admin', CF7PE_URL . 'assets/js/cf7pe-paypal-admin.js', null, CF7PE_VERSION, true );
                wp_enqueue_script( 'cf7pe-paypal-admin' );
            }
        }
    }


}

$cf7pe_script = new Cf7pe_Script( );
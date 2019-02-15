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

        // Action to add style at front side
        add_action( 'wp_enqueue_scripts', array($this, 'cf7pe_front_style') );

        // Action to add script at front side
        add_action( 'wp_enqueue_scripts', array($this, 'cf7pe_front_script') );

        // Action to add style in backend
        add_action( 'admin_enqueue_scripts', array($this, 'cf7pe_admin_style') );

        // Action to add script at admin side
        add_action( 'admin_enqueue_scripts', array($this, 'cf7pe_admin_script') );

    }


    /**
     * Function to add style at front side
     * 
     * @package Contact Form 7 - PayPal Extension
     * @since 2.4
     */
    function cf7pe_front_style() {

        // Registring and enqueing cf7 paypal front css
        if( !wp_style_is( 'cf7-paypal-front-style', 'registered' ) ) {
                wp_register_style( 'cf7-paypal-front-style', CF7PE_URL.'assets/css/cf7-paypal-front-style.css',  CF7PE_VERSION );
                wp_enqueue_style( 'cf7-paypal-front-style' );
        }

    }

    /**
     * Function to add script at front side
     * 
     * @package Contact Form 7 - PayPal Extension
     * @since 2.4
     */
    function cf7pe_front_script() {

        // Registring front js 
        if( !wp_script_is( 'cf7-paypal-front', 'registered' ) ) {
                wp_register_script( 'cf7-paypal-front', CF7PE_URL. 'assets/js/cf7-paypal-front.js', CF7PE_VERSION, true);
                wp_enqueue_script( 'cf7-paypal-front' );
        }
        
    }

    /**
     * Enqueue admin styles
     * 
     * @package Contact Form 7 - PayPal Extension
     * @since 2.4
     */
    function cf7pe_admin_style( $hook ) {

        $pages_array=array('toplevel_page_wpcf7') ;
       
        // check if contact form 7 page
        if( in_array($hook, $pages_array) ) {
          
            // Registring admin style
            wp_register_style( 'cf7-paypal-admin-style', CF7PE_URL.'assets/css/cf7-paypal-admin-style.css',false,  CF7PE_VERSION );       
            wp_enqueue_style( 'cf7-paypal-admin-style' );  
        }
    }


    /**
     * Function to add script at admin side
     * 
     * @package Contact Form 7 - PayPal Extension
     * @since 2.4
     */
    function cf7pe_admin_script( $hook ) {

         $pages_array=array('toplevel_page_wpcf7') ;
         
        // check if contact form 7 page
         if( in_array($hook, $pages_array) ) {
             
             // Registering and enque the admin js
            wp_register_script( 'cf7-paypal-admin', CF7PE_URL . 'assets/js/cf7-paypal-admin.js', null, CF7PE_VERSION, true );
            wp_enqueue_script( 'cf7-paypal-admin' );
         }
       
    }

}

$cf7pe_script = new Cf7pe_Script();
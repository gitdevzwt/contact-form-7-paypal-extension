<?php
/**
 * Contat form 7 Paypal button
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Contact Form 7 - PayPal Extension
 * @since 2.4
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Cf7pe_Shortcodes {

    function __construct() {
            
         
         // Change form url
         add_filter( 'wpcf7_form_action_url', array($this, 'cf7pe_paypal_form_url') ); 
         
         //Add required hidden fields
         add_action( 'wpcf7_contact_form', array($this, 'cf7pe_contact_form_content') ); 
        
                
    }
    
    
    /**
    * Function to change paypal form action url
    * 
    * @package Contact Form 7 - PayPal Extension
    * @since 2.4
    */    
    function cf7pe_paypal_form_url($url)
    {
        $wpcf7 = WPCF7_ContactForm::get_current();
        $currentformid= $wpcf7->id;
        $use_paypal = get_post_meta($currentformid, "_cf7paypal_use_paypal", true);          
     
        if($use_paypal==1)
        {
            $use_sandbox_paypal = get_post_meta($currentformid, "_cf7paypal_use_sandbox", true);
            if($use_sandbox_paypal==1) $url="https://www.sandbox.paypal.com/cgi-bin/webscr";
            else $url="https://www.paypal.com/cgi-bin/webscr";
            
        }
        return $url;
       
    }
    
    /**
    * Function to add required fields to the form
    * 
    * @package Contact Form 7 - PayPal Extension
    * @since 2.4
    */    
    function cf7pe_contact_form_content( $instance ) { 
       
       global $pagenow;
       $currentformid= $instance->id;
       $formcontent="";
             
       $buss_email_paypal = get_post_meta($currentformid, "_cf7paypal_buss_email", true);
       $currency_paypal = get_post_meta($currentformid, "_cf7paypal_currency", true);
       $item_amount_paypal = get_post_meta($currentformid, "_cf7paypal_item_amount", true);
       $item_name_paypal = get_post_meta($currentformid, "_cf7paypal_item_name", true);
       $item_qty_paypal = get_post_meta($currentformid, "_cf7paypal_item_qty", true);
       $success_url_paypal = get_post_meta($currentformid, "_cf7paypal_success_url", true);
       $cancel_url_paypal = get_post_meta($currentformid, "_cf7paypal_cancel_url", true);
            
       $formcontent=$instance->form;
       $token = md5(uniqid(rand(), true));
       if($pagenow!="admin.php")
       {
            $form = $formcontent.""
                   . "[hidden cmd '_xclick']
                      [hidden rm '2']
                      [hidden custom '{$token}']
                      [hidden business '{$buss_email_paypal}']
                      [hidden item_name '']
                      [hidden item_number '']
                      [hidden quantity '']
                      [hidden amount '']
                      [hidden no_shipping '0']
                      [hidden no_note '1']
                      [hidden currency_code '{$currency_paypal}']
                      [hidden lc 'AU']
                      [hidden return '{$success_url_paypal}']
                      [hidden cancel '{$cancel_url_paypal}']
                      [hidden item_name_field '{$item_name_paypal}']
                      [hidden item_number_field '{$item_qty_paypal}']
                      [hidden quantity_field '{$item_qty_paypal}']    
                      [hidden amount_field '{$item_amount_paypal}']
                          
                      ";

            $instance->set_properties( array(
                     'form'   => $form,

             ) );       
       }
    } 
 
 
}


$csfe_shortcode=new Cf7pe_Shortcodes();



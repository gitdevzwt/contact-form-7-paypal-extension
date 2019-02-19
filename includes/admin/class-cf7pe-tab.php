<?php
/**
 * Contact form 7 tab generator Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Contact Form 7 - PayPal Extension
 * @since 2.4
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Cf7pe_Admin {

    function __construct() {
            
       
        // Admin Init Processes
         add_action( 'admin_init',                            array( &$this, 'cf7pe_admin_init_process')               );
         
         // Add Paypal tab
         add_filter( 'wpcf7_editor_panels',                   array( &$this, 'cf7pe_admin_editor_pannels')             );
         
         // Paypal tab content
         add_action( 'wpcf7_admin_after_additional_settings', array( &$this, 'cf7pe_after_additional_settings')        );
         
         // Save paypal settings
         add_action( 'wpcf7_after_save',                      array( &$this, 'cf7pe_save_paypal_settings')             );
                
    }

    /**
    * Admin prior processes
    *
    * @package Contact Form 7 - PayPal Extension
    * @since 2.4
    */
    function cf7pe_admin_init_process( ) {

        // If plugin notice is dismissed
        if ( 
                 isset( $_GET['message'] ) 
              && $_GET['message'] == 'cf7pe-plugin-notice' 
            ) {
                set_transient( 'cf7pe_install_notice', true, 604800 );
        }
    }
    
    /**
    * Add new tab after additional settings
    *
    * @package Contact Form 7 - PayPal Extension
    * @since 2.4
    */
    function cf7pe_admin_editor_pannels ( $panels ) 
    {	
        $new_page = array(
                            'paypal' => array(
                                                 'title' => __( 'Paypal', 'contact-form-7' ),
                                                 'callback' => array( &$this, 'wpcf7_paypal_after_additional_settings' )
                                             )
                        );	
        $panels = array_merge( $panels, $new_page );	
        return $panels;	
    }

    /**
    * Paypal tab content/setting
    *
    * @package Contact Form 7 - PayPal Extension
    * @since 2.4
    */
    function cf7pe_after_additional_settings( $cf7 ) 
    {		

        $currency = array(
                    'AUD' => 'Australian Dollar',
                    'BRL' => 'Brazilian Real',
                    'CAD' => 'Canadian Dollar',
                    'CZK' => 'Czech Koruna',
                    'DKK' => 'Danish Krone',
                    'EUR' => 'Euro',
                    'HKD' => 'Hong Kong Dollar',
                    'HUF' => 'Hungarian Forint',
                    'ILS' => 'Israeli New Sheqel',
                    'JPY' => 'Japanese Yen',
                    'MYR' => 'Malaysian Ringgit',
                    'MXN' => 'Mexican Peso',
                    'NOK' => 'Norwegian Krone',
                    'NZD' => 'New Zealand Dollar',
                    'PHP' => 'Philippine Peso',
                    'PLN' => 'Polish Zloty',
                    'GBP' => 'Pound Sterling',
                    'RUB' => 'Russian Ruble',
                    'SGD' => 'Singapore Dollar', 
                    'SEK' => 'Swedish Krona',
                    'CHF' => 'Swiss Franc',
                    'TWD' => 'Taiwan New Dollar',
                    'THB' => 'Thai Baht',
                    'TRY' => 'Turkish Lira',
                    'USD' => 'U.S. Dollar' ); 
        
        $currentformid = sanitize_text_field( $_GET['post'] );	
       
	$buss_email_paypal  = get_post_meta( $currentformid, '_cf7paypal_buss_email', true  );
        
        $currency_paypal    = get_post_meta( $currentformid, '_cf7paypal_currency', true    );
        if( $currency_paypal == '' ) 
            $currency_paypal = 'USD'; // check if currency is blank then set default currency USD
        
        $use_sandbox_paypal = get_post_meta( $currentformid, '_cf7paypal_use_sandbox', true );
        $use_sandbox_paypal_checked='';
        if( $use_sandbox_paypal == 1 ) 
            $use_sandbox_paypal_checked='checked'; // check if value is true then checked the checkbox
        
        $use_paypal         = get_post_meta( $currentformid, '_cf7paypal_use_paypal', true  );
        $use_paypal_checked='';
        if( $use_paypal == 1 ) 
            $use_paypal_checked = 'checked'; // check if value is true then checked the checkbox
        
        
        $item_amount_paypal = get_post_meta( $currentformid, '_cf7paypal_item_amount', true );
        $item_name_paypal   = get_post_meta( $currentformid, '_cf7paypal_item_name', true   );
        $item_qty_paypal    = get_post_meta( $currentformid, '_cf7paypal_item_qty', true    );
        $success_url_paypal = get_post_meta( $currentformid, '_cf7paypal_success_url', true );
        $cancel_url_paypal  = get_post_meta( $currentformid, '_cf7paypal_cancel_url', true  );
        
        
        $html="";

        $html .=" <div class='control-box'>
        <fieldset>
            <b class='error'>". _e('NOTE:- <br> 1. If required fields are missing, PayPal Submit button works as simple Submit button.<br> 2. Please don\'t use following field names in contact form <a href="https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#individual-items-variables">https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#individual-items-variables </a><br> 3. If you want to send payment details then add <b>[paypal-details]</b> shortcode in your email body. ','contact-form-7-paypal-extension')."</b>
            <table class='form-table paypalform'>
                <tr>
                    <td colspan='2'>
                        <a href='http://www.zealousweb.com/wordpress-plugins/shop/' target='_blank'>
                            <img src='".CF7PE_URL."/assets/images/cf7pn.jpg' width='540'>
                        </a>
                    </td>
                </tr>
                <tr>
                 
                    <td>".esc_html( __( 'PayPal Business E-Mail', 'contact-form-7' ) )."<font style='font-size:10px'> (".esc_html( __('required', 'contact-form-7' ) ). ")</font><br/>
                        <input type='email'  name='buss_email_paypal' id='buss_email_paypal' class='oneline option large-text' value='{$buss_email_paypal}' />
                    </td>
                    <td>
                        <input type='checkbox' name='use_paypal' id='use_paypal' class='option' value='1' {$use_paypal_checked}>Use Paypal
                    </td>
                </tr>                    
                <tr>

                    <td>". esc_html( __( 'Select Currency', 'contact-form-7' ) ). " (".esc_html( __('Default USD', 'contact-form-7' ) ).") <br />
                        <select name='currency_paypal' id='currency_paypal' onchange='document.getElementById('currency_paypal').value = this.value;'>";

                                foreach( $currency as $key => $value ) 
                                {
                                    $selected = "";
                                    if( $key == $currency_paypal ) 
                                        $selected = "selected";
                                    
                                    $html .=" <option value='{$key}' {$selected}> {$value} </option>";
                             } 
                            $html .="</select>
                        <input type='hidden' value='' name='currency' id='currency' class='oneline option'>
                    </td>
                    <td><br>
                        <input type='checkbox' name='use_sandbox_paypal' id='use_sandbox_paypal' class='option' value='1' {$use_sandbox_paypal_checked}>Use PayPal Sandbox
                    </td>
                </tr>

                <tr>
                    <td colspan='2'><hr>
                        <font color='blue'><i>". esc_html( __( 'Enter Contact Form 7 Field\'s ID for these 3 PayPal fields,', 'contact-form-7' ))."<i></font>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <table>
                            <tr>
                                <td>". esc_html( __( 'Item amount Field ID', 'contact-form-7' ) ) . "<font style='font-size:10px'> (".esc_html( __('required', 'contact-form-7' ) ). ")</font>
                                </td>
                                <td>
                                    <input type='text' name='item_amount_paypal' id='item_amount_paypal' class='oneline option' value='{$item_amount_paypal}'/> 
                                </td>
                            </tr>
                            <tr>
                                <td>".esc_html( __( 'Item name Field ID', 'contact-form-7' ) ). "<font style='font-size:10px'> (".esc_html( __('optional', 'contact-form-7' ) ). ")</font>
                                </td>
                                <td>
                                    <input type='text' name='item_name_paypal' id='item_name_paypal' class='oneline option' value='{$item_name_paypal}' />
                                </td>
                            </tr>
                            <tr>
                                <td>". esc_html( __( 'Quantity Field ID', 'contact-form-7' ) )."<font style='font-size:10px'> (".esc_html( __('optional', 'contact-form-7' ) ). ")</font>
                                </td>
                                <td>
                                    <input type='text' name='item_qty_paypal' id='item_qty_paypal' class='oneline option' value='{$item_qty_paypal}'/>
                                </td>
                            </tr>
                        </table><hr>
                    </td>
                </tr>
                <tr>
                    <td>".  esc_html( __( 'Success Return URL', 'contact-form-7' ) )."<font style='font-size:10px'> (".esc_html( __('optional', 'contact-form-7' ) ). ")</font><br />
                           <input type='url' name='success_url_paypal' id='success_url_paypal' class='oneline option large-text' value='{$success_url_paypal}' />
                    </td>
                    <td>". esc_html( __( 'Cancel Return URL', 'contact-form-7' ) )."<font style='font-size:10px'> (".esc_html( __('optional', 'contact-form-7' ) ). ")</font><br />
                           <input type='url' name='cancel_url_paypal' id='cancel_url_paypal' class='oneline option large-text' value='{$cancel_url_paypal}' />
                    </td>
                </tr>

            </table>
        </fieldset>
        </div>";

        echo $html;
    }
    
    /**
    * Paypal save settings
    *
    * @package Contact Form 7 - PayPal Extension
    * @since 2.4
    */
    function cf7pe_save_paypal_settings( $contact_form ) {

        // Get the form id/post id
        if ( $_POST['post_ID']  == -1 )
            $currentformid  = $contact_form->id();
        else
            $currentformid  = sanitize_text_field( $_POST['post_ID']            );
                
        $buss_email_paypal  = sanitize_text_field( $_POST['buss_email_paypal']  );        
        $currency_paypal    = sanitize_text_field( $_POST['currency_paypal']    );                
        $use_sandbox_paypal = sanitize_text_field( $_POST['use_sandbox_paypal'] );       
        
        if( $use_sandbox_paypal == '' ) 
            $use_sandbox_paypal = 0;
        
        $use_paypal         = sanitize_text_field( $_POST['use_paypal']         );       
        if( $use_paypal == '' ) 
            $use_paypal = 0;
        
        $item_amount_paypal = sanitize_text_field( $_POST['item_amount_paypal'] );       
        $item_name_paypal   = sanitize_text_field( $_POST['item_name_paypal']   );       
        $item_qty_paypal    = sanitize_text_field( $_POST['item_qty_paypal']    );       
        $success_url_paypal = sanitize_text_field( $_POST['success_url_paypal'] );       
        $cancel_url_paypal  = sanitize_text_field( $_POST['cancel_url_paypal']  );       
               
        $paypal_field_array=array( );
        $paypal_field_array['_cf7paypal_buss_email']  = $buss_email_paypal;
        $paypal_field_array['_cf7paypal_currency']    = $currency_paypal;
        $paypal_field_array['_cf7paypal_use_sandbox'] = $use_sandbox_paypal;
        $paypal_field_array['_cf7paypal_use_paypal']  = $use_paypal;
        $paypal_field_array['_cf7paypal_item_amount'] = $item_amount_paypal;
        $paypal_field_array['_cf7paypal_item_name']   = $item_name_paypal;
        $paypal_field_array['_cf7paypal_item_qty']    = $item_qty_paypal;
        $paypal_field_array['_cf7paypal_success_url'] = $success_url_paypal;
        $paypal_field_array['_cf7paypal_cancel_url']  = $cancel_url_paypal;
        
        
        foreach( $paypal_field_array as $meta_key=>$meta_val )
        {
            update_post_meta( $currentformid, $meta_key, $meta_val );
        }
               
    }
    

}

$cf7pe_admin = new Cf7pe_Admin ( );
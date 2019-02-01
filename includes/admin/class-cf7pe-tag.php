<?php
/**
 * Contat form 7 tag generator Class
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
        // Payapl tag generator
        add_action( 'admin_init', array($this,'wpcf7_add_tag_generator_paypal_submit'),55 );

		// Admin Init Processes
		add_action( 'admin_init', array($this, 'cf7pe_admin_init_process') );
    }

    /**
    * Button add after submit tag
    *
    * @package Contact Form 7 - PayPal Extension
    * @since 2.4
    */
    function wpcf7_add_tag_generator_paypal_submit() {
        if(class_exists('WPCF7_TagGenerator')){
            $tag_generator = WPCF7_TagGenerator::get_instance();
            $tag_generator->add( 'paypal-submit', __( 'PayPal Submit button', 'contact-form-7' ), array($this, 'wpcf7_tg_pane_paypal_submit'), array( 'nameless' => 1 ) );
        }
    }

    /**
    * PayPal form data on click paypal submit button tag
    *
    * @package Contact Form 7 - PayPal Extension
    * @since 2.4
    */
    function wpcf7_tg_pane_paypal_submit( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $description = __( "Generate a form-tag for a paypal submit button which redirects you to PayPal website for making your payments after submitting the form.", 'contact-form-7' );
        $desc_link = wpcf7_link( '',__( 'PayPal Submit Button', 'contact-form-7' ) );
        $currency = array('AUD'=>'Australian Dollar','BRL'=>'Brazilian Real','CAD'=>'Canadian Dollar','CZK'=>'Czech Koruna','DKK'=>'Danish Krone','EUR'=>'Euro','HKD'=>'Hong Kong Dollar','HUF'=>'Hungarian Forint','ILS'=>'Israeli New Sheqel','JPY'=>'Japanese Yen','MYR'=>'Malaysian Ringgit','MXN'=>'Mexican Peso','NOK'=>'Norwegian Krone','NZD'=>'New Zealand Dollar','PHP'=>'Philippine Peso','PLN'=>'Polish Zloty','GBP'=>'Pound Sterling','RUB'=>'Russian Ruble','SGD'=>'Singapore Dollar', 'SEK'=>'Swedish Krona','CHF'=>'Swiss Franc','TWD'=>'Taiwan New Dollar','THB'=>'Thai Baht','TRY'=>'Turkish Lira','USD'=>'U.S. Dollar'); ?>

        <div class="control-box">
            <fieldset>
            <legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>
                <table class="form-table">
                    <tbody>
                    <tr><td colspan="2"><a href="http://www.zealousweb.com/wordpress-plugins/shop/" target="_blank">
                        <img src="<?php echo CF7PE_URL.'/assets/images/cf7pn.jpg';?>" width="540">
                    </a></td></tr>
                    <tr>
                    <td colspan="2"><b><?php _e('NOTE: If required fields are missing, PayPal Submit button works as simple Submit button.','contact-form-7-paypal-extension');?></b></td>
                    </tr>
                    <tr>
                    <td><code>id</code> <?php echo '<font style="font-size:10px"> (optional)</font>';?><br />
                    <input type="text" name="id" class="idvalue oneline option" /></td>
                    <td><code>class</code> <?php echo '<font style="font-size:10px"> (optional)</font>'; ?><br />
                    <input type="text" name="class" class="classvalue oneline option" /></td>
                    </tr>
                    <tr>
                    <td><?php echo esc_html( __( 'Label', 'contact-form-7' ) ); echo '<font style="font-size:10px"> (optional)</font>'; ?><br />
                    <input type="text" name="values" class="oneline" /></td>
                    <td><?php echo esc_html( __( 'PayPal Business E-Mail', 'contact-form-7' ) );echo '<font style="font-size:10px"> (required)</font>';?><br />
                    <input type="text" name="email" class="oneline option" /></td>
                    </tr>
                    <tr>
                    <td><?php echo esc_html( __( 'Select Currency', 'contact-form-7' ) ); echo ' (Default "USD")';?><br />
                        <select name="currencies" onchange="document.getElementById('currency').value = this.value;">
                            <?php foreach($currency as $key=>$value) { ?>
                                <option value="<?php echo $key;?>" <?php echo ($key == "USD")?'selected':'';?>><?php echo $value;?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" value="" name="currency" id="currency" class="oneline option">
                    </td>
                    <td><br><input type="checkbox" name="sandbox" class="option">Use PayPal Sandbox</td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr><font color="blue"><i>Enter Contact Form 7 Field's ID for these 3 PayPal fields,<i></font></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <table>
                            <tr><td><?php echo esc_html( __( 'Itemamount Field ID', 'contact-form-7' ) ); echo '<font style="font-size:10px"> (required)</font>'; ?></td>
                                <td><input type="text" name="itemamount" class="oneline option"/></td>
                            </tr>
                            <tr><td><?php echo esc_html( __( 'Itemname Field ID', 'contact-form-7' ) ); echo '<font style="font-size:10px"> (optional)</font>';?></td>
                                <td><input type="text" name="itemname" class="oneline option" /></td>
                            </tr>
                            <tr><td><?php echo esc_html( __( 'Quantity Field ID', 'contact-form-7' ) ); echo '<font style="font-size:10px"> (optional)</font>'; ?></td>
                                <td><input type="text" name="quantity" class="oneline option" /></td>
                            </tr>
                        </table><hr>
                    </td>
                    </tr>
                    <tr>
                    <td><?php echo esc_html( __( 'Success Return URL', 'contact-form-7' ) ); echo '<font style="font-size:10px"> (optional)</font>';?><br />
                        <input type="text" name="return_url" class="oneline option" /></td>
                    <td><?php echo esc_html( __( 'Cancel Return URL', 'contact-form-7' ) ); echo '<font style="font-size:10px"> (optional)</font>';?><br />
                        <input type="text" name="cancel_url" class="oneline option" /></td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>
        <div class="insert-box">
            <input type="text" name="paypalsubmit" class="tag code" readonly="readonly" onfocus="this.select()" />
            <div class="submitbox">
            <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
            </div>
        </div>
        <?php
    }

	/**
	 * Admin prior processes
	 *
	 * @package Contact Form 7 - PayPal Extension
	 * @since 2.4
	 */
	function cf7pe_admin_init_process() {

		// If plugin notice is dismissed
		if( isset($_GET['message']) && $_GET['message'] == 'cf7pe-plugin-notice' ) {
			set_transient( 'cf7pe_install_notice', true, 604800 );
		}
	}
}

$cf7pe_admin = new Cf7pe_Admin();
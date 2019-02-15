<?php
/**
 * Plugin Name: Contact Form 7 - PayPal Extension
 * Plugin URL: https://wordpress.org/plugins/contact-form-7-paypal-extension/
 * Description:  This plugin will integrate PayPal submit button which redirects you to PayPal website for making your payments after submitting the form. <strong>PRO Version is available now.</strong>
 * Version: 2.4
 * Author: ZealousWeb
 * Author URI: https://www.zealousweb.com
 * Developer: The Zealousweb Team
 * Developer E-Mail: opensource@zealousweb.com
 * Text Domain: contact-form-7-paypal-extension
 * Domain Path: /languages
 *
 * Copyright: © 2009-2019 ZealousWeb Technologies.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

 // Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Basic plugin definitions
 *
 * @package Contact Form 7 - PayPal Extension
 * @since 2.4
 */
if( !defined( 'CF7PE_VERSION' ) ) {
    define( 'CF7PE_VERSION', '1.1' ); // Version of plugin
}
if( !defined( 'CF7PE_DIR' ) ) {
    define( 'CF7PE_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if( !defined( 'CF7PE_URL' ) ) {
    define( 'CF7PE_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}
if( !defined( 'CF7PE_PLUGIN_BASENAME' ) ) {
    define( 'CF7PE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // Plugin base name
}
if( !defined( 'CF7PE_META_PREFIX' ) ) {
    define( 'CF7PE_META_PREFIX', '_cf7pe_' ); // Plugin metabox prefix
}

/**
 * Load Text Domain
 * This gets the plugin ready for translation
 *
 * @package Contact Form 7 - PayPal Extension
 * @since 2.4
 */
 function cf7pe_load_textdomain() {
	global $wp_version;

	// Set filter for plugin's languages directory
	$cf7pe_lang_dir = dirname( CF7PE_PLUGIN_BASENAME ) . '/languages/';
	$cf7pe_lang_dir = apply_filters( 'cf7pe_languages_directory', $cf7pe_lang_dir );

	// Traditional WordPress plugin locale filter.
	$get_locale = get_locale();

	if ( $wp_version >= 4.7 ) {
		$get_locale = get_user_locale();
	}

	// Traditional WordPress plugin locale filter
	$locale = apply_filters( 'plugin_locale',  $get_locale, 'contact-form-7-paypal-extension' );
	$mofile = sprintf( '%1$s-%2$s.mo', 'contact-form-7-paypal-extension', $locale );

	// Setup paths to current locale file
	$mofile_global = WP_LANG_DIR . '/plugins/' . basename( CF7PE_DIR ) . '/' . $mofile;

	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/plugin-name folder
		load_textdomain( 'contact-form-7-paypal-extension', $mofile_global );
	} else { // Load the default language files
		load_plugin_textdomain( 'contact-form-7-paypal-extension', false, $cf7pe_lang_dir );
	}
}

// Action to load plugin text domain
add_action('plugins_loaded', 'cf7pe_load_textdomain');

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package Contact Form 7 - PayPal Extension
 * @since 2.4
 */
 register_activation_hook( __FILE__, 'cf7pe_install' );

 function cf7pe_install() {

	 // Deactivate Pro Version
	 if( is_plugin_active('contact-form-7-paypal-extension-pro/contact-form-7-paypal-extension-pro.php') ) {
		 add_action('update_option_active_plugins', 'cf7pe_deactivate_pro_version');
	 }
 }

 /**
  * Deactivate lite (Free) version of plugin
  *
  * @package Contact Form 7 - PayPal Extension
  * @since 2.4
  */
 function cf7pe_deactivate_pro_version() {
	 deactivate_plugins('contact-form-7-paypal-extension-pro/contact-form-7-paypal-extension-pro.php', true);
 }

 /**
 * Function to display admin notice of activated plugin.
 *
 * @package Contact Form 7 - PayPal Extension
 * @since 2.4
 */
function cf7pe_plugin_admin_notice() {

	global $pagenow;

	$dir 			= WP_PLUGIN_DIR . '/contact-form-7-paypal-extension-pro/contact-form-7-paypal-extension-pro.php';
	$notice_link 		= add_query_arg( array('message' => 'cf7pe-plugin-notice'), admin_url('plugins.php') );
	$notice_transient 	= get_transient( 'cf7pe_install_notice' );

	// If PRO plugin is active and free plugin exist
	if ( $notice_transient == false && $pagenow == 'plugins.php' && file_exists($dir) && current_user_can( 'install_plugins' ) ) {

		echo '<div class="updated notice" style="position:relative;">
				<p>
					<strong>'.sprintf( __('Thank you for activating %s', 'contact-form-7-paypal-extension'), 'Contact Form 7 - PayPal Extension').'</strong>.<br/>
					'.sprintf( __('It looks like you had PRO version %s of this plugin activated. To avoid conflicts the extra version has been deactivated and we recommend you delete it.', 'contact-form-7-paypal-extension'), '<strong>(<em>Contact Form 7 - PayPal Extension PRO</em>)</strong>' ).'
				</p>
				<a href="'.esc_url( $notice_link ).'" class="notice-dismiss" style="text-decoration:none;"></a>
		</div>';
	}
}

// How it work file, Load admin files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	require_once( CF7PE_DIR . '/includes/admin/cf7pe-how-it-work.php' );
}

// Action to display notice
add_action( 'admin_notices', 'cf7pe_plugin_admin_notice');

// Contact form 7 tab generator Class File
require_once( CF7PE_DIR . '/includes/admin/class-cf7pe-tab.php' );

// Script Class
require_once( CF7PE_DIR . '/includes/class-cf7pe-script.php' );

// Paypal button class
require_once( CF7PE_DIR . '/includes/shortcodes/cf7pe-paypal-button.php' );
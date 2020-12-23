<?php 
/**
*  Plugin Name: Everexpert-Mobireach SMS Notification
*  Plugin URI: https://everexpert.com/
*  Description: This plugin allows you to send woocommerce transactional alert to your customer through Mobireach Gateway.
*  Version: 1.0.0
*  Stable tag: 1.0.0
*  WC tested up to: 4.3.0
*  Author: Naeem Hasan
*  Author URI: https://github.com/everexpert
*  Author Email: naeem@everexpert.com
*  License: GNU General Public License v3.0
*  License URI: http://www.gnu.org/licenses/gpl-3.0.html
**/
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    EE_Mobireach_Woocommerce
 * @author     Naeem Hasan <hasannaeem157@gmail.com>
 */

	if (!defined('ABSPATH')) exit; // Exit if accessed directly

	define( 'EEMR_SMS_PATH', plugin_dir_path( __FILE__ ) );
	define( 'EEMR_SMS_URL', plugin_dir_url( __FILE__ ) );

	define ( 'EEMR_SMS_NOTIFICATION_VERSION', '1.0.0');
	
	global $plugin_slug;
	$plugin_slug = 'eemr';
	$options = get_option( 'eemr_notification' );

	require_once( EEMR_SMS_PATH . 'lib/eemr-init.php' );
	require_once( EEMR_SMS_PATH . 'lib/eemr-admin-setting.php' );
	require_once( EEMR_SMS_PATH . 'lib/eemr-woo-alert.php' );

	use eemr\Admin\Init\eemr_Init;
	use eemr\Admin\Setting\eemr_Admin_Setting;
	use eemr\Sms\Woosms\eemr_Woo_Alert;

	new eemr_Admin_Setting;

	if(isset($options['enable_plugin']) && !empty($options['enable_plugin']))
	{
		new eemr_Woo_Alert;
	}

	/**
	 * Hook plugin activation
	*/
	
	register_activation_hook( __FILE__, 'EEWcMobireachActivator' );
	function EEWcMobireachActivator() {
		eemr_Init::install_eemr();
		$eemr_installed_version = get_option( "eemr_plugin_version" );

		if ( $eemr_installed_version == EEMR_SMS_NOTIFICATION_VERSION ) {
			return true;
		}
		update_option( 'eemr_plugin_version', EEMR_SMS_NOTIFICATION_VERSION );
	}

	/**
	 * Hook plugin deactivation
	 */
	register_deactivation_hook( __FILE__, 'EEWcMobireachDeactivator' );
	function EEWcMobireachDeactivator() { }


	function everexpert_care_settings_link($links)
	{
	    $pluginLinks = array(
            'settings' => '<a href="https://www.everexpert.com/">Settings</a>',
            'docs'     => '<a href="https://www.everexpert.com/" target="blank">Docs</a>',
            'support'  => '<a href="mailto:naeem@everexpert.com">Support</a>'
        );

	    $links = array_merge($links, $pluginLinks);

	    return $links;
	}

	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'everexpert_care_settings_link');
?>
<?php
#-------------------------
# Register & Trigger Hook For Woocommerce alert
#-------------------------

namespace eemr\Sms\Woosms;

require_once( EEMR_SMS_PATH . 'lib/eemr-sms-api.php' );
use eemr\Sms\Api\eemr_Sms_Api;

global $eemr_settings;
global $woocommerce;

class eemr_Woo_Alert
{
	public function __construct()
	{
		$eemr_settings = get_option( 'eemr_notification' );

		if(isset($eemr_settings['eemr_pending_alert']) && $eemr_settings['eemr_pending_alert'] != "")
		{
			add_action( 'woocommerce_order_status_pending', array($this, 'eemr_alert_pending'));
		}
		if(isset($eemr_settings['eemr_processing_alert']) && $eemr_settings['eemr_processing_alert'] != "")
		{
			add_action( 'woocommerce_order_status_processing', array($this, 'eemr_alert_processing'));
		}
		if(isset($eemr_settings['eemr_onhold_alert']) && $eemr_settings['eemr_onhold_alert'] != "")
		{
			add_action( 'woocommerce_order_status_on-hold', array($this, 'eemr_alert_hold'));
		}
		if(isset($eemr_settings['eemr_failed_alert']) && $eemr_settings['eemr_failed_alert'] != "")
		{
			add_action( 'woocommerce_order_status_failed', array($this, 'eemr_alert_failed'));
		}
		if(isset($eemr_settings['eemr_canceled_alert']) && $eemr_settings['eemr_canceled_alert'] != "")
		{
			add_action( 'woocommerce_order_status_cancelled', array($this, 'eemr_alert_cancelled'));
		}
		if(isset($eemr_settings['eemr_completed_alert']) && $eemr_settings['eemr_completed_alert'] != "")
		{
			add_action( 'woocommerce_order_status_completed', array($this, 'eemr_alert_completed'));
		}
		if(isset($eemr_settings['eemr_refund_alert']) && $eemr_settings['eemr_refund_alert'] != "")
		{
			add_action( 'woocommerce_order_status_refunded', array($this, 'eemr_alert_refunded'));
		}
		if(isset($eemr_settings['eemr_partial_alert']) && $eemr_settings['eemr_partial_alert'] != "")
		{
			add_action('woocommerce_order_status_partially-paid', array($this, 'eemr_alert_partially'));
		}
		if(isset($eemr_settings['eemr_shipped_alert']) && $eemr_settings['eemr_shipped_alert'] != "")
		{
			add_action( 'woocommerce_order_status_shipped', array($this, 'eemr_alert_shipped'));
		}
	}

	public function eemr_alert_pending($order_id) {

		global $wpdb;
	    global $woocommerce;
		$eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'Pending';
	    $smstext = trim($eemr_settings['eemr_pending_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_pending_alert']))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }
            
            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
    }

    public function eemr_alert_failed($order_id) {

    	global $wpdb;
	    global $woocommerce;
    	$eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'Failed';
	    $smstext = trim($eemr_settings['eemr_failed_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_failed_alert'] ))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }

            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
    }

    public function eemr_alert_hold($order_id) {

    	global $wpdb;
	    global $woocommerce;
    	$eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'On-Hold';
	    $smstext = trim($eemr_settings['eemr_onhold_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_onhold_alert']))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }

            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
    }

    public function eemr_alert_processing($order_id) {
 
    	global $wpdb;
    	global $woocommerce;
    	$eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();
	    

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'Processing';
	    $smstext = trim($eemr_settings['eemr_processing_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_processing_alert'] ))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }
            if(isset($eemr_settings['eemr_admin_sms_alert']) && $eemr_settings['eemr_admin_phone'] != "" && $eemr_settings['eemr_admin_sms_template'] != "")
            {
            	$adminsmstext = $eemr_settings['eemr_admin_sms_template'];
            	$adminphone = $eemr_settings['eemr_admin_phone'];

            	$adminsmstext = str_ireplace("{{name}}", $name, $adminsmstext);
		    	$adminsmstext = str_ireplace("{{status}}", $status, $adminsmstext);
		    	$adminsmstext = str_ireplace("{{amount}}", $order_amount, $adminsmstext);
		    	$adminsmstext = str_ireplace("{{currency}}", $currency, $adminsmstext);
		        $adminsmstext = str_ireplace("{{order_id}}", $order_id, $adminsmstext);
            	$adminresponse = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($adminphone, $adminsmstext));
            	$this->save_response(get_bloginfo('name'), $adminphone, 'Admin Notification', $adminresponse);
            }

            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
    }

    public function eemr_alert_completed($order_id) {

    	global $wpdb;
	    global $woocommerce;
    	$eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'Completed';
	    $smstext = trim($eemr_settings['eemr_canceled_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_completed_alert'] ))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }

            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
    }

    public function eemr_alert_refunded($order_id) {

    	global $wpdb;
	    global $woocommerce;
    	$eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'Refunded';
	    $smstext = trim($eemr_settings['eemr_refund_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_refund_alert']))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }

            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
    }

    public function eemr_alert_cancelled($order_id) {

    	global $wpdb;
	    global $woocommerce;
    	$eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'Cancelled';
	    $smstext = trim($eemr_settings['eemr_canceled_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_canceled_alert']))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }

            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
    }

	public function eemr_alert_shipped($order_id){

		global $wpdb;
	    global $woocommerce;
	    $eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'Shipped';
	    $smstext = trim($eemr_settings['eemr_shipped_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_shipped_alert']))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }

            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
	}

	public function eemr_alert_partially($order_id){

		global $wpdb;
	    global $woocommerce;
	    $eemr_settings = get_option( 'eemr_notification' );
	    $order 			= wc_get_order( $order_id );
	    $order_amount	= $order->get_total();
	    $user 			= $order->get_user();
	    $user_id 		= $order->get_user_id();
	    $currency 		= $order->get_currency();

	    if($order->get_billing_phone() != "")
	    {
	    	$name    		 = $order->get_billing_last_name().' '.$order->get_billing_first_name();
	    	$customer_mobile = $order->get_billing_phone();
	    }
	    

	    $status  = 'Partially Paid';
	    $smstext = trim($eemr_settings['eemr_partial_template']);
	    $sms_type = 'Order Notification Alert - '.$status;

	    if( isset($eemr_settings['enable_plugin']) && !empty($customer_mobile) && !empty($smstext) && isset($eemr_settings['eemr_partial_alert']))
	    {
	    	$smstext = str_ireplace("{{name}}", $name, $smstext);
	    	$smstext = str_ireplace("{{status}}", $status, $smstext);
	    	$smstext = str_ireplace("{{amount}}", $order_amount, $smstext);
	    	$smstext = str_ireplace("{{currency}}", $currency, $smstext);
	        $smstext = str_ireplace("{{order_id}}", $order_id, $smstext);
	        
	        if($smstext != "")
            {
                $response = eemr_Sms_Api::call_to_get_api(eemr_Sms_Api::set_get_parameter($customer_mobile, $smstext));
            }

            $this->save_response($name, $customer_mobile, $sms_type, $response);
	    }
	}

	public function save_response($name, $customer_mobile, $sms_type, $response)
	{
		if($response != "")
		{
			global $wpdb;
			$table_woo_name = $wpdb->prefix . "eemr_woo_alert";
			$wpdb->insert(
	            $table_woo_name,
	            array(
	                'customer_name' => sanitize_text_field($name),
	                'phone_no' => $customer_mobile,
	                'sms_type' => sanitize_text_field($sms_type),
	                'api_response' => sanitize_text_field(serialize($response))
	            )
	        );
		}
	}

}
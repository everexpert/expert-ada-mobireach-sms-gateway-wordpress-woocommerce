<?php 
	#-----------------
	# Api requesting script.
	#-----------------
namespace eemr\Sms\Api;

class eemr_Sms_Api
{
	############################### Process parameters for GET request ################################

	public static function set_get_parameter($phone_number, $sms_text)
	{
		$unique_id = uniqid();
		$settings = get_option( 'eemr_notification' );

    	$eemr_api_from 	 = $settings['eemr_api_from'];
		
		if($settings['api_username'] != "" && $settings['api_password'] != "" && $eemr_api_from != "")
		{
			$api_username 	= $settings['api_username'];
    		$api_password 	= $settings['api_password'];

			$sms = urlencode($sms_text);
			$param = "Username=$api_username&Password=$api_password&From=$eemr_api_from&To=$phone_number&Message=$sms";

			return $param;
		}
		else{
			return "404";
		}
	}


	################################# Process API For GET REQUEST ##################################

	public static function call_to_get_api($peram)
	{
		$settings 		= get_option( 'eemr_notification' );
		$eemr_api 	= $settings['eemr_api_version'];
		$api_url 		= "https://api.mobireach.com.bd/SendTextMessage";
		$url = $api_url."?".$peram;

		$response = wp_remote_post(
			$url,
			array(
				'method'      => 'GET',
				'timeout'     => 30,
				'redirection' => 10,
				'httpversion' => '1.1',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => array(),
				'cookies'     => array(),
			)
		);

		if ( is_wp_error( $response ) ) 
		{
		   	$apiresponse = $response->get_error_message();
		} 
		else 
		{
		   	$apiresponse = array($response['response'], $response['body']);
		}

		return $apiresponse;
	}
}
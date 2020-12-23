<?php
/**
 * Admin settings option
 */

namespace eemr\Admin\Setting;

class eemr_Admin_Setting
{
	public function __construct() {
        add_action( 'admin_menu', array( $this, 'eemr_create_side_menu' ) );
        add_action( 'admin_init', array( $this, 'eemr_initialize_settings' ));
    }

	public function eemr_create_side_menu() {

		global $plugin_slug;

	    add_menu_page(
	        __('EE-Mobireach', $plugin_slug),
	        __('EE-Mobireach', $plugin_slug),
	        'administrator',
	        'eemr-notification',
	        array( $this, 'eemr_sms_settings')
	    );

	    add_submenu_page(
	        'eemr-notification',
	        __('Woocommerce Transactional SMS', $plugin_slug),
	        __('SMS Report', $plugin_slug),
	        'administrator',
	        'eemr-report',
	        array( $this, 'eemr_sms_report')
	    );
	}

	# Settings Page Content

	public function eemr_sms_settings() {
	?>
	    <div class="wrap">
	        <h2>EE Woocommerce Mobireach SMS Settings</h2>

	        <?php settings_errors(); ?>

	        <form method="post" action="options.php">
	            <?php settings_fields( 'eemr_notification' ); ?>
	            <?php do_settings_sections( 'eemr_notification' ); ?>
	            <?php submit_button(); ?>
	        </form>

	    </div>

	<?php
	}

	public function eemr_sms_report() {
	?>
	    <div class="wrap">
	        <h2>EE Mobireach Transactional SMS Report</h2><hr>
	        <?php include_once( EEMR_SMS_PATH . 'lib/eemr-woo-report.php' ); ?>
	    </div>
	<?php
	}

	public function eemr_initialize_settings() {
		global $plugin_slug;

	    if( false == get_option( 'eemr_notification' ) ) {
	        add_option( 'eemr_notification' );
	    }

	    # API Configuration Section

	    add_settings_section(
	        'api_settings_section',
	        __('API Configuration', $plugin_slug),
	        array( $this, 'eemr_notifications_callback'),
	        'eemr_notification'
	    );

	    add_settings_field(
	        'enable_plugin',
	        __('Enable Plugin', $plugin_slug),
	        array( $this, 'eemr_plugin_enable_callback'),
	        'eemr_notification',
	        'api_settings_section'
	    );

	    add_settings_field(
	        'api_username',
	        __('API User', $plugin_slug),
	        array( $this, 'eemr_username_callback'),
	        'eemr_notification',
	        'api_settings_section'
	    );

	    add_settings_field(
	        'api_password',
	        __('API Password', $plugin_slug),
	        array( $this, 'eemr_password_callback'),
	        'eemr_notification',
	        'api_settings_section'
	    );

	    add_settings_field(
	        'eemr_api_from',
	        __('From', $plugin_slug),
	        array( $this, 'eemr_from_callback'),
	        'eemr_notification',
	        'api_settings_section'
	    );

	    # Template Configuration Section

	    add_settings_section(
	        'template_settings_section',
	        __('SMS Template Configuration', $plugin_slug),
	        array( $this, 'template_settings_callback'),
	        'eemr_notification'
	    );

	    add_settings_field(
	        'eemr_pending_alert',
	        __('Order Pending Alert', $plugin_slug),
	        array( $this, 'eemr_pending_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_pending_template',
	        __('Pending Alert Template', $plugin_slug),
	        array( $this, 'eemr_pending_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

		add_settings_field(
	        'eemr_processing_alert',
	        __('Order Processing Alert', $plugin_slug),
	        array( $this, 'eemr_processing_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_processing_template',
	        __('Processing Alert Template', $plugin_slug),
	        array( $this, 'eemr_processing_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );	    

	    add_settings_field(
	        'eemr_onhold_alert',
	        __('Order On-Hold Alert', $plugin_slug),
	        array( $this, 'eemr_onhold_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_onhold_template',
	        __('On-Hold Alert Template', $plugin_slug),
	        array( $this, 'eemr_onhold_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_failed_alert',
	        __('Order Failed Alert', $plugin_slug),
	        array( $this, 'eemr_failed_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_failed_template',
	        __('Failed Alert Template', $plugin_slug),
	        array( $this, 'eemr_failed_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_canceled_alert',
	        __('Order Cancelled Alert', $plugin_slug),
	        array( $this, 'eemr_canceled_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_canceled_template',
	        __('Cancelled Alert Template', $plugin_slug),
	        array( $this, 'eemr_canceled_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );
	    
	    add_settings_field(
	        'eemr_failed_template',
	        __('Failed Alert Template', $plugin_slug),
	        array( $this, 'eemr_failed_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_completed_alert',
	        __('Order Completed Alert', $plugin_slug),
	        array( $this, 'eemr_completed_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_completed_template',
	        __('Completed Alert Template', $plugin_slug),
	        array( $this, 'eemr_completed_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_refund_alert',
	        __('Order Refund Alert', $plugin_slug),
	        array( $this, 'eemr_refund_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_refund_template',
	        __('Refund Alert Template', $plugin_slug),
	        array( $this, 'eemr_refund_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_partial_alert',
	        __('Order Partially Paid Alert', $plugin_slug),
	        array( $this, 'eemr_partial_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_partial_template',
	        __('Partially Paid Alert Template', $plugin_slug),
	        array( $this, 'eemr_partial_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_shipped_alert',
	        __('Order Shipped Alert', $plugin_slug),
	        array( $this, 'eemr_shipped_alert_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    add_settings_field(
	        'eemr_shipped_template',
	        __('Shipped Alert Template', $plugin_slug),
	        array( $this, 'eemr_shipped_template_callback'),
	        'eemr_notification',
	        'template_settings_section'
	    );

	    # Admin SMS Settings

	    add_settings_section(
	        'admin_settings_section',
	        __('Admin SMS Configuration', $plugin_slug),
	        array( $this, 'admin_sms_settings_callback'),
	        'eemr_notification'
	    );

	    add_settings_field(
	        'eemr_admin_sms_alert',
	        __('Order Alert For Admin', $plugin_slug),
	        array( $this, 'eemr_admin_sms_alert_callback'),
	        'eemr_notification',
	        'admin_settings_section'
	    );

	    add_settings_field(
	        'eemr_admin_phone',
	        __('Admin Phone Number', $plugin_slug),
	        array( $this, 'eemr_admin_phone_callback'),
	        'eemr_notification',
	        'admin_settings_section'
	    );

		add_settings_field(
	        'eemr_admin_sms_template',
	        __('Admin Alert Template', $plugin_slug),
	        array( $this, 'eemr_admin_sms_template_callback'),
	        'eemr_notification',
	        'admin_settings_section'
	    );	    

	    register_setting(
	        'eemr_notification',
	        'eemr_notification',
	        array( $this, 'eemr_sanitize_settings')
	    );
	}

	public function eemr_notifications_callback() {
	    echo "<hr>";
	}
		
	public function eemr_plugin_enable_callback() {
	    $options = get_option( 'eemr_notification' );

	    $enable_plugin = get_option('enable_plugin');
	    if( isset( $options['enable_plugin'] ) && $options['enable_plugin'] != '' ) {
	        $enable_plugin = $options['enable_plugin'];
	    }

	    $html = '<input type="checkbox" id="enable_plugin" name="eemr_notification[enable_plugin]" value="1"' . checked( 1, $enable_plugin, false ) . '/>';
	    $html .= '<label for="checkbox_example">Check to enable the plugin.</label>';

	    echo $html;
	}

	public function eemr_username_callback() {
	    $options = get_option( 'eemr_notification' );

	    $api_username = '';
	    if( isset( $options['api_username'] ) && $options['api_username'] != '' ) {
	        $api_username = $options['api_username'];
	    }

	    $html = '<input type="text" name="eemr_notification[api_username]" value="' . $api_username . '" size="45" placeholder="Enter Username"/>';
	    $html .= '<br><label for="api_username">API User (Provided by Mobireach).</label>';

	    echo $html;
	}

	public function eemr_password_callback() {
	    $options = get_option( 'eemr_notification' );

	    $api_password = '';
	    if( isset( $options['api_password'] ) && $options['api_password'] != '' ) {
	        $api_password = $options['api_password'];
	    }

	    $html = '<input type="text" name="eemr_notification[api_password]" value="' . $api_password . '" size="45" placeholder="Enter Password"/>';
	    $html .= '<br><label for="api_password">API Password (Provided by Mobireach).</label>';

	    echo $html;
	}

	public function eemr_from_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_api_from = '';
	    if( isset( $options['eemr_api_from'] ) && $options['eemr_api_from'] != '' ) {
	        $eemr_api_from = $options['eemr_api_from'];
	    }

	    $html = '<input type="text" name="eemr_notification[eemr_api_from]" value="' . $eemr_api_from . '" size="45" placeholder="Enter From Value"/>';
	    $html .= '<br><label for="eemr_api_from">From (Provided by Mobireach).</label>';

	    echo $html;
	}


	public function template_settings_callback() {
	    echo "<hr>";
	}

	public function eemr_pending_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_pending_alert = get_option('eemr_pending_alert');
	    if( isset( $options['eemr_pending_alert'] ) && $options['eemr_pending_alert'] != '' ) {
	        $eemr_pending_alert = $options['eemr_pending_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_pending_alert" name="eemr_notification[eemr_pending_alert]" value="1"' . checked( 1, $eemr_pending_alert, false ) . '/>';
	    $html .= '<label for="eemr_pending_alert">Enable this field for Order Pending Alert</label>';
	    
	    echo $html;
	}

	public function eemr_pending_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_pending_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_pending_template'] ) && $options['eemr_pending_template'] != '' ) {
	        $eemr_pending_template = $options['eemr_pending_template'];
	    }
	    
	    $html = '<textarea id="eemr_pending_template" rows="4" cols="98" name="eemr_notification[eemr_pending_template]" placeholder="">' . $eemr_pending_template . '</textarea>';
	    $html .= '<br><label for="eemr_pending_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	public function eemr_processing_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_processing_alert = get_option('eemr_processing_alert');
	    if( isset( $options['eemr_processing_alert'] ) && $options['eemr_processing_alert'] != '' ) {
	        $eemr_processing_alert = $options['eemr_processing_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_processing_alert" name="eemr_notification[eemr_processing_alert]" value="1"' . checked( 1, $eemr_processing_alert, false ) . '/>';
	    $html .= '<label for="eemr_processing_alert">Enable this field for Order Processing Alert</label>';
	    
	    echo $html;
	}

	public function eemr_processing_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_processing_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_processing_template'] ) && $options['eemr_processing_template'] != '' ) {
	        $eemr_processing_template = $options['eemr_processing_template'];
	    }
	    
	    $html = '<textarea id="eemr_processing_template" rows="4" cols="98" name="eemr_notification[eemr_processing_template]" placeholder="">' . $eemr_processing_template . '</textarea>';
	    $html .= '<br><label for="eemr_processing_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	public function eemr_onhold_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_onhold_alert = get_option('eemr_onhold_alert');
	    if( isset( $options['eemr_onhold_alert'] ) && $options['eemr_onhold_alert'] != '' ) {
	        $eemr_onhold_alert = $options['eemr_onhold_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_onhold_alert" name="eemr_notification[eemr_onhold_alert]" value="1"' . checked( 1, $eemr_onhold_alert, false ) . '/>';
	    $html .= '<label for="eemr_onhold_alert">Enable this field for Order On-Hold Alert</label>';
	    
	    echo $html;
	}

	public function eemr_onhold_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_onhold_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_onhold_template'] ) && $options['eemr_onhold_template'] != '' ) {
	        $eemr_onhold_template = $options['eemr_onhold_template'];
	    }
	    
	    $html = '<textarea id="eemr_onhold_template" rows="4" cols="98" name="eemr_notification[eemr_onhold_template]" placeholder="">' . $eemr_onhold_template . '</textarea>';
	    $html .= '<br><label for="eemr_onhold_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	public function eemr_failed_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_failed_alert = get_option('eemr_failed_alert');
	    if( isset( $options['eemr_failed_alert'] ) && $options['eemr_failed_alert'] != '' ) {
	        $eemr_failed_alert = $options['eemr_failed_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_failed_alert" name="eemr_notification[eemr_failed_alert]" value="1"' . checked( 1, $eemr_failed_alert, false ) . '/>';
	    $html .= '<label for="eemr_failed_alert">Enable this field for Order Failed Alert</label>';
	    
	    echo $html;
	}

	public function eemr_failed_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_failed_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_failed_template'] ) && $options['eemr_failed_template'] != '' ) {
	        $eemr_failed_template = $options['eemr_failed_template'];
	    }
	    
	    $html = '<textarea id="eemr_failed_template" rows="4" cols="98" name="eemr_notification[eemr_failed_template]" placeholder="">' . $eemr_failed_template . '</textarea>';
	    $html .= '<br><label for="eemr_failed_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	public function eemr_canceled_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_canceled_alert = get_option('eemr_canceled_alert');
	    if( isset( $options['eemr_canceled_alert'] ) && $options['eemr_canceled_alert'] != '' ) {
	        $eemr_canceled_alert = $options['eemr_canceled_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_canceled_alert" name="eemr_notification[eemr_canceled_alert]" value="1"' . checked( 1, $eemr_canceled_alert, false ) . '/>';
	    $html .= '<label for="eemr_canceled_alert">Enable this field for Order Canceled Alert</label>';
	    
	    echo $html;
	}

	public function eemr_canceled_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_canceled_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_canceled_template'] ) && $options['eemr_canceled_template'] != '' ) {
	        $eemr_canceled_template = $options['eemr_canceled_template'];
	    }
	    
	    $html = '<textarea id="eemr_canceled_template" rows="4" cols="98" name="eemr_notification[eemr_canceled_template]" placeholder="">' . $eemr_canceled_template . '</textarea>';
	    $html .= '<br><label for="eemr_canceled_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	public function eemr_completed_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_completed_alert = get_option('eemr_completed_alert');
	    if( isset( $options['eemr_completed_alert'] ) && $options['eemr_completed_alert'] != '' ) {
	        $eemr_completed_alert = $options['eemr_completed_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_completed_alert" name="eemr_notification[eemr_completed_alert]" value="1"' . checked( 1, $eemr_completed_alert, false ) . '/>';
	    $html .= '<label for="eemr_completed_alert">Enable this field for Order Completed Alert</label>';
	    
	    echo $html;
	}

	public function eemr_completed_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_completed_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_completed_template'] ) && $options['eemr_completed_template'] != '' ) {
	        $eemr_completed_template = $options['eemr_completed_template'];
	    }
	    
	    $html = '<textarea id="eemr_completed_template" rows="4" cols="98" name="eemr_notification[eemr_completed_template]" placeholder="">' . $eemr_completed_template . '</textarea>';
	    $html .= '<br><label for="eemr_completed_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	public function eemr_refund_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_refund_alert = get_option('eemr_refund_alert');
	    if( isset( $options['eemr_refund_alert'] ) && $options['eemr_refund_alert'] != '' ) {
	        $eemr_refund_alert = $options['eemr_refund_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_refund_alert" name="eemr_notification[eemr_refund_alert]" value="1"' . checked( 1, $eemr_refund_alert, false ) . '/>';
	    $html .= '<label for="eemr_refund_alert">Enable this field for Order Refund Alert</label>';
	    
	    echo $html;
	}

	public function eemr_refund_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_refund_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_refund_template'] ) && $options['eemr_refund_template'] != '' ) {
	        $eemr_refund_template = $options['eemr_refund_template'];
	    }
	    
	    $html = '<textarea id="eemr_refund_template" rows="4" cols="98" name="eemr_notification[eemr_refund_template]" placeholder="">' . $eemr_refund_template . '</textarea>';
	    $html .= '<br><label for="eemr_refund_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	public function eemr_partial_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_partial_alert = get_option('eemr_partial_alert');
	    if( isset( $options['eemr_partial_alert'] ) && $options['eemr_partial_alert'] != '' ) {
	        $eemr_partial_alert = $options['eemr_partial_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_partial_alert" name="eemr_notification[eemr_partial_alert]" value="1"' . checked( 1, $eemr_partial_alert, false ) . '/>';
	    $html .= '<label for="eemr_partial_alert">Enable this field for Order Partially Paid Alert</label>';
	    
	    echo $html;
	}

	public function eemr_partial_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_partial_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_partial_template'] ) && $options['eemr_partial_template'] != '' ) {
	        $eemr_partial_template = $options['eemr_partial_template'];
	    }
	    
	    $html = '<textarea id="eemr_partial_template" rows="4" cols="98" name="eemr_notification[eemr_partial_template]" placeholder="">' . $eemr_partial_template . '</textarea>';
	    $html .= '<br><label for="eemr_partial_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	public function eemr_shipped_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_shipped_alert = get_option('eemr_shipped_alert');
	    if( isset( $options['eemr_shipped_alert'] ) && $options['eemr_shipped_alert'] != '' ) {
	        $eemr_shipped_alert = $options['eemr_shipped_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_shipped_alert" name="eemr_notification[eemr_shipped_alert]" value="1"' . checked( 1, $eemr_shipped_alert, false ) . '/>';
	    $html .= '<label for="eemr_shipped_alert">Enable this field for Order Shipped Alert</label>';
	    
	    echo $html;
	}

	public function eemr_shipped_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_shipped_template = "Dear {{name}}, your order is {{status}}, Your total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');
	    if( isset( $options['eemr_shipped_template'] ) && $options['eemr_shipped_template'] != '' ) {
	        $eemr_shipped_template = $options['eemr_shipped_template'];
	    }
	    
	    $html = '<textarea id="eemr_shipped_template" rows="4" cols="98" name="eemr_notification[eemr_shipped_template]" placeholder="">' . $eemr_shipped_template . '</textarea>';
	    $html .= '<br><label for="eemr_shipped_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}



	public function admin_sms_settings_callback() {
	    echo "<hr>";
	}

	public function eemr_admin_sms_alert_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_admin_sms_alert = get_option('eemr_admin_sms_alert');
	    if( isset( $options['eemr_admin_sms_alert'] ) && $options['eemr_admin_sms_alert'] != '' ) {
	        $eemr_admin_sms_alert = $options['eemr_admin_sms_alert'];
	    }

	    $html = '<input type="checkbox" id="eemr_admin_sms_alert" name="eemr_notification[eemr_admin_sms_alert]" value="1"' . checked( 1, $eemr_admin_sms_alert, false ) . '/>';
	    $html .= '<label for="eemr_admin_sms_alert">Enable this field only for Admin SMS Alert</label>';
	    
	    echo $html;
	}

	public function eemr_admin_phone_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_admin_phone = '';
	    if( isset( $options['eemr_admin_phone'] ) && $options['eemr_admin_phone'] != '' ) {
	        $eemr_admin_phone = $options['eemr_admin_phone'];
	    }

	    $html = '<input type="text" name="eemr_notification[eemr_admin_phone]" value="' . $eemr_admin_phone . '" size="45" placeholder="Admin Phone Number"/>';

	    echo $html;
	}

	public function eemr_admin_sms_template_callback() {
	    $options = get_option( 'eemr_notification' );

	    $eemr_admin_sms_template = "Order has been placed by {{name}}, order is {{status}}, total amount is {{amount}} {{currency}} for order id {{order_id}}.\nThank You\n".get_bloginfo('name');

	    if( isset( $options['eemr_admin_sms_template'] ) && $options['eemr_admin_sms_template'] != '' ) {
	        $eemr_admin_sms_template = $options['eemr_admin_sms_template'];
	    }
	    
	    $html = '<textarea id="eemr_admin_sms_template" rows="4" cols="98" name="eemr_notification[eemr_admin_sms_template]" placeholder="">' . $eemr_admin_sms_template . '</textarea>';
	    $html .= '<br><label for="eemr_admin_sms_template"><b>Variables : </b>{{name}}, {{status}}, {{amount}}, {{currency}}, {{order_id}}</label>';
	    $html .= '<hr>';

	    echo $html;
	}

	############################################# Validate Fields ##############################################


	public function eemr_sanitize_settings( $input ) {
	    
	    global $plugin_slug;
	    $output = array();

	    if ( isset( $input['enable_plugin'] ) ) {
	        if (  $input['enable_plugin']  ) {
	            $output['enable_plugin'] =  $input['enable_plugin'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable plugin', $plugin_slug));
	        }
	    }

	    if ( isset( $input['api_username'] ) ) {
	        if (  $input['api_username'] != "" ) {
	            $output['api_username'] =  sanitize_textarea_field($input['api_username']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter API Username.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['api_password'] ) ) {
	        if (  $input['api_password'] != "" ) {
	            $output['api_password'] =  sanitize_textarea_field($input['api_password']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter API Password.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_api_from'] ) ) {
	        if (  $input['eemr_api_from'] != "" ) {
	            $output['eemr_api_from'] =  sanitize_textarea_field($input['eemr_api_from']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter From Value.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_pending_alert'] ) ) {
	        if (  $input['eemr_pending_alert']  ) {
	            $output['eemr_pending_alert'] =  $input['eemr_pending_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Pending Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_pending_template'] ) ) {
	        if (  $input['eemr_pending_template'] != "" ) {
	            $output['eemr_pending_template'] =  sanitize_textarea_field($input['eemr_pending_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Pending Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_processing_alert'] ) ) {
	        if (  $input['eemr_processing_alert']  ) {
	            $output['eemr_processing_alert'] =  $input['eemr_processing_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Processing Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_processing_template'] ) ) {
	        if (  $input['eemr_processing_template'] != "" ) {
	            $output['eemr_processing_template'] =  sanitize_textarea_field($input['eemr_processing_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Processing Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_onhold_alert'] ) ) {
	        if (  $input['eemr_onhold_alert']  ) {
	            $output['eemr_onhold_alert'] =  $input['eemr_onhold_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable On-Hold Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_onhold_template'] ) ) {
	        if (  $input['eemr_onhold_template'] != "" ) {
	            $output['eemr_onhold_template'] =  sanitize_textarea_field($input['eemr_onhold_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter On-Hold Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_failed_alert'] ) ) {
	        if (  $input['eemr_failed_alert']  ) {
	            $output['eemr_failed_alert'] =  $input['eemr_failed_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Failed Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_failed_template'] ) ) {
	        if (  $input['eemr_failed_template'] != "" ) {
	            $output['eemr_failed_template'] =  sanitize_textarea_field($input['eemr_failed_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Failed Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_canceled_alert'] ) ) {
	        if (  $input['eemr_canceled_alert']  ) {
	            $output['eemr_canceled_alert'] =  $input['eemr_canceled_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Cancelled Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_canceled_template'] ) ) {
	        if (  $input['eemr_canceled_template'] != "" ) {
	            $output['eemr_canceled_template'] =  sanitize_textarea_field($input['eemr_canceled_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Cancelled Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_completed_alert'] ) ) {
	        if (  $input['eemr_completed_alert']  ) {
	            $output['eemr_completed_alert'] =  $input['eemr_completed_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Completed Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_completed_template'] ) ) {
	        if (  $input['eemr_completed_template'] != "" ) {
	            $output['eemr_completed_template'] =  sanitize_textarea_field($input['eemr_completed_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Completed Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_refund_alert'] ) ) {
	        if (  $input['eemr_refund_alert']  ) {
	            $output['eemr_refund_alert'] =  $input['eemr_refund_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Refund Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_refund_template'] ) ) {
	        if (  $input['eemr_refund_template'] != "" ) {
	            $output['eemr_refund_template'] =  sanitize_textarea_field($input['eemr_refund_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Refund Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_partial_alert'] ) ) {
	        if (  $input['eemr_partial_alert']  ) {
	            $output['eemr_partial_alert'] =  $input['eemr_partial_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Partial Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_partial_template'] ) ) {
	        if (  $input['eemr_partial_template'] != "" ) {
	            $output['eemr_partial_template'] =  sanitize_textarea_field($input['eemr_partial_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Partial Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_shipped_alert'] ) ) {
	        if (  $input['eemr_shipped_alert']  ) {
	            $output['eemr_shipped_alert'] =  $input['eemr_shipped_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Shipped Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_shipped_template'] ) ) {
	        if (  $input['eemr_shipped_template'] != "" ) {
	            $output['eemr_shipped_template'] =  sanitize_textarea_field($input['eemr_shipped_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Shipped Alert Template.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_admin_sms_alert'] ) ) {
	        if (  $input['eemr_admin_sms_alert']  ) {
	            $output['eemr_admin_sms_alert'] =  $input['eemr_admin_sms_alert'] ;
	        } else {
	            add_settings_error( 'eemr_notification', 'plugin-error', esc_html__( 'Enable Admin Alert.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_admin_phone'] ) ) {
	        if (  $input['eemr_admin_phone'] != "" ) {
	            $output['eemr_admin_phone'] =  sanitize_textarea_field($input['eemr_admin_phone']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Admin Phone Number.', $plugin_slug));
	        }
	    }

	    if ( isset( $input['eemr_admin_sms_template'] ) ) {
	        if (  $input['eemr_admin_sms_template'] != "" ) {
	            $output['eemr_admin_sms_template'] =  sanitize_textarea_field($input['eemr_admin_sms_template']) ;
	        } else {
	            add_settings_error( 'eemr_notification', 'otptxt-error', esc_html__( 'Please enter Admin SMS Alert Template.', $plugin_slug));
	        }
	    }

	    return apply_filters( 'eemr_notification', $output, $input );
	}
}
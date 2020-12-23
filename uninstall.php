<?php 
/*
 * Removes options from database when plugin is deleted.
 *  
 *
 */

# if uninstall not called from WordPress exit

	if (!defined('WP_UNINSTALL_PLUGIN' ))
	    exit();

	global $wpdb, $wp_version;

	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}eemr_woo_alert" );

	delete_option("eemr_plugin_version");

	wp_cache_flush();

?>
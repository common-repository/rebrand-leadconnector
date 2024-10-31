<?php
/**
 * Plugin Name: 	Rebrand LeadConnector
 * Plugin URI: 	    https://rebrandpress.com/rebrand-leadconnector/
 * Description: 	LeadConnector allows you to integrate CRM and conversational tools to your WordPress website. Customize your LeadConnector and change the button colors, tiles, and links to fit your own brand. You are able to change the name and description, removing all mention of LeadConnector, and even remove the “rebrand” option so clients don’t see.
 * Version:     	1.0
 * Author:      	RebrandPress
 * Author URI:  	https://rebrandpress.com/
 * License:     	GPL2 etc
 * Network:         Active
*/

if (!defined('ABSPATH')) { exit; }

if ( !class_exists('Rebrand_LeadConnector_lite') ) {
	
	class Rebrand_LeadConnector_lite {
		
		public function bzlc_load()
		{
			global $bzlc_load;
			load_plugin_textdomain( 'bzlc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			if ( !isset($bzlc_load) )
			{
			  require_once(__DIR__ . '/lc-settings.php');
			  $PluginLMS = new BZ_LC\BZRebrandLCSettings;
			  $PluginLMS->init();
			}
			return $bzlc_load;
		}
		
	}
}
$PluginRebrandLeadConnector = new Rebrand_LeadConnector_lite;
$PluginRebrandLeadConnector->bzlc_load();

<?php

/*
Plugin Name: ACF User Documentation
Plugin URI:
Description: A plugin that creates a section in the backend for creating and displaying User Documentation posts.
Version: 1.0
Author: Callum Hardy
Author URI: http://www.callumhardy.com.au
License: GPL
*/

//	Initialise the plugin after all plugins are loaded
//	Need to be sure ACF is loaded before we use Elliots sweet sweet functions now don't we!?
add_action( 'after_setup_theme', function(){
	include('ACF_User_Documentation.php');
});

$plugin_file = 'acf-user-documentation/plugin.php';
 
//	Adding a 'Settings" link o the WP Plugin page for this plugin'
function acf_descriptions_plugin_links( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'admin.php?page=user-documentation' ) . '">' . __( 'Documentation Page', 'content-split-pro' ) . '</a>';
	array_unshift( $links, $settings_link );
 
	return $links;
}

add_filter( "plugin_action_links_{$plugin_file}", 'acf_descriptions_plugin_links', 10, 2 );
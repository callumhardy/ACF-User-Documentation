<?php

/*
Plugin Name: User Documentation
Plugin URI:
Description: A plugin that creates a section in the backend for creating and displaying User Documentation posts.
Version: 1.0
Author: Callum Hardy
Author URI: http://www.callumhardy.com.au
License: GPL
*/

//	Initialise the plugin after theme is ready
add_action( 'after_setup_theme', function(){
	include('User_Documentation.php');
});

$plugin_file = 'acf-user-documentation/plugin.php';
 
//	Adding a 'Settings" link o the WP Plugin page for this plugin'
function user_documentation_link( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'admin.php?page=user-documentation' ) . '">' . __( 'Documentation Page', 'content-split-pro' ) . '</a>';
	array_unshift( $links, $settings_link );
 
	return $links;
}

add_filter( "plugin_action_links_{$plugin_file}", 'user_documentation_link', 10, 2 );
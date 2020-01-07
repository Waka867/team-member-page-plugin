<?php
/**
 * @package team_member_page
 * @version 1.0.0
 */
/*
Plugin Name: Team Member Page
Plugin URI: 
Description: This is a plugin meant to simplify the ability to set up a configurable team member page.
Author: Ledwing Hernandez
Version: 1.0.0
Requires at least: 5.0
Author URI: github.com/waka867
 */



class team_member {





}





// This section registers the team member post type, in addition containing behavior for when the plugin is activated
function  tmbp_post_type_registration( ) {
	register_post_type( 'team_member', [
		'label' 		=> 'Team Members',
		'public' 		=> true,
		'description' 		=> 'This refers to members of your team, business or organization.',
		//'register_meta_box_cb' => metaboxfunction
		'has_archive' 		=> true,
		'delete_with_user'	=> false,
		'show_in_menu'		=> true
	] );
}
add_action( 'init', 'tmbp_post_type_registration' );

function tmbp_install() {
    // trigger our function that registers the custom post type
    tmbp_post_type_registration();
 
    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'tmbp_install' );










// This section unregisters the team member post type, as well as containing behavior for when the plugin is deactivated
function tmbp_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'team_member' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'tmbp_deactivation' );
























?>

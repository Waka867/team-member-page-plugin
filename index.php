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



// Function for specifying what meta box fields will need to be created for the Team Member post type
function tmbp_meta_boxes() {

	//Add function that gets met info if it already exists
	function tmbp_get_meta_info(){

	};

	//add_meta_box( 'job_role', 'Job Role',  );

}
add_action( 'add_meta_boxes_team_member', 'tmbp_meta_boxes' );


// This section registers the team member post type, in addition containing behavior for when the plugin is activated
function  tmbp_post_type_registration( ) {
	register_post_type( 'team_member', [
		//'label' 		=> 'Team Members',
		'labels'		=> [
			'name'				=> 'Team Members',
			'singular_name'			=> 'Team Member',
			'add_new_item'			=> 'Add New Team Member',
			'new_item'			=> 'Add Team Member Name',
			'edit_item'			=> 'Edit Team Member',
			'view_item'			=> 'View Team Member',
			'view_items'			=> 'View Team Members',
			'search_items'			=> 'Search Team Members',
			'not_found'			=> 'No Team Members Found',
			'not_found_in_trash'		=> 'No Team Members Found In Trash',
			'all_items'			=> 'All Team Members',
			'archives'			=> 'Team Member Archives',
			'attributes'			=> 'Team Member Attributes',
			'insert_into_item'		=> 'Insert Into Team Member Profile',
			'uploaded_to_this_item'		=> 'Uploaded To This Team Member',
			'featured_image'		=> 'Team Member Profile Image',
			'set_featured_image'		=> 'Set Profile Image',
			'remove_featured_image'		=> 'Remove Profile Image',
			'use_featured_image'		=> 'Use As Profile Image',
			'filter_items_list'		=> 'Filter Team Members List',
			'items_list_navigation'		=> 'Team Member List Navigation',
			'items_list'			=> 'Team Member List',
			'item_published'		=> 'Team Member Profile Published',
			'item_published_privately'	=> 'Team Member Profile Published',
			'item_reverted_to_draft'	=> 'Team Member Profile Reverted To Draft',
			'item_scheduled'		=> 'Team Member Profile Scheduled',
			'item_updated'			=> 'Team Member Profile Updated'
		],
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

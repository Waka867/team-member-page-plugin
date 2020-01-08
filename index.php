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


function tmp_before_post( $content ) {

    global $post;

    $tmp_content = esc_attr( get_post_meta( $post->ID, '_global_notice', true ) );

    $notice = "<div class='sp_global_notice'>$tmp_content</div>";

    return $notice . $content;

}

add_filter( 'the_content', 'global_notice_before_post' );


// This section registers the team member post type, in addition containing behavior for when the plugin is activated
function  tmp_post_type_registration( ) {
	register_post_type( 'team_member', [
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
		'register_meta_box_cb' 	=> 'tmp_meta_boxes',
		'has_archive' 		=> true,
		'delete_with_user'	=> false,
		'show_in_menu'		=> true
	] );
}
add_action( 'init', 'tmp_post_type_registration' );






// Function for specifying what meta box fields will need to be created for the Team Member post type
function tmp_meta_boxes() {

	//Add function that gets meta info if it already exists
	//function tmp_get_meta_info();

	add_meta_box( 'job_role', 'Job Role', __( 'tmp_meta_box_content_cb', 'job_role' ) );
	//add_meta_box( 'job_role', 'Job Role', 'tmp_meta_box_content_cb' );
	//add_meta_box( 'job_role', 'Job Role', 'tmp_meta_box_content_cb' );
	//add_meta_box( 'job_role', 'Job Role', 'tmp_meta_box_content_cb' );
	//add_meta_box( 'job_role', 'Job Role', 'tmp_meta_box_content_cb' );
	//add_meta_box( 'job_role', 'Job Role', 'tmp_meta_box_content_cb' );
	//add_meta_box( 'job_role', 'Job Role', 'tmp_meta_box_content_cb' );
	//add_meta_box( 'job_role', 'Job Role', 'tmp_meta_box_content_cb' );
	//add_meta_box( 'job_role', 'Job Role', 'tmp_meta_box_content_cb' );

}
add_action( 'add_meta_boxes_team_member', 'tmp_meta_boxes' );






function tmp_meta_box_content_cb( $post, $mb_name ){

	//var_dump( $mb_name );
	//var_dump( $post );
	
	$mb_id	= $mb_name['id'];
	//echo $mb;
	//exit;

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'tmp_nonce', 'tmp_nonce' );

	$value = get_post_meta( $post->ID, "$mb_id", true );

	//var_dump( $value );
	//exit;

	echo "<input style='width:100%' id='tmp_$mb_id' name='tmp_$mb_id'>";
	echo esc_attr( $value );
	echo "</input>";

}





function tmp_save_meta_box_data( $post_id ){

	//var_dump( $post_id ); //Properly dumps post id
	//echo $_POST['tmp_nonce']; //Properly dumps nonce
	//exit;


	// Check if our nonce is set.
	if ( ! isset( $_POST['tmp_nonce'] ) ) {
	return;
	}


	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['tmp_nonce'], 'tmp_nonce' ) ) {
	return;
	} else {
		//echo "true"; //Properly shows that nonce is valid
		//exit;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
	    return;
	}

	}
	else {

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
	    return;
	}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	//echo $_POST['tmp_job_role'];//Properly shows input
	//exit;
	//
	//
	if ( ! isset( $_POST['tmp'] ) ) {
	return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['tmp'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_tmp', $my_data );

}
add_action( 'save_post', 'tmp_save_meta_box_data' );





function tmp_install() {
    // trigger our function that registers the custom post type
    tmp_post_type_registration();
 
    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'tmp_install' );










// This section unregisters the team member post type, as well as containing behavior for when the plugin is deactivated
function tmp_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'team_member' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'tmp_deactivation' );
























?>

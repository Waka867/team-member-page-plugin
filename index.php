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




$plugin_path	= dirname( __FILE__ );
//exit;



include $plugin_path . '/tmp_list_page.php';



// This function grabs the script.js file for use later
function tmp_starter() {

	wp_enqueue_script( 'script', plugin_dir_url( __FILE__ ) . 'scripts.js' );

}
add_action( 'init', 'tmp_starter' );





/*function tmp_before_post( $content ) {

    global $post;

    $tmp_content = esc_attr( get_post_meta( $post->ID, '_global_notice', true ) );

    $notice = "<div class='sp_global_notice'>$tmp_content</div>";

    return $notice . $content;

}
add_filter( 'the_content', 'global_notice_before_post' );i*/








// Theme support has to be added for thumbnails just in case the current theme does not already support it. Profile pics are handled by thumbnail functionality
add_theme_support( 'post-thumbnails' );












// This code generates a submenu for the Team Members plugin that will handle profile render order
function tmp_render_order_submenu_html(){
	// check user capabilities
	if (!current_user_can('manage_options')) {
		return;
 	}
	
 
?>
	<div class="wrap">
		<h1><?= esc_html(get_admin_page_title()); ?></h1>
		<form action="options.php" method="post">
		<h1>This is where we echo out profiles by order, let users drag-and-drop rearrange, then save that new order (somehow)</h1>
<?php
		// output security fields for the registered setting "wporg_options"
		//settings_fields('wporg_options');
		// output setting sections and their fields
		// (sections are registered for "wporg", each field is registered to a specific section)
		//do_settings_sections('wporg');
		// output save settings button
		//submit_button('Save Settings');
?>
		</form>
	</div>
<?php
}


function tmp_render_order_submenu()
{

	add_submenu_page(
		'edit.php?post_type=team_member',
		'Team Member Order',
		'Member Order',
		'manage_options',
		'tmp_render_order',
		'tmp_render_order_submenu_html'
	);
}
add_action('admin_menu', 'tmp_render_order_submenu');














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
			'item_updated'			=> 'Team Member Profile Updated',
		],
		'public' 		=> true,
		'supports'		=> array( 'thumbnail', 'description', 'title', 'editor', 'revisions' ),
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

	add_meta_box( 'tmp_job_role', 'Job Role', __( 'tmp_meta_box_content_cb', 'job_role' ) );
	add_meta_box( 'tmp_branch', 'Branch', __( 'tmp_meta_box_content_cb', 'branch' ) );
	add_meta_box( 'tmp_start_year', 'Year Started With Team', __( 'tmp_meta_box_content_cb', 'start_year' ) );
	add_meta_box( 'tmp_favorite_quote', 'Favorite Quote', __( 'tmp_meta_box_content_cb', 'favorite_quote' ) );
	add_meta_box( 'tmp_phone', 'Phone Number', __( 'tmp_meta_box_content_cb', 'phone' ) );
	add_meta_box( 'tmp_email', 'Contact Email', __( 'tmp_meta_box_content_cb', 'email' ) );
	add_meta_box( 'tmp_order', 'Display Order', __( 'tmp_meta_box_content_cb', 'order' ) );

}
add_action( 'add_meta_boxes_team_member', 'tmp_meta_boxes' );





// This function generates meta box fields, field type and behavior
function tmp_meta_box_content_cb( $post, $mb_name ){
	// Add a nonce field so we can check for it later.
	wp_nonce_field( "tmp_nonce", "tmp_nonce" );
	
	
	$mb_id			= $mb_name['id'];
	$value 			= get_post_meta( $post->ID, "$mb_id", true );
	$escaped_value		= esc_attr( $value );


	// This switch generates different layouts for different inputs
	switch( $mb_id ) {

		case "tmp_branch":
			echo "
			<select style='width:100%' id='" . $mb_id . "_dropdown' name='$mb_id' data-selected='$escaped_value'>	
				<option  value=''>Select Branch</option>	
				<option  value='atlanta'>Atlanta</option>	
				<option  value='boston'>Boston</option>	
				<option  value='chicago'>Chicago</option>	
				<option  value='dc'>Washington, D.C.</option>	
				<option  value='houston'>Houston</option>	
				<option  value='las_vegas'>Las Vegas</option>	
				<option  value='miami'>Miami</option>	
				<option  value='san_francisco'>San Francisco</option>	
				<option  value='seattle'>Seattle</option>	
				<option  value='st_paul'>St. Paul</option>	
			</select>
			<script>
				// This code updates the selected dropdown option to reflect whats in the database
				var opList 	= document.getElementById( '" . $mb_id . "_dropdown' ).options;
				var selVal	= document.getElementById( '" . $mb_id . "_dropdown' ).dataset.selected; 


				for( x = 0; x < opList.length; x++ ){
					/*console.log(  opList[x].value );
					console.log( selVal );*/
					
					var va	= opList[x].value 

					if( va == selVal ) {

						console.log( 'almost there' );
						opList[x].selected	= true
						/*opList[x].defaultSelected	= true*/


					}

				}

			</script>
			";
			break;

		default:
			echo "<input style='width:100%' id='$mb_id' name='$mb_id' value='$escaped_value'></input>";
			break;

	}




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



	//echo var_dump( $_POST );
	//exit;


	// This section handles actually updating meta info
	// Checks Post Data
	/*if ( ! isset( $_POST['tmp_job_role'] ) ) {
		return;
	}*/

	if ( !isset( $_POST ) ) {
		return;
	}

	// List to be used for iteration and then sanitization
	$meta_field_list	= array(
		'tmp_job_role',
		'tmp_branch',
		'tmp_start_year',
		'tmp_favorite_quote',
		'tmp_phone',
		'tmp_email',
		'tmp_order'
	);

	foreach( $meta_field_list as $mf ) {
		
		$mf_sanitized = sanitize_text_field( $_POST[ "$mf" ] );

		
		// Update the meta field in the database.
		update_post_meta( $post_id, "$mf", $mf_sanitized );
	}


}
add_action( 'save_post', 'tmp_save_meta_box_data' );





function tmp_install() {
    // trigger our function that registers the custom post type
    tmp_post_type_registration();
 
    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'tmp_install' );






// Add shortcode that can be added to a page to display the team member list
add_shortcode( 'tmp_list', 'tmp_list_generator' );
function tmp_list_generator(){

	echo "<h1>TEAM MEMBER PLUGIN</h1>";

	$tmp_posts = get_posts( [
		// Limits plugin to loading 100 team members, unlikely for someone to put that many people on a page
		'numberposts' 	=> 100,
		'post_type'	=> 'team_member',
		'post_status'	=> array( 
			'publish',
			'private'
		)
	
	] );


	//var_dump( $tmp_posts );

	foreach( $tmp_posts as $value ){
		tmp_profile_page_builder( $value );
	}



}






















// This section unregisters the team member post type, as well as containing behavior for when the plugin is deactivated
function tmp_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'team_member' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'tmp_deactivation' );


?>

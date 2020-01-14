<?php

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
		<h3>xxx</h3>
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

?>

<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.example.com/
 * @since      1.0.0
 *
 * @package    Content_By_Role
 * @subpackage Content_By_Role/admin/partials
 */

// TODO: Document this and built out the settings page interface
function content_by_role_admin_display() {
	
	?>
	<form method='post'>
	<?php
	
		echo "<h1>Hello World!</h1>";
		settings_fields( 'content-by-role_settings' );
		do_settings_sections( 'content-by-role_restricted_pages_settings' );
		submit_button();
	
	?>
	</form>
	<?php
		
}

function content_by_role_restricted_pages_settings_section_header() {
	echo "<h2>Restricted Pages</h2>";
}

function content_by_role_restricted_pages_select() {
	echo "<p>Restricted Page: </p>";
}
<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/mguay22/content-by-role
 * @since      1.0.0
 *
 * @package    Content_By_Role
 * @subpackage Content_By_Role/admin/partials
 */


function content_by_role_options_page() {

	?>
	<form action='options.php' method='post'>

		<h1>Content By Role</h1>

		<?php
		
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );	
		submit_button( 'Save Redirects' );

		?>

	</form>
	<?php

}

function content_by_role_select_0_render() {
	
	?>
	<select name='content_by_role_settings[content_by_role_select_0]'>
		<option value="">
		<?php echo esc_attr( __( 'Select Page', 'content-by-role' ) ); ?></option>
		<?php
		 $pages = get_pages();
		 foreach ( $pages as $page ) {
		   $option = '<option value="' . $page->post_title . '">';
		   $option .= $page->post_title;
		   $option .= '</option>';
		   echo $option;
		 }
		?>
   </select>
	<div class="tooltip">?
		<span class="tooltiptext">Select the page you'd like to restrict access to.</span>
	</div>
	<?php

}

function content_by_role_checkbox_0_render() {

	$roles = wp_roles()->get_names();

	foreach( $roles as $role ) {

		$option = '<input type="checkbox" name="content_by_role_settings[content_by_role_checkbox_0][]" value="' . translate_user_role( $role ) . '" ';
		$option .= '/>';

		$option_label = '<label class="content_by_role_checkboxes" for="content_by_role_settings[content_by_role_checkbox_0]">' . translate_user_role( $role ) . '</label>';

		echo $option;
		echo $option_label;

	}
	
	?>

<input type="checkbox" name="content_by_role_settings[content_by_role_checkbox_0][]" value="Guest">
<label for="content_by_role_settings[content_by_role_checkbox_0]">Guest</label>
<div class="tooltip">?
	<span class="tooltiptext">Select the role(s) you'd like to restrict access to.</span>
</div>

	<?php

}

function content_by_role_input_0_render() {

	?>

	<input class="content_by_role_input" type="text" placeholder="URL" name="content_by_role_settings[content_by_role_input_0]"/>
	<div class="tooltip">?
		<span class="tooltiptext">Enter the URL the restricted role(s) should be redirected to.</span>
	</div>
	<?php


}


function content_by_role_settings_section_callback(  ) {

	echo __( 'Choose your restricted pages below and assign a redirect based on the users role',
	'content-by-role' );	

}

function content_by_role_redirect_table_render() {
	
	include 'content-by-role-redirect-table.php';
	content_by_role_redirect_table();
	
}

function content_by_role_save_data( $options ) {
	
	$delete = false;
	global $wpdb;
	
	// Get the currently saved redirects and turn it into an accessible array
	$results = $wpdb->get_results( 'SELECT * FROM wp_content_by_role' );
	$results_array = json_decode(json_encode($results), True);
	
	// If a redirect is set for deletion, compare its ID to all redirects, and query the DB to delete
	for ($i = 0; $i < sizeof($results_array); $i++) {
		if ( isset($_POST['delete_' . $i]) ) {
			$delete = true;
			$id = $results_array[$i]['id'];
			$wpdb->delete( 'wp_content_by_role', array( 'id' => $id ) );
		} 
	}
	
	// If we've deleted, finish all operations and exit
	if ( $delete ) {
		return;
	}
	
	if ( $options != null ) {
		// Make sure all redirect options are set
		
		if ( $options['content_by_role_select_0'] != null ) {
			$redirect_page = $options['content_by_role_select_0'];
		}

		if ( !empty($options['content_by_role_checkbox_0']) ) {
			$roles = $options['content_by_role_checkbox_0'];
		}

		if ( $options['content_by_role_input_0'] != null ) {
			$url = $options['content_by_role_input_0'];
		}		
		
		// Make sure that the user doesn't try adding a redirect for a page and role that already exists
		if ( isset($redirect_page) || isset($roles) || isset($url) ) {
		
			for ($i = 0; $i < sizeof($results_array); $i++) {
				$current_row = $results_array[$i];
				$saved_restricted_page = $current_row['restricted_page'];
				$saved_role = $current_row['role'];
				
				// Traverse through all of the roles the user may have selected to restrict
				for ($j = 0; $j < sizeof($roles); $j++) {
					
					// If in fact one of the roles is found to already exist in a restricted page, throw error and exit
					if ( $redirect_page == $saved_restricted_page && $saved_role == $roles[$j] ) {
						// Throw error
						$type = 'error';
						$message = __( 'A redirect already exists for that page & role.', 'content-by-role' );

						add_settings_error(
							'content_by_role',
							esc_attr( 'settings_updated' ),
							$message,
							$type
						);

						return;
					}

				}
			}
			
		}
		
		// If the user left an option blank, throw error
		if ( !isset($redirect_page) || !isset($roles) || !isset($url) ) {

			// Throw error
			$type = 'error';
			$message = __( 'One or more field(s) missing.', 'content-by-role' );

			add_settings_error(
				'content_by_role',
				esc_attr( 'settings_updated' ),
				$message,
				$type
			);
		
		// Else, we can add the new redirect to the DB
		} else {

			$table_name = $wpdb->prefix . 'content_by_role';

			for ($i = 0; $i < sizeof($roles); $i++) {
				$wpdb->insert( 
				$table_name, 
					array( 
						'restricted_page' =>sanitize_text_field( $redirect_page ), 
						'role' => sanitize_text_field( $roles[$i] ), 
						'redirect_url' => esc_url( $url ), 
					) 
				);
			}

		}
	}
}
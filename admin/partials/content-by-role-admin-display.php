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


function content_by_role_options_page() {

	?>
	<form action='options.php' method='post'>

		<h1>Content By Role</h1>

		<?php
		
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );	
		submit_button();

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
	<?php

}

function content_by_role_checkbox_0_render() {

	$roles = wp_roles()->get_names();

	foreach( $roles as $role ) {

		$option = '<input type="checkbox" name="content_by_role_settings[content_by_role_checkbox_0][]" value="' . translate_user_role( $role ) . '" ';
		$option .= '/>';

		$option_label = '<label for="content_by_role_settings[content_by_role_checkbox_0]">' . translate_user_role( $role ) . '</label>';

		echo $option;
		echo $option_label;

	}

}

function content_by_role_input_0_render() {

	?>

	<input type="text" placeholder="URL" name="content_by_role_settings[content_by_role_input_0]"/>

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

function save_to_database( $options ) {
	global $wpdb;

	if ( $options != null ) {

		if ( $options['content_by_role_select_0'] != null ) {
			$redirect_page = $options['content_by_role_select_0'];
		}

		if ( !empty($options['content_by_role_checkbox_0']) ) {
			$roles = $options['content_by_role_checkbox_0'];
		}

		if ( $options['content_by_role_input_0'] != null ) {
			$url = $options['content_by_role_input_0'];
		}		

		if ( !isset($redirect_page) || !isset($roles) || !isset($url) ) {

			// Throw error
			$type = 'error';
			$message = __( 'Please fill out all fields', 'my-text-domain' );

			add_settings_error(
				'content_by_role',
				esc_attr( 'settings_updated' ),
				$message,
				$type
			);


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
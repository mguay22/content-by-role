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

	$options = get_option( 'content_by_role_settings' );
	?>
	<select name='content_by_role_settings[content_by_role_select_0]'>
		<option value="">
		<?php echo esc_attr( __( 'Select Page', 'content-by-role' ) ); ?></option>
		<?php
		 $pages = get_pages();
		 foreach ( $pages as $page ) {
		   $option = '<option value="' . $page->post_title . '"'. selected( $options['content_by_role_select_0'], $page->post_title ) . '>';
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
	$options = get_option( 'content_by_role_settings' );

	foreach( $roles as $role ) {

		$option = '<input type="checkbox" name="content_by_role_settings[content_by_role_checkbox_0][]" value="' . translate_user_role( $role ) . '" ';

		if ( isset( $options['content_by_role_checkbox_0'] ) && in_array( translate_user_role( $role ), $options['content_by_role_checkbox_0'] ) ) {
			$option .= 'checked';
		}
		$option .= '/>';

		$option_label = '<label for="content_by_role_settings[content_by_role_checkbox_0]">' . translate_user_role( $role ) . '</label>';

		echo $option;
		echo $option_label;

	}

}

function content_by_role_input_0_render() {

	$options = get_option( 'content_by_role_settings' );

	?>

	<input type="text" placeholder="URL" name="content_by_role_settings[content_by_role_input_0]" value="<?php esc_html_e( $options['content_by_role_input_0'] ); ?>"/>

	<?php


}


function content_by_role_settings_section_callback(  ) {

	echo __( 'Choose your restricted pages below and assign a redirect based on the users role',
	'content-by-role' );

}

<?php

/**
 * Generates the table of current redirects on the plugin settings page
 *
 * This file is used to markup and populate the table of current redirects on the settings page
 *
 * @link       https://github.com/mguay22/content-by-role
 * @since      1.0.0
 *
 * @package    Content_By_Role
 * @subpackage Content_By_Role/admin/partials
 */

function content_by_role_redirect_table() {
	
	// Get the current redirects stored in the database
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM wp_content_by_role' );
	
	// Convert to readable array
	$results_array = json_decode(json_encode($results), True);

	
?>

	<table class="table">
		<thead>
		  <tr>
			<th scope="col">Delete Redirect</th>
			<th scope="col">Restricted Page</th>
			<th scope="col">Roles</th>
			<th scope="col">Redirect</th>
		  </tr>
		</thead>
		<tbody>
		  <?php
		  
		  // Go through redirects and output to table
		  for ($i = 0; $i < sizeof($results_array); $i++) {
			$current_row = $results_array[$i];

			$restricted_page = $current_row['restricted_page'];
			$role = $current_row['role'];
			$redirect = $current_row['redirect_url'];

			?>
			
			<tr>
				<th scope="row">
					<input type='checkbox' name="delete_<?php echo $i; ?>" value='Delete' />
				</th>
				<td><?php echo $restricted_page; ?></td>
				<td><?php echo $role; ?></td>
				<td><?php echo $redirect; ?></td>
			</tr>
			  <?php
		  }
		  
		  ?>
		</tbody>
	</table>

<?php
}
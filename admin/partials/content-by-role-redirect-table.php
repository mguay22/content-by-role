<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function content_by_role_redirect_table() {
	
	// Get the current redirects store in the database
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
		  
		  for ($i = 0; $i < sizeof($results_array); $i++) {
			$current_row = $results_array[$i];

			$restricted_page = $current_row['restricted_page'];
			$role = $current_row['role'];
			$redirect = $current_row['redirect_url'];

			?>
			
			<tr>
				<th scope="row"><a href="#remove_redirect">Delete</a></th>
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
<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/mguay22/content-by-role
 * @since      1.0.0
 *
 * @package    Content_By_Role
 * @subpackage Content_By_Role/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Content_By_Role
 * @subpackage Content_By_Role/includes
 * @author     Michael Guay <guay.me@gmail.com>
 */
class Content_By_Role_Activator {

	/**
	 * Create table for database
	 *
	 * @since    1.0.0
	 */
	public static function activate() {		
		global $wpdb;
		$table_name = $wpdb->prefix . "content_by_role";
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			restricted_page text NOT NULL,
			role text NOT NULL,
			redirect_url varchar(55) DEFAULT '' NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}

}

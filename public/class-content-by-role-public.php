<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/mguay22/content-by-role
 * @since      1.0.0
 *
 * @package    Content_By_Role
 * @subpackage Content_By_Role/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Content_By_Role
 * @subpackage Content_By_Role/public
 * @author     Michael Guay <guay.me@gmail.com>
 */
class Content_By_Role_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * All currently saved redirects
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $redirects    All redirects
	 */
	private $redirects;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;


	}

	/**
	 * Adds the redirects to the correct page
	 *
	 * @since    1.0.0
	 * @param      Object    $user       The current user
	 */
	public function add_redirect( $user ) {
		global $wpdb;

		// Convert to readable array
		$this->redirects = json_decode(json_encode( $wpdb->get_results( 'SELECT * FROM wp_content_by_role' ) ), True);

		// Get the current user role, set to guest if not logged in
		$user = $user ? new WP_User( $user ) : wp_get_current_user();
		$user = $user->roles ? $user->roles[0] : 'guest';

		for ($i = 0; $i < sizeof($this->redirects); $i++) {
			$current_row = $this->redirects[$i];

			$restricted_page = $current_row['restricted_page'];
			$role = $current_row['role'];
			$redirect = $current_row['redirect_url'];

			// If this page matches all criteria for redirect, then execute it
			if ( is_page( $restricted_page ) ) {
				if ( $user == strtolower( $role ) ) {
					wp_redirect( $redirect );
				}
			}

		}

	}

}

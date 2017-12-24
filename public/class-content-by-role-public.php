<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.example.com/
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

	private $plugin_settings;

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
		$this->plugin_settings = get_option( 'content_by_role_settings' );
		//$this->add_redirect();
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Content_By_Role_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Content_By_Role_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/content-by-role-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Content_By_Role_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Content_By_Role_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/content-by-role-public.js', array( 'jquery' ), $this->version, false );

	}

	public function add_redirect( $user ) {

		$redirect_page = $this->plugin_settings['content_by_role_select_0'];
		
		if ( !empty( $this->plugin_settings['content_by_role_checkbox_0'] ) ) {
			$restricted_roles = $this->plugin_settings['content_by_role_checkbox_0'];
		}
				
		if ( !empty( $restricted_roles ) ) {
		
			$user = $user ? new WP_User( $user ) : wp_get_current_user();
			$user = $user->roles ? $user->roles[0] : false;
			$redirect = $this->plugin_settings['content_by_role_input_0'];

			$restricted_roles = array_map('strtolower', $restricted_roles);	

			if ( is_page( $redirect_page ) ) {
				if ( in_array( $user, $restricted_roles ) ) {
					wp_redirect( $redirect );
				}
			}
		
		}
		
	}

}

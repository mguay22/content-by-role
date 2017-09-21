<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.example.com/
 * @since      1.0.0
 *
 * @package    Content_By_Role
 * @subpackage Content_By_Role/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Content_By_Role
 * @subpackage Content_By_Role/admin
 * @author     Michael Guay <guay.me@gmail.com>
 */
class Content_By_Role_Admin {

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
         * @since    1.0.0
         * @access   private
         * @var      string    $admin_display    Displays the settings page.
         */
        private $admin_display;
        
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/content-by-role-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since   1.0.0
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/content-by-role-admin.js', array( 'jquery' ), $this->version, false );

	}
        
        /**
	 * Load the required dependencies for the plugin admin area.
	 *
	 * Include the following files that make up the plugin admin area:
	 *
	 * - Content_By_Role_Admin_Display. Displays the backend settings page.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
        private function load_dependencies() {
            
            require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'partials/content-by-role-admin-display.php' );
            
            $this->admin_display = $this->plugin_name . '_admin_display';
            
        }
        
        /**
         * Create the settings page for our plugin.
         * 
         * @since   1.0.0  
         */
        public function create_settings_page() {
            
            add_options_page( 
                            'General Settings', 
                            'Content by Role', 
                            'manage_options',
                            'content_by_role_settings_page.php', 
                            'content_by_role_admin_display'
                    );
                        
        }

}

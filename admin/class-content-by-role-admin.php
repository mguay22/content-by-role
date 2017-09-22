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
	 * The slug for the plugin setting page.
	 * 
	 * @since	 1.0.0
	 * @access	 private
	 * @var		 string	   $settings_page_slug	 The slug for the plugin settings page.
	 */
	private $settings_page_slug;
        
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
                
		$this->load_dependencies();
		$this->settings_page_slug = 'content-by-role_settings_page';

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
            
            require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/content-by-role-admin-display.php' );
                        
        }
        
        /**
         * Create the settings page for our plugin.
         * 
         * @since   1.0.0  
         */
        public function create_settings_page() {
            
            add_options_page( 
				esc_html__( 'General Settings', 'content-by-role' ), 
				esc_html__( 'Content by Role', 'content-by-role' ),
				'manage_options',
				$this->settings_page_slug, 
				'content_by_role_admin_display'
            );
                        
        }
        
        /**
         * Register our settings and create our fields
         * 
         * @since   1.0.0
         */
        public function register_settings() {
			
			register_setting( $this->settings_page_slug, 'content-by-role_settings' );
			
			add_settings_section(
				'content-by-role_restricted_pages_settings',
				esc_html__( 'Restricted Pages', 'content-by-role' ),
				'content_by_role_restricted_pages_settings_section_header',
				$this->settings_page_slug
			);
						
			add_settings_field(
				'content-by-role_restricted-pages_field',
				esc_html__( 'Restricted Page', 'content-by-role' ),
				'content_by_role_restricted_pages_select',
				$this->settings_page_slug,
				'content-by-role_restricted_pages_settings'
			);
            
        }

}

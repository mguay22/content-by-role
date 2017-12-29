<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/mguay22/content-by-role
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
	 * @since      1.0.0
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/content-by-role-admin.css', array(), $this->version, 'all' );
		
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
		'Content By Role', 
		'Content By Role', 
		'manage_options', 
		'content_by_role', 
		'content_by_role_options_page' 
		);	
		
	}
		
	/**
	 * Initialize the settings page
	 * 
	 * @since	 1.0.0
	 */
	public function settings_init() {

		register_setting( 'pluginPage', 'content_by_role_settings', array('sanitize_callback' => 'content_by_role_save_data') );

		add_settings_section(
			'content_by_role_pluginPage_section', 
			__( '', 'content-by-role' ), 
			'content_by_role_settings_section_callback', 
			'pluginPage'
		);

		add_settings_field( 
			'content_by_role_select_0', 
			__( 'Restricted Page:', 'content-by-role' ), 
			'content_by_role_select_0_render', 
			'pluginPage', 
			'content_by_role_pluginPage_section' 
		);

		add_settings_field(
			'content_by_role_checkbox_0',
			__( 'Restricted Roles:', 'content-by-role' ),
			'content_by_role_checkbox_0_render',
			'pluginPage',
			'content_by_role_pluginPage_section'
		);

		add_settings_field(
			'content_by_role_input_0',
			__( 'Redirect: ', 'content-by-role' ),
			'content_by_role_input_0_render',
			'pluginPage',
			'content_by_role_pluginPage_section'
		);
		
		add_settings_field(
			'content_by_role_redirect_table',
			__( '', 'content-by-role' ),
			'content_by_role_redirect_table_render',
			'pluginPage',
			'content_by_role_pluginPage_section'
		);				

	}
	
}

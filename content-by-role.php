<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link			  https://github.com/mguay22/content-by-role
 * @since             1.0.0
 * @package           Content_By_Role
 *
 * @wordpress-plugin
 * Plugin Name:       Content By Role
 * Plugin URI:        https://wordpress.org/plugins/content-by-role
 * Description:       Allows multiple redirects to be added to a restricted page based off of the user's role on the site.
 * Version:           1.0.0
 * Author:            Michael Guay
 * Author URI:        https://github.com/mguay22
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       content-by-role
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CONTENT_BY_ROLE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-content-by-role-activator.php
 */
function activate_content_by_role() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-by-role-activator.php';
	Content_By_Role_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_content_by_role' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-content-by-role.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_content_by_role() {

	$plugin = new Content_By_Role();
	$plugin->run();

}
run_content_by_role();

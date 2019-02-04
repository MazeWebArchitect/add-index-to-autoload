<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin admin area.
 * This file also includes all of the dependencies used by the plugin, registers the activation and deactivation
 * functions, and defines a function that starts the plugin.
 *
 * @link              https://raidboxes.io
 * @since             1.0.0
 * @package           Add_Index_To_Autoload
 *
 * @wordpress-plugin
 * Plugin Name:       Add Index To Autoload
 * Plugin URI:        https://raidboxes.io
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Matthias Held at RAIDBOXES
 * Author URI:        https://web-architect.me
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       add-index-to-autoload
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-add-index-to-autoload-activator.php
 */
function activate_add_index_to_autoload() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-add-index-to-autoload-activator.php';
	Add_Index_To_Autoload_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-add-index-to-autoload-deactivator.php
 */
function deactivate_add_index_to_autoload() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-add-index-to-autoload-deactivator.php';
	Add_Index_To_Autoload_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_add_index_to_autoload' );
register_deactivation_hook( __FILE__, 'deactivate_add_index_to_autoload' );

/**
 * The core plugin class that is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-add-index-to-autoload.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_add_index_to_autoload() {

		// Defines the path to the main plugin file
		define( 'AITAL_FILE', __FILE__ );

		// Defines the path to be used for includes
		define( 'AITAL_PATH', plugin_dir_path( AITAL_FILE ) );

		// Defines the URL to the plugin
		define( 'AITAL_URL', plugin_dir_url( AITAL_FILE ) );

		// Defines the current version of the plugin
		define( 'AITAL_VERSION', '1.0.0' );

		// Run the plugin
		$plugin = new Add_Index_To_Autoload();
		$plugin->run();

}
run_add_index_to_autoload();
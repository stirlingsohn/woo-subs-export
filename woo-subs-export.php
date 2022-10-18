<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://reflekt.ch
 * @since             1.0.0
 * @package           Woo_Subs_Export
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Subscriptions Exporter
 * Plugin URI:        https://reflekt.ch
 * Description:       Export Woocommerce subscriptions to .csv file with ease!
 * Version:           1.0.0
 * Author:            Stirling Tschan
 * Author URI:        https://reflekt.ch
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-subs-export
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_SUBS_EXPORT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-subs-export-activator.php
 */
function activate_woo_subs_export() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-subs-export-activator.php';
	Woo_Subs_Export_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-subs-export-deactivator.php
 */
function deactivate_woo_subs_export() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-subs-export-deactivator.php';
	Woo_Subs_Export_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_subs_export' );
register_deactivation_hook( __FILE__, 'deactivate_woo_subs_export' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-subs-export.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_subs_export() {

	$plugin = new Woo_Subs_Export();
	$plugin->run();

}
run_woo_subs_export();

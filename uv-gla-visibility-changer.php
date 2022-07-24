<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://uvoglu.com
 * @since             1.0.0
 * @package           Uv_Gla_Visibility_Changer
 *
 * @wordpress-plugin
 * Plugin Name:       Product Visibility Changer (GLA)
 * Plugin URI:        https://uvoglu.com
 * Description:       Change Google Listings & Ads product visibility for defined amount of products at once.
 * Version:           1.0.0
 * Author:            UVOGLU
 * Author URI:        https://uvoglu.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       uv-gla-visibility-changer
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
define( 'UV_GLA_VISIBILITY_CHANGER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-uv-gla-visibility-changer-activator.php
 */
function activate_uv_gla_visibility_changer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uv-gla-visibility-changer-activator.php';
	Uv_Gla_Visibility_Changer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-uv-gla-visibility-changer-deactivator.php
 */
function deactivate_uv_gla_visibility_changer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uv-gla-visibility-changer-deactivator.php';
	Uv_Gla_Visibility_Changer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_uv_gla_visibility_changer' );
register_deactivation_hook( __FILE__, 'deactivate_uv_gla_visibility_changer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-uv-gla-visibility-changer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_uv_gla_visibility_changer() {
	$plugin = new Uv_Gla_Visibility_Changer();
	$plugin->run();
}
run_uv_gla_visibility_changer();

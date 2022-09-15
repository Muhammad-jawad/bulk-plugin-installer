<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jawadarshad.io/
 * @since             1.0.0
 * @package           Bulk_Plugin_Installer
 *
 * @wordpress-plugin
 * Plugin Name:       Bulk Plugin Installer
 * Plugin URI:        https://jawadarshad.io/
 * Description:       This plugin is created to save the time of installing plugin one by one. All you have to do is Install Plugin, Drag & Drop your plugins at once and press activate.
 * Version:           1.0.1
 * Author:            Jawad Arshad
 * Author URI:        https://jawadarshad.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bulk-plugin-installer
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
$bpi_upload_dir = wp_upload_dir();
define( 'BULK_PLUGIN_INSTALLER_VERSION', '1.0.0' );
define('BPIUPLOADDIR_PATH', $bpi_upload_dir['basedir']);
define('BPIPLUGIN_PATH', plugin_dir_path(__FILE__));
define('BPIPLUGIN_URL', plugin_dir_url(__FILE__));
define('BPI_WP_PLUGIN_DIR',dirname(plugin_dir_path(__FILE__)));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bulk-plugin-installer-activator.php
 */
function activate_bulk_plugin_installer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bulk-plugin-installer-activator.php';
	Bulk_Plugin_Installer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bulk-plugin-installer-deactivator.php
 */
function deactivate_bulk_plugin_installer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bulk-plugin-installer-deactivator.php';
	Bulk_Plugin_Installer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bulk_plugin_installer' );
register_deactivation_hook( __FILE__, 'deactivate_bulk_plugin_installer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bulk-plugin-installer.php';

/**
 * Plugin class that is used to check plugin update,
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path( __FILE__ ) . 'update/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/Muhammad-jawad/bulk-plugins-installer.git/',
    __FILE__,
    'bulk-plugin-installer'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

//Optional: If you're using a private repository, specify the access token like this:
// $myUpdateChecker->setAuthentication('your-token-here');



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bulk_plugin_installer() {

	$plugin = new Bulk_Plugin_Installer();
	$plugin->run();

}
run_bulk_plugin_installer();
<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://jawadarshad.io/
 * @since      1.0.0
 *
 * @package    Bulk_Plugin_Installer
 * @subpackage Bulk_Plugin_Installer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Bulk_Plugin_Installer
 * @subpackage Bulk_Plugin_Installer/includes
 * @author     Jawad Arshad <jaaviarshad@gmail.com>
 */
class Bulk_Plugin_Installer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bulk-plugin-installer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

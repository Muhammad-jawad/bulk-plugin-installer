<?php

/**
 * Fired during plugin activation
 *
 * @link       https://jawadarshad.io/
 * @since      1.0.0
 *
 * @package    Bulk_Plugin_Installer
 * @subpackage Bulk_Plugin_Installer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bulk_Plugin_Installer
 * @subpackage Bulk_Plugin_Installer/includes
 * @author     Jawad Arshad <jaaviarshad@gmail.com>
 */
class Bulk_Plugin_Installer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if(!is_dir(BPIUPLOADDIR_PATH.'/bpi_logs')){ @mkdir(BPIUPLOADDIR_PATH.'/bpi_logs', 0777);}
        if(!is_dir(BPIUPLOADDIR_PATH.'/bpi_logs/files')){ @mkdir(BPIUPLOADDIR_PATH.'/bpi_logs/files', 0777);}
        if(!is_dir(BPIUPLOADDIR_PATH.'/bpi_logs/files/tmp')){ @mkdir(BPIUPLOADDIR_PATH.'/bpi_logs/files/tmp', 0777);}
	}

}

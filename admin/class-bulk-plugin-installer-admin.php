<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://jawadarshad.io/
 * @since      1.0.0
 *
 * @package    Bulk_Plugin_Installer
 * @subpackage Bulk_Plugin_Installer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bulk_Plugin_Installer
 * @subpackage Bulk_Plugin_Installer/admin
 * @author     Jawad Arshad <jaaviarshad@gmail.com>
 */
class Bulk_Plugin_Installer_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->key = 'bulk_plugin_installer';
		add_action( 'admin_menu', array( $this, 'Bulk_Plugin_Installer_add_menu' ) );

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
		 * defined in Bulk_Plugin_Installer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bulk_Plugin_Installer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bulk-plugin-installer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bulk_Plugin_Installer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bulk_Plugin_Installer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bulk-plugin-installer-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function Bulk_Plugin_Installer_add_menu() {
		/**
		 * Register admin menu page.
		 */
	    add_menu_page('Bulk Plugin Installer Page', 'Bulk Plugin Installer', 'administrator','bulk_plugin_installer', array( $this, 'Bulk_Plugin_Installer_settings' ) , 'dashicons-plugins-checked', 65);
	}


	public function Bulk_Plugin_Installer_settings(){
	/**
	 * The class responsible for displaying frontend of admin area
	 * Menu Callback fn()
	 */

	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/bulk-plugin-installer-admin-display.php';
	}

	public function Bulk_Plugin_Installer_DirPermission(){
		if(!is_dir(BPIUPLOADDIR_PATH.'/bpi_testing')){ 
			if(@mkdir(BPIUPLOADDIR_PATH.'/bpi_testing', 0777)){
				@rmdir(BPIUPLOADDIR_PATH.'/bpi_testing');
				return true;
			}
			else
			return false;
		}
	}


	public function Bulk_Plugin_Installer_plugin_uploading_logs(){
		check_admin_referer($this->key);
		_e('<h3>Plugin installation process:</h3>','bulk-plugin-installer');

		$plugins_upload_files = $_FILES['bulk_plugin_installer_locFiles']['error'];
		$uploads_dir =  BPIUPLOADDIR_PATH . '/bpi_logs/files/tmp/';
		
		foreach ($plugins_upload_files as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
		        $file_tmp_name = $_FILES["bulk_plugin_installer_locFiles"]["tmp_name"][$key];
		        $file_name = $_FILES["bulk_plugin_installer_locFiles"]["name"][$key];

		        //var_dump($file_name);

 
		        //$file_name = str_replace($Fileregex, "", $file_name);
		        $file_name_update = preg_replace('/( \(.*\))/', '', $file_name);
		       // var_dump($file_name_update);
		        if(move_uploaded_file($file_tmp_name, "$uploads_dir$file_name_update"))
		        {
		        	$bpi_temp_plugins_urls[] = $uploads_dir . $file_name_update;
		        }
		    }
		}
		

		if($bpi_temp_plugins_urls && !empty($bpi_temp_plugins_urls))
		{
			$this->bulk_plugin_installer_filter_files($bpi_temp_plugins_urls,"plugin_activate" );
		}
		

	}


	public function bulk_plugin_installer_filter_files($plugins_urls_arr,$bulk_plugins_action)
	{
        
        if (!function_exists('fsockopen')) return false;
        
        foreach ($plugins_urls_arr as $plugin_url){
            $plugin_url = trim($plugin_url);
            
			$get_extension = explode('.', $plugin_url);
			$file_extension = end($get_extension);
			

            if ($file_extension == 'zip'){
               $this->bulk_plugin_installer_plugin_install_download($plugin_url,$bulk_plugins_action,);
            }
        }
    
    }

    	// download the plugin handler form the wordpress org
    function bulk_plugin_installer_plugin_install_download($package,$bulk_plugin_installer_action)
	{
		global $wp_version;

		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

		// If using version less than 3
		if(version_compare($wp_version, '3.0', '<'))
		{
			$plugin_upgrader = new Plugin_Upgrader(); 
         $plugin_upgrader->install($package);
           // Donot activate and show message to user to activate manually
        	if ($plugin_upgrader->plugin_info()){
        		echo "We have install this plugin in your website but not activated this because you are using older version of WordPress. Please activate this manually.";
        	}

      } // If version greater than 3.0 end

      // If Version greater than 3.0  
      else
      {	

      	//wp-content Upgrader
	   	$plugin_upgrader = new Plugin_Upgrader( new Plugin_Installer_Skin( compact('type', 'title', 'nonce', 'url') ) ); 



			$package_checker = $package;

			// Checing if file exist
			if (file_exists($package_checker)) 
			{
			 _e('<span>Package found</span>','bulk_plugin_installer');
			 $resource = $plugin_upgrader->install($package); 
			 //remove temp files
			 unlink($package);

			} 
			// If Package doesn't exists
			else 
			{
			 echo "Cannot find package: Seems like something is wrong with your uploaded files. Can you please make sure you are not uploading same plugin twice. Thanks.<br>";
			}

			// If Package Doesn't exists
			if (!$plugin_upgrader->plugin_info() && $resource)
			{
			 echo $resource;
			}
			// If Package exists activate plugin
			elseif($bulk_plugin_installer_action =="plugin_activate" && $resource)
			{
				$bulk_plugin_installer_plugins = get_option('active_plugins');
				// Add Plugin in active_plugin option db
				if($bulk_plugin_installer_plugins)
				{
					$pluginsListsToActivate = array($plugin_upgrader->plugin_info());

					// Foreach on all plugin to activate
					foreach ($pluginsListsToActivate as $plugin)
					{
						// If not exists plugin in active_plugins than activate
						if (!in_array($plugin, $bulk_plugin_installer_plugins)) 
						{
							 array_push($bulk_plugin_installer_plugins,$plugin);
							 update_option('active_plugins',$bulk_plugin_installer_plugins);
						}
					}
				}
				// Message after activate
				_e('<p>Plugin activated successfully.</p><br/>','bulk_plugin_installer');
			}


      }
    }


}

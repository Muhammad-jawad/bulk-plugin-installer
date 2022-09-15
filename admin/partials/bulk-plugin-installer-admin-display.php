<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://jawadarshad.io/
 * @since      1.0.0
 *
 * @package    Bulk_Plugin_Installer
 * @subpackage Bulk_Plugin_Installer/admin/partials
 */

/**
 * The class responsible for defining all actions that occur in the admin area.
 */

if ( defined( 'BULK_PLUGIN_INSTALLER_VERSION' ) ) {
    $version = BULK_PLUGIN_INSTALLER_VERSION;
} else {
    $version = '1.0.0';
}
$classObj = new Bulk_Plugin_Installer_Admin("Bulk Plugin Installer", $version);
?>



<!-- Super Wrapper -->
<div class="wrap pc-wrap">
  <h2> <?php _e('Bulk Plugin Installer '. $version .'','bulk-plugin-installer') ?> </h2> <?php
        if (!current_user_can('edit_plugins')) { 
            _e('You do not have sufficient permissions to manage this plugins.
    <br>','bulk-plugin-installer');
            return;
        }
    ?>
  <!-- Main Wrapper -->
  <div id="bulk_plugin_installer_block">
    <!-- On Permission False -->
    <div> <?php if($classObj->Bulk_Plugin_Installer_DirPermission()){} else{ _e('
                <div class="bulk_plugin_installer_error">Please set the directory permission for the folder "uploads" directory to 777.</div>','bulk-plugin-installer'); } ?> </div>
    <!-- End On Permission False -->
    <!-- Container Wrapper -->
    <div class="bulk_plugin_installer-meta-box">
      <!-- Main Container -->
      <div class="div_container">
        <!-- Setting Heading -->
        <h3>
          <span> <?php _e('Drag and Drop or choose file from your computer','bulk-plugin-installer'); ?> </span>
        </h3>
        <!-- End Setting Heading -->
        <!-- Inner Wrapper -->
        <div class="inner_wrapper">
          <!-- Form Start -->
          <form id="upload_plugin_form" name="form_uppcs"  method="post" action="" enctype="multipart/form-data"> 
        <?php wp_nonce_field($classObj->key); ?> 
          <div class="file-drop-area">
              <span class="fake-btn">Choose files</span>
              <span class="file-msg">or drag and drop files here</span>
              <input type="file" class="file-input" name="bulk_plugin_installer_locFiles[]" id="bulk_plugin_installer_locFiles" multiple="multiple" />
            
            </div>
            <!--SHOW RESULT HERE-->
            <p id="files-area">
              <span id="filesList">
                <span id="files-names"></span>
              </span>
            </p>
            <div>
              <input class="button button-primary bulk_plugin_installer_button" type="submit" name="bulk_plugin_installer_locInstall" value="
                                    <?php _e('Install & Activate plugins &raquo;','bulk-plugin-installer'); ?>" />
            </div>

          </form>
          <!-- Form End -->
          <!-- Log Area --> 
          <?php
              if (isset($_POST['bulk_plugin_installer_locInstall']) && $_FILES['bulk_plugin_installer_locFiles']['name'][0] != ""){
                  $classObj->Bulk_Plugin_Installer_plugin_uploading_logs();
              }
          ?>
          <!-- End Log Area -->
        </div>
        <!--End Inner Wrapper-->
      </div>
      <!-- End Main Container -->
    </div>
    <!-- End Container Wrapper -->
  </div>
  <!-- End Main Wrapper -->
</div>
<!-- End Super Wrapper -->
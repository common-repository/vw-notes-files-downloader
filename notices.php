<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'VW_Notes_Files_Downloader_Notice_Class' ) ) {

  class VW_Notes_Files_Downloader_Notice_Class {

    function __construct() {
      add_action( 'activated_plugin', array( $this, 'vw_notes_and_files_downloader_plugin_activated' ), 100, 2 );
      add_action( 'upgrader_process_complete', array( $this, 'vw_notes_and_files_downloader_upgrader_process_complete' ), 10, 2 );

      $is_sirat_theme_installed = false;
      if ( count( wp_get_themes() ) && ( gettype( wp_get_themes() ) == 'array' ) ) {
      	if ( isset( wp_get_themes()['sirat'] ) ) {
      		$is_sirat_theme_installed = true;
      	}
      }
      if ( ( wp_get_theme()->get( 'TextDomain' ) != 'sirat' ) && $is_sirat_theme_installed ) {
      	add_action( 'admin_notices', array( $this, 'vw_notes_and_files_downloader_admin_notice_sirat' ) );
      }

      add_action( 'admin_enqueue_scripts', array( $this, 'vw_notes_and_files_downloader_add_notice_scripts' ) );
    }



    function vw_notes_and_files_downloader_plugin_activated( $plugin, $network_wide ) {

    	if( is_admin() && current_user_can( 'install_themes' ) && ( VW_NOTES_AND_FILES_DOWNLOADER_BASE == $plugin ) ) {

    		if ( count( wp_get_themes() ) && ( gettype( wp_get_themes() ) == 'array' ) ) {
    			if ( !isset( wp_get_themes()['sirat'] ) ) {


    				$vw_notes_and_files_downloader_sirat_theme_install_action_url   = wp_nonce_url(
    					self_admin_url( 'update.php?action=install-theme&theme=sirat&vw-notes-files-downloader-sirat-installed=true' ),
    					'install-theme_sirat'
    				);
    				$vw_notes_and_files_downloader_sirat_theme_install_action_url = str_replace( '&amp;', '&', $vw_notes_and_files_downloader_sirat_theme_install_action_url );
    				wp_redirect( $vw_notes_and_files_downloader_sirat_theme_install_action_url );
    				exit;


    			}

    		}

    	}

    }


    function vw_notes_and_files_downloader_upgrader_process_complete( $upgrader_object, $options ) {
    	$our_plugin = VW_NOTES_AND_FILES_DOWNLOADER_BASE;
    	if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
    		// Iterate through the plugins being updated and check if ours is there

    		foreach( $options['plugins'] as $plugin ) {
    			if( $plugin == $our_plugin ) {
    				// Your action if it is your plugin

    				if( is_admin() && current_user_can( 'install_themes' ) ) {
    					if ( count( wp_get_themes() ) && ( gettype( wp_get_themes() ) == 'array' ) ) {
    						if ( !isset( wp_get_themes()['sirat'] ) ) {

    							$vw_notes_and_files_downloader_sirat_theme_install_action_url   = wp_nonce_url(
    								self_admin_url( 'update.php?action=install-theme&theme=sirat&vw-notes-files-downloader-sirat-installed=true' ),
    								'install-theme_sirat'
    							);

    							$vw_notes_and_files_downloader_sirat_theme_install_action_url = str_replace( '&amp;', '&', $vw_notes_and_files_downloader_sirat_theme_install_action_url );

    							wp_redirect( $vw_notes_and_files_downloader_sirat_theme_install_action_url );
    							exit;
    						}
    					}
    				}

    				break;
    			}
    		}

    	}
    }


    function vw_notes_and_files_downloader_admin_notice_sirat() {
    	$VW_Notes_Files_sirat_theme_activate_action_url = wp_nonce_url(
    		'themes.php?action=activate&amp;template=sirat&amp;stylesheet=sirat',
    		'switch-theme_sirat'
    	);
    	?>
    	<div class="notice notice-info">
    		<p>
    			<strong>VW Notes & Files Downloader</strong> better works with <strong>Sirat</strong> theme.
    		</p>
    		<p>
    			<a href="<?php echo $VW_Notes_Files_sirat_theme_activate_action_url; ?>" class="button-primary">
    				Activate Sirat Theme
    			</a>
    		</p>
    	</div>
    	<?php
    }



    function vw_notes_and_files_downloader_add_notice_scripts() {

      wp_enqueue_script(
        'vw-notes-files-downloader-notice-script',
        VW_NOTES_AND_FILES_DOWNLOADER_PLUGIN_DIR_URL . 'notice.js',
        array( 'jquery' ),
        time(),
        true
      );
			$vw_notes_files_downloader_notice_script_params = array(
				'admin_url' =>  esc_url( admin_url() )
      );
      wp_localize_script(
        'vw-notes-files-downloader-notice-script',
        'vw_notes_files_downloader_notice_script_params',
        $vw_notes_files_downloader_notice_script_params
      );

    }


  }


  new VW_Notes_Files_Downloader_Notice_Class();








}

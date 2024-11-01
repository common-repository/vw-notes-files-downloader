<?php
/**
 * Plugin Name:       VW Notes & Files Downloader
 * Plugin URI:        https://www.vwthemes.com/free-plugin/vw-notes-file-downloader-plugin/
 * Description:       Download notes and files.
 * Version:           1.0.5
 * Author:            VowelWeb
 * Author URI:        https://www.vowelweb.com
 * Text Domain:       vw-notes-and-files-downloader
 * Domain Path:       /languages/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'VW_NOTES_AND_FILES_DOWNLOADER_FILE', __FILE__ );
define( 'VW_NOTES_AND_FILES_DOWNLOADER_BASE', plugin_basename( VW_NOTES_AND_FILES_DOWNLOADER_FILE ) );
define( 'VW_NOTES_AND_FILES_DOWNLOADER_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

//load our plugin textdomain to make sure that function name is correct
function vw_notes_and_files_downloader_load_plugin_textdomain() {
    load_plugin_textdomain( 'vw-notes-and-files-downloader', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'vw_notes_and_files_downloader_load_plugin_textdomain' );


//include notes
require_once('notes.php');

//include dashboard
require_once('dashboard.php');

//include downloader
require_once('downloader.php');

//include Tab
require_once('add-tabs.php');

require_once( 'notices.php' );

/**
 * Load admin styles.
 *
 * @since 1.0
 *
 * @param string $hook Admin hook name.
 */
function vw_notes_and_files_downloader_admin_stylesheet() {
    wp_enqueue_style( 'info', rtrim(plugins_url( 'css/admin-info.css', __FILE__ )) );
}

add_action('admin_enqueue_scripts', 'vw_notes_and_files_downloader_admin_stylesheet');


/**
 * Load front styles.
 *
 * @since 1.0
 *
 */
function vw_notes_and_files_downloader_add_stylesheet() {
    wp_enqueue_style( 'notes', rtrim(plugins_url( 'css/notes.css', __FILE__ )) );
}

add_action('wp_enqueue_scripts', 'vw_notes_and_files_downloader_add_stylesheet');

define(
	'VW_NOTES_AND_FILES_DOWNLOADER_BUY_NOW',
	'https://www.vwthemes.com/wp-plugin/premium-vw-notes-file-downloader-plugin/'
);


/* Filter the single_template with our custom function*/
add_filter('single_template', 'vw_notes_and_files_downloader_template');

function vw_notes_and_files_downloader_template($single) {

    global $wp_query, $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'vnafdnotes' ) {
        if ( wp_redirect( rtrim(admin_url( 'admin.php?page=vw-notes-and-files-downloader-settings' )) ) ) {
            exit;
        }
    }

    return $single;
}

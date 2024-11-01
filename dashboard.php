<?php
/**
 * Admin functions
 *
 * @package VW_NOTES_AND_FILES_DOWNLOADER
 */

/**
 * Code for dashboard page.
 *
 * @since 1.0
 */
function vw_notes_and_files_downloader_dashboard_add_notes() {

	wp_add_dashboard_widget(
                 'vw_notes_and_files_downloader_dashboard_widget',         // Widget slug.
                 'VW Notes and Files Downloader',         // Title.
                 'vw_notes_and_files_downloader_dashboard_show_notes' // Display function.
        );	
}
add_action( 'wp_dashboard_setup', 'vw_notes_and_files_downloader_dashboard_add_notes' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function vw_notes_and_files_downloader_dashboard_show_notes() {

	// Show notes create by admin.
	echo do_shortcode('[VW_NOTES_AND_FILES_DOWNLOADER]');
}
?>
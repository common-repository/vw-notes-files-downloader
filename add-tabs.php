<?php
/**
 * Admin functions
 *
 * @package VW_NOTES_AND_FILES_DOWNLOADER
 */

/**
 * Callback for admin page.
 *
 * @since 1.0
 */
function vw_notes_and_files_downloader_admin_settings_setup() {
	add_menu_page( esc_html__( 'VW Notes Info', 'vw-notes-and-files-downloader' ), esc_html__( 'VW Notes Info', 'vw-notes-and-files-downloader' ), 'manage_options', 'vw-notes-and-files-downloader-settings', 'vw_notes_and_files_downloader_admin_settings_page');
}

add_action('admin_menu', 'vw_notes_and_files_downloader_admin_settings_setup');

/**
 * Creation of tab in admin
 *
 * @since 1.0
 */
function vw_notes_and_files_downloader_admin_settings_page(){
	global $vw_notes_and_files_downloader_active_tab;
	$vw_notes_and_files_downloader_active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'vwnotesandfilesdownloader'; ?>
 
	<h2 class="nav-tab-wrapper">
		<?php do_action( 'vw_notes_and_files_downloader_settings_tab' ); ?>
	</h2>
	<?php 
		do_action( 'vw_notes_and_files_downloader_settings_content' );
}

/**
 * Creation of tab in admin
 *
 * @since 1.0
 */
add_action( 'vw_notes_and_files_downloader_settings_tab', 'vw_notes_and_files_downloader_vwnotesandfilesdownloader_tab', 1 );
function vw_notes_and_files_downloader_vwnotesandfilesdownloader_tab(){
	global $vw_notes_and_files_downloader_active_tab; ?>
	<a class="nav-tab <?php echo $vw_notes_and_files_downloader_active_tab == 'vwnotesandfilesdownloader' || '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=vw-notes-and-files-downloader-settings&tab=vwnotesandfilesdownloader' ); ?>"><?php _e( 'Plugin Setup', 'vw-notes-and-files-downloader' ); ?> </a>
	<?php
}

/**
 * Tab content in admin
 *
 * @since 1.0
 */
add_action( 'vw_notes_and_files_downloader_settings_content', 'vw_notes_and_files_downloader_vwnotesandfilesdownloader_render_options_page' );
function vw_notes_and_files_downloader_vwnotesandfilesdownloader_render_options_page() {
	global $vw_notes_and_files_downloader_active_tab;

	if ( '' || 'vwnotesandfilesdownloader' != $vw_notes_and_files_downloader_active_tab )
		return; 
	?>
	<div class="wrapper-info">
		<div class="col-left">
	    	<h2><?php _e( 'Welcome to VW Notes & Files Downloader Plugin', 'vw-notes-and-files-downloader' ); ?></h2>
	    	<p><?php _e('It is an amazing plugin for uploading and downloading various type of notes and files. It is used for making notes for employees or team members.You can easily upload the file from notes and file tab and with the help of shortcode, you can show your files download option anywhere on pages or post.','vw-notes-and-files-downloader'); ?></p>
<p><?php _e('Just insert shortcode [VW_NOTES_AND_FILES_DOWNLOADER] in posts or pages to get files/notes download option.','vw-notes-and-files-downloader'); ?></p>

			<div id="lite_theme" class="tabcontent open">
				<h3><?php esc_html_e( 'Steps to Setup Notes & Files Downloader Plugin', 'vw-notes-and-files-downloader' ); ?></h3>
				<hr class="h3hr">
				
				<div class="col-doc-7">
					<?php echo '<img src="'.rtrim(plugins_url( 'images/notes-files.png', __FILE__ )).'" >'; ?>
				</div>
				<div class="col-doc-71">
					<?php echo '<img src="'.rtrim(plugins_url( 'images/shortcode.png', __FILE__ )).'" >'; ?>
				</div>
				<div class="col-doc-77">
					<?php echo '<img src="'.rtrim(plugins_url( 'images/notes-display.png', __FILE__ )).'" >'; ?>
				</div>
			</div>

	    </div>
	    <div class="col-right">
	    	<div class="logo">
				<?php echo '<img src="'.rtrim(plugins_url( 'images/final-logo.png', __FILE__ )).'" >'; ?>
			</div>
			<div class="update-now">
				<h4><?php esc_html_e('Buy VW Notes & Files Downloader Pro Just at $20!','vw-notes-and-files-downloader'); ?></h4>
				<div class="info-link">
					<a href="<?php echo esc_url( VW_NOTES_AND_FILES_DOWNLOADER_BUY_NOW ); ?>" target="_blank"> <span class="dashicons dashicons-upload"></span><?php esc_html_e('Upgrade to Pro', 'vw-notes-and-files-downloader'); ?></a>
				</div>
				<div class="col-left-pro">
					<h3><?php esc_html_e('Premium Features', 'vw-notes-and-files-downloader'); ?></h3>
					<hr class="h3hr">
			    	<ol>
		    		    <li><?php esc_html_e('Categorization of notes according to the specific industry.','vw-notes-and-files-downloader'); ?></li>
	                            <li><?php esc_html_e('ShortCode options available as below:','vw-notes-and-files-downloader'); ?>
		                     <ol class="list">
		                     	<li><?php esc_html_e('Easily give sorting criteria as ascending or descending or random.','vw-notes-and-files-downloader'); ?></li>
					<li><?php esc_html_e('The number of notes to show on one page as pagination.','vw-notes-and-files-downloader'); ?></li>
					<li><?php esc_html_e('Easily show the notes according to the category by providing category ID.','vw-notes-and-files-downloader'); ?></li>
		                     </ol>
		                    </li>
		    		    <li><?php esc_html_e('Individual page for notes and file download with password protection and assignment according to user role.','vw-notes-and-files-downloader'); ?></li>
	                       </ol>
			    </div>
			</div>
	    </div>
	</div>
<?php } ?>
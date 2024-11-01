<?php
/**
 * Register shortcode for notes to display.
 *
 * @since 1.0
*/
function vw_notes_and_files_downloader_register_shortcode() {
	// Add shortcode.
	add_shortcode( 'VW_NOTES_AND_FILES_DOWNLOADER', 'vw_notes_and_files_downloader_download' );
}
vw_notes_and_files_downloader_register_shortcode();

// doctor search form
function vw_notes_and_files_downloader_download() {
  ?>
  	<div class="tab-content">
  		<?php
	  		$args=array(
	  			'post_type' => 'vnafdnotes',
	  			'posts_per_page' => -1
	  		);

			// The Query
			$the_query = new WP_Query( $args );

			// The Loop
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();

					$vw_notes_and_files_dowloader_data = get_post_meta(get_the_id(),'vw_notes_and_files_downloader_attachment',true);

					if(count($vw_notes_and_files_dowloader_data)>0 && !empty($vw_notes_and_files_dowloader_data)){
			    			if($vw_notes_and_files_dowloader_data[0]['error'] == false){
                                                        $parts = basename($vw_notes_and_files_dowloader_data[0]['url']);
						?>
							<div class="new-list">
								<span><?php the_title(); ?></span>
								<a href="<?php echo esc_url($vw_notes_and_files_dowloader_data[0]['url']); ?>" title="<?php echo $parts; ?>" target="_blank"><?php echo esc_html__($parts); ?></a>
							</div>
						<?php
						}
						else{
							//no value
						}
					}
                                        unset($vw_notes_and_files_dowloader_data);
				}
				/* Restore original Post Data */
				wp_reset_postdata();
			}
			else {
				// no notes found
				?>
					<div class="new-list">
						<span><?php echo esc_html__( 'No notes found.', 'vw-notes-and-files-downloader' ); ?></span>
					</div>
				<?php
			}
		?>
    </div>
  <?php
}
?>
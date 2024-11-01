<?php
/**
 * Register admin menu for custom Notes registered post.
 *
 * @since 1.0
 */
function vw_notes_and_files_downloader_create_posttype() {
  register_post_type( 'vnafdnotes',
    array(
      'labels' => array(
        'name' => __('Notes & Files', 'vw-notes-and-files-downloader'),
        'singular_name' => __('Notes & Files', 'vw-notes-and-files-downloader'),
        'add_new_item' =>  __('Add Notes & Files', 'vw-notes-and-files-downloader'),
        'edit_item'    => __('Edit Notes & Files', 'vw-notes-and-files-downloader'),
        'search_items' =>  __('Search notes', 'vw-notes-and-files-downloader')
      ),
      'menu_icon'  => 'dashicons-media-default',
      'public' => true,
      'has_archive' => true,
    )
  );
}

add_action( 'init','vw_notes_and_files_downloader_create_posttype' );

/**
 * Add file upload multipart
 *
 * @since 1.0
 */
add_action('post_edit_form_tag', 'vw_notes_and_files_downloader_update_edit_form');
function vw_notes_and_files_downloader_update_edit_form() {
  echo ' enctype="multipart/form-data"';
}

/**
 * Making the meta box (Note: meta box != custom meta field)
 *
 * @since 1.0
 */
add_action('add_meta_boxes', 'vw_notes_and_files_downloader_the_upload_metabox'); 
function vw_notes_and_files_downloader_the_upload_metabox() {
  add_meta_box(
    'vw_notes_and_files_downloader_attachment',        // $id
    __('Upload Notes (Notes will not show in frontend without wordpress supported file upload.)', 'vw-notes-and-files-downloader'), // $title
    'vw_notes_and_files_downloader_attachment',   // $callback
    'vnafdnotes',                  // $page
    'normal',                      // $context
    'high'                         // $priority
  );
}

/**
 * The custom file attachment function
 *
 * @since 1.0
 */
function vw_notes_and_files_downloader_attachment() {  
  
  global $post;
  $id = $post->ID;
  $theFILE=  get_post_meta($post->ID,'vw_notes_and_files_downloader_attachment',true);
  wp_nonce_field(plugin_basename(__FILE__), 'vw_notes_and_files_downloader_attachment_nonce');
  $html = '<p class="description">';
	if(count($theFILE)>0 && !empty($theFILE)){
	    if($theFILE[0]['error'] == false){
			$parts = basename($theFILE[0]['url']);
			$html="<p class='description'>".__('Note Uploaded: <a href="'.esc_url( $theFILE[0]['url'] ).'" target="_blank">'.$parts.'</a>', 'vw-notes-and-files-downloader');
		}
		else{
			$html="<p class='description'>".__('Error: ', 'vw-notes-and-files-downloader').$theFILE[0]['error'];
			update_post_meta($post->ID,'vw_notes_and_files_downloader_attachment','');
		}
	}
	$html .= '</p>';
	$html .= '<input id="vw_notes_and_files_downloader_attachment" name="vw_notes_and_files_downloader_attachment[]" type="file"/>';

  echo $html;
}

/**
 * Saving the uploaded file details
 *
 * @since 1.0
 */
function vw_notes_and_files_downloader_save_custom_meta_data($id) {
  /* --- security verification --- */  
  if(isset($_POST['vw_notes_and_files_downloader_attachment_nonce'])) {
    if(!wp_verify_nonce($_POST['vw_notes_and_files_downloader_attachment_nonce'], plugin_basename(__FILE__))) {  
      return $id;  
    } // end if  
  }
  if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {  
    return $id;  
  } // end if  

  if(isset($_POST['post_type'])){
    if('page' == $_POST['post_type']) {  
      if(!current_user_can('edit_page', $id)) {  
        return $id;  
      } // end if  
    } else {  
        if(!current_user_can('edit_page', $id)) {  
            return $id;  
        } // end if  
    }
  } // end if

  /* - end security verification - */  
  // Make sure the file array isn't empty  
  if(!empty($_FILES['vw_notes_and_files_downloader_attachment']['name'])) {
    // Get the file type of the upload  
    $flag=0;
    for($i=0;$i<count($_FILES['vw_notes_and_files_downloader_attachment']['name']);$i++){
      if(!empty($_FILES['vw_notes_and_files_downloader_attachment']['name'][$i])){
        $flag=1;
        // Use the WordPress API to upload the multiple files
        $upload[] = wp_upload_bits($_FILES['vw_notes_and_files_downloader_attachment']['name'][$i], null, file_get_contents($_FILES['vw_notes_and_files_downloader_attachment']['tmp_name'][$i]));
      }
    }
    if($flag==1)
      update_post_meta($id, 'vw_notes_and_files_downloader_attachment', $upload);          
  }
}

add_action('save_post', 'vw_notes_and_files_downloader_save_custom_meta_data');

/**
 * Remove editor for custom post type notes
 *
 * @since 1.0
 */
function vw_notes_and_files_downloader_init_remove_editor(){
    $post_type = 'vnafdnotes';
    remove_post_type_support( $post_type, 'editor');
}

add_action('init', 'vw_notes_and_files_downloader_init_remove_editor',100);
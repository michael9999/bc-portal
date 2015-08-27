<?php

// Add Meta Boxes 
function add_custom_meta_box()
{		
	add_meta_box('st_meta_box_video', // $id  
        'Video Post Format', // $title  
        'show_meta_box_video', // $callback  
        'post', // $page  
        'normal', // $context  
        'high'); // $priority
		
}
add_action('add_meta_boxes', 'add_custom_meta_box');


// Field Array s 
$prefix = 'st_';

$meta_fields_video = array(
	array( 
		'label' => __('Video File', 'framework'),
		'desc' => __('Upload or link to your media file. Supports MP4, OGG, WebM, WMV, MP3, WAV, WMA files as well as captions with WebSRT files.','framework'),
		'id' => $prefix.'video',
		'type' => 'media'
	),
	array( 
		'label' => __('Poster Image','framework', 'framework'),
		'desc' => __('The video prevuew image.','framework'),
		'id' => $prefix.'video_poster',
		'type' => 'image'
	),
    array(
        'label' => __('Youtube/Vimeo Embed Code', 'framework'),
        'desc' => __('Enter the Youtube/Vimeo embed code. (This will overide any video options above).', 'framework'),
        'id' => $prefix . 'video_embed',
        'type' => 'textarea'
    )
);



function show_meta_box_video()
{
    global $meta_fields_video, $post;
    // Use nonce for verification  
    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
    
    // Begin the field table and loop  
    echo '<table class="form-table">';
    foreach ($meta_fields_video as $field) {
        // get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with  
        echo '<tr> 
                <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th> 
                <td>';
        switch ($field['type']) {
            // case items will go here 
            
            // text  
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" /> 
            <br /><span class="description">' . $field['desc'] . '</span>';
                break;
            
            // textarea  
            case 'textarea':
                echo '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" cols="60" rows="4">' . $meta . '</textarea> 
        <br /><span class="description">' . $field['desc'] . '</span>';
                break;
				
		// image  
   		case 'image':  
        $image = get_template_directory_uri().'/framework/admin/images/post-meta-image.png';  
        echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';  
        if ($meta) { $image = $meta; }  
        echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" /> 
                    <img src="'.$image.'" class="custom_preview_image" alt="" /><br /> 
                        <input class="custom_upload_image_button button" type="button" value="Choose Image" /> 
                        <small> <a href="#" class="custom_clear_image_button">Remove Image</a></small> 
                        <br clear="all" /><span class="description">'.$field['desc'].'';
		break;  
						
    
		// media
		case 'media':
        echo    '<input name="'.$field['id'].'" type="text" class="custom_upload_media" value="'.$meta.'" size="30" /> 
                        <input class="custom_upload_media_button button" type="button" value="Upload Media" /> 
                        <small> <a href="#" class="custom_clear_media_button">Remove Media</a></small> 
                        <br clear="all" /><span class="description">'.$field['desc'].'';
		break;				

                
        } //end switch  
        echo '</td></tr>';
    } // end foreach  
    echo '</table>'; // end table  
    
}

// Save the Data  
function save_custom_meta($post_id)
{
    global $meta_fields_video;
    
    // verify nonce  
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave  
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions  
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    // loop through fields and save the data  
	foreach ($meta_fields_video as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } 
	// end foreach  
}
add_action('save_post', 'save_custom_meta');



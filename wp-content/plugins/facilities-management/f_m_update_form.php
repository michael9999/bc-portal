<?php
add_action('wp_ajax_fm_update_form2','f_m_update_form');

// this function processes the data passed from the ajax call
// GET ALL OF SELECTED ENTRIES DETAILS FROM DB, FORMAT IT
public class f_m_update_form_now{
    
function f_m_update_form(){


$testPost = $_POST["varTrial"];

print_r($testPost);

//echo testPost . "hello world";


    
}


}
?>
<?php

/*
Plugin Name: Bulk Post Creator
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: h.safari
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

add_action('add_meta_boxes','bulkpc_add_custom_meta_box');
add_action('save_post','bulkpc_save_postdata');

function bulkpc_add_custom_meta_box(){
    $screens=['post'];
    foreach ($screens as $screen){
        add_meta_box('bulkpc_box_id','Bulk post creator','bulkpc_cmb_html',$screen);
    }
}

function bulkpc_cmb_html($post)
{
    echo 'postid: '.$post->ID.' .<br/>';
    $value = get_post_meta($post->ID, 'bulkpc_addBulk', true);

    echo 'value: '.$value.' .<br/>';
    ?>
    <label for="wporg_field">Description for this field</label>
    <select name="wporg_field" id="wporg_field" class="postbox">
        <option value="">Select something...</option>
        <option value="something" <?php selected($value, 'something'); ?>>Something</option>
        <option value="else" <?php selected($value, 'else'); ?>>Else</option>
    </select>
    <hr/>
    <label>
        <input type="checkbox" name="bulkPostAdd_chk" value="<?php echo $value ?>"/>
        Bulk add post
    </label>

    <?php
}

function bulkpc_save_postdata($post_id){
    if(array_key_exists('bulkPostAdd_chk',$_POST)){
        update_post_meta($post_id,'bulkpc_addBulk',isset($_POST['bulkPostAdd_chk']));
    }
}
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
    $value = get_post_meta($post->ID, 'bulkpc_addBulk', true);

    ?>
    <br/>
    <label for="wporg_field">Description for this field</label>
    <select name="wporg_field" id="wporg_field" class="postbox">
        <option value="">Select something...</option>
        <option value="something" >Something</option>
        <option value="else">Else</option>
    </select>
    <hr/>
    <label>
        <input type="checkbox" name="bulkPostAdd_chk" <?php checked( $value,true, true ); ?>/>
        Bulk add post
    </label>

    <?php
}

function bulkpc_save_postdata($post_id){
    update_post_meta($post_id,'bulkpc_addBulk',isset($_POST['bulkPostAdd_chk']));
    if(array_key_exists('bulkPostAdd_chk',$_POST)){
        update_post_meta($post_id,'bulkpc_addBulk',isset($_POST['bulkPostAdd_chk']));
        bulkpc_createBulk();
    }else{
        update_post_meta($post_id,'bulkpc_addBulk','0');
    }
}

function  bulkpc_createBulk() {

    // Set the post ID to -1. This sets to no action at moment
    $post_id = -1;

    // Set the Author, Slug, title and content of the new post
    $author_id = 1;
    $slug = 'wordpress-post-created-with-code';
    $title = 'WordPress post created whith code';
    $content = 'This is the content of the post that we are creating right now with code. 
                    More text: I motsetning til hva mange tror, er ikke Lorem Ipsum bare tilfeldig tekst. 
                    Dets røtter springer helt tilbake til et stykke klassisk latinsk litteratur fra 45 år f.kr., 
                    hvilket gjør det over 2000 år gammelt. Richard McClintock - professor i latin ved Hampden-Sydney 
                    College i Virginia, USA - slo opp flere av de mer obskure latinske ordene, consectetur, 
                    fra en del av Lorem Ipsum, og fant dets utvilsomme opprinnelse gjennom å studere bruken 
                    av disse ordene i klassisk litteratur. Lorem Ipsum kommer fra seksjon 1.10.32 og 1.10.33 i 
                    "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) av Cicero, skrevet i år 45 f.kr. 
                    Boken er en avhandling om teorier rundt etikk, og var veldig populær under renessansen. Den første 
                    linjen av Lorem Ipsum, "Lorem Ipsum dolor sit amet...", er hentet fra en linje i seksjon 1.10.32.';
    // Cheks if doen't exists a post with slug "wordpress-post-created-with-code".
    if( !post_exists_by_slug( $slug ) ) {
        // Set the post ID
        $post_id = wp_insert_post(
            array(
                'comment_status'    =>   'closed',
                'ping_status'       =>   'closed',
                'post_author'       =>   $author_id,
                'post_name'         =>   $slug,
                'post_title'        =>   $title,
                'post_content'      =>  $content,
                'post_status'       =>   'publish',
                'post_type'         =>   'post'
            )
        );
    } else {

        // Set pos_id to -2 becouse there is a post with this slug.
        $post_id = -2;

    } // end if

} // end oaf_create_post_with_code


/**
 * post_exists_by_slug.
 *
 * @return mixed boolean false if no post exists; post ID otherwise.
 */
function post_exists_by_slug( $post_slug ) {
    $args_posts = array(
        'post_type'      => 'post',
        'post_status'    => 'any',
        'name'           => $post_slug,
        'posts_per_page' => 1,
    );
    $loop_posts = new WP_Query( $args_posts );
    if ( ! $loop_posts->have_posts() ) {
        return false;
    } else {
        $loop_posts->the_post();
        return $loop_posts->post->ID;
    }
}
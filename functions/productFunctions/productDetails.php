<?php


add_action('add_meta_boxes', function () {
    add_meta_box('Details', 'Details', 'product_meta_box', 'product', 'normal','core');
    add_meta_box('Priority', 'Priority', 'product_meta_box_Priority', 'product', 'side','core');
    add_meta_box('Spec_link', 'Spec_link', 'product_meta_box_Spec_link', 'product', 'side','core');

});


function product_meta_box($post)
{
    if (!current_user_can("manage_options")) {
        wp_die("You do not have access to this page !");
    }
    if (idea_is_edit_page('new')){
        $Details = "";
    }else{
        $postID=isset($_GET['post']) && $_GET['post'] != null ? $_GET['post'] : null;
        $Details = get_post_meta($postID, 'details', true);
    }

    wp_editor( $Details, 'details', array(
        'wpautop'       => true,
        'media_buttons' => false,
        'textarea_name' => 'textarea_details',
        'textarea_rows' => 10,
        'teeny'         => true,

    ) );


    wp_nonce_field('product_meta_box_nonce', 'meta_box_nonce');
    ?>
    <input hidden type="text" id="details" name="details"
           value="<?php echo !empty($Details) ? $Details : null; ?>"
    >
    <?php
}

function product_meta_box_Priority($post)
{
    if (!current_user_can("manage_options")) {
        wp_die("You do not have access to this page !");
    }
    if (idea_is_edit_page('new')){
        $Priority = "";
    }else{
        $postID=isset($_GET['post']) && $_GET['post'] != null ? $_GET['post'] : null;
        $Priority = get_post_meta($postID, 'Priority', true);
    }


    wp_nonce_field('product_meta_box_nonce', 'meta_box_nonce');
    ?>
    <input type="number" name="Priority" id="Priority" class="widefat" value="<?= $Priority > 0 ? $Priority : 0 ?>" style="margin-top: 10px;">
    <span style="margin-top: 8px;
    display: block;
    font-size: smaller;
    color: #959595;">Priority with higher numbers</span>

    <?php
}
function product_meta_box_Spec_link($post)
{
    if (!current_user_can("manage_options")) {
        wp_die("You do not have access to this page !");
    }
    if (idea_is_edit_page('new')){
        $Spec_link = null;
    }else{
        $postID=isset($_GET['post']) && $_GET['post'] != null ? $_GET['post'] : null;
        $Spec_link = get_post_meta($postID, 'Spec_link', true);
    }


    wp_nonce_field('product_meta_box_nonce', 'meta_box_nonce');
    ?>
    <input type="text" name="Spec_link" id="Spec_link" class="widefat" value="<?= $Spec_link != null ? $Spec_link : null ?>" style="margin-top: 10px;">


    <?php
}


add_action('save_post', 'save_post_product_meta');

function save_post_product_meta($id)
{

    if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'product_meta_box_nonce')) {
        return;
    }
    if (isset($_POST['textarea_details'])) {
        update_post_meta($id, 'details',$_POST['textarea_details'] );
    }
    if (isset($_POST['Priority'])) {
        update_post_meta($id, 'Priority', sanitize_text_field($_POST['Priority']));
    }
    if (isset($_POST['Spec_link'])) {
        update_post_meta($id, 'Spec_link', sanitize_text_field($_POST['Spec_link']));
    }
//    update_post_meta($id, 'Priority', sanitize_text_field($_POST['post_name']));


}

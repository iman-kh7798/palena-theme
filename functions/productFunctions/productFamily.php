<?php


add_action('add_meta_boxes', function () {
    add_meta_box('Family', 'Family', 'product_meta_box_family', 'product', 'side','core');
});


function product_meta_box_family($post)
{
    if (!current_user_can("manage_options")) {
        wp_die("You do not have access to this page !");
    }
    $thisPOstId=$post->ID;
    $Family = get_post_meta($thisPOstId, 'family', true);
    $Family=(array)$Family;
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    $productQuery = new WP_Query($args);
    wp_nonce_field('product_meta_box_family_nonce', 'meta_box_nonce_family');
    ?>
        <p style="margin-bottom: 12px;" class="widefat">For Multi Selecet Press (Ctrl key) And Click</p>
    <select name="product_family[]" id="product_family" class="widefat product_family" data-live-search="true" multiple aria-multiselectable="true">
<!--        <option value="">not selected</option>-->
     <?php
    if ($productQuery->have_posts()) :
        while ($productQuery->have_posts()) : $productQuery->the_post();
            global $post;
            if ($thisPOstId != $post->ID):
            ?>
            <option value="<?=$post->ID?>" <?= !empty($Family) && in_array($post->ID,$Family)  ? 'selected' : ''?> ><?=get_the_title()?></option>
            <?php
            endif;
        endwhile;
        wp_reset_query();
    endif;
    ?>

    </select>
    <?php



}

add_action('save_post', 'save_post_product_meta_family');

function save_post_product_meta_family($id)
{

    if (!isset($_POST['meta_box_nonce_family']) || !wp_verify_nonce($_POST['meta_box_nonce_family'], 'product_meta_box_family_nonce')) {
        return;
    }
    if (isset($_POST['product_family'])) {
        update_post_meta($id, 'family', $_POST['product_family']);
    }
}

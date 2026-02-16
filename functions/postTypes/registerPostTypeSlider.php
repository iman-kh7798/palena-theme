<?php
add_action('init', function () {

    register_post_type('slider', [
        'labels' => [
            'name' => 'main Slider',
            'singular_name' => 'main Slider',
            'menu_name' => 'sliders',
            'add_new' => 'add new slider',
            'add_new_item' => 'add new slider item',
            'new_item' => 'create new slider',
            'edit_item' => 'edit slider',
            'search_item' => 'search slider',
            'not_found' => 'slider not found',
            'not_found_in_trash' => 'not found slider in trash'
        ],
        'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
        'publicly_queryable' => true,  // you should be able to query it
        'show_ui' => true,  // you should be able to edit it in wp-admin
        'exclude_from_search' => true,  // you should exclude it from search results
        'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
        'has_archive' => false,  // it shouldn't have archive page
        'rewrite' => false,  // it shouldn't have rewrite rules
        'query_var' => 'slider',
        'supports' => [
            'title',
        ]
    ]);

    add_action('add_meta_boxes', function () {
        add_meta_box('slider_meta', 'slider details', 'slider_meta_box', 'slider', 'normal');
    });


    function slider_meta_box($post)
    {
        if (!current_user_can("manage_options")) {
            wp_die("You do not have access to this page !");
        }
        include_once get_template_directory() . "/adminPanel/views/settingProductsSlider.php";
    }

    add_action('save_post', 'save_post_slider_meta');

    function save_post_slider_meta($id)
    {

        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'slider_meta_box_nonce')) {
            return;
        }

        if (isset($_POST['slider_link'])) {
            update_post_meta($id, 'slider_link', strip_tags($_POST['slider_link']));
        }
        if (isset($_POST['slider_img'])) {
            update_post_meta($id, 'slider_img', strip_tags($_POST['slider_img']));
        }
        if (isset($_POST['slider_img_mobile_slider'])) {
            update_post_meta($id, 'slider_img_mobile_slider', strip_tags($_POST['slider_img_mobile_slider']));
        }

    }

});
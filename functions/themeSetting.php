<?php

/*   تنظیمات قالب    */

// Add menu to Dashboard
$menu_slug = "theme_setting";
add_action('admin_menu', function () {
    global $menu_slug;
    add_menu_page("Theme Setting", "Theme Setting", "manage_options", $menu_slug, "mainThemeSettingPage", null, 99);
    add_menu_page("Ask The Seller", "Ask The Seller", "manage_options", 'ask_the_seller', "manageAskTheSellerPage", null, 98);
    add_menu_page("Ask The Seller Custom", "Ask The Seller Custom", "manage_options", 'ask_the_seller_custom', "manageAskTheSellerPage_custom", null, 99);
});

// Show page setting  theme
function mainThemeSettingPage()
{
    if (! current_user_can("manage_options")) {
        wp_die("You do not have access to this page !");
    }
    include_once get_template_directory() . "/adminPanel/views/mainThemeSetting.php";
}




function settingProductsSlider()
{
    if (! current_user_can("manage_options")) {
        wp_die("You do not have access to this page !");
    }
    include_once get_template_directory() . "/adminPanel/views/settingProductsSlider.php";
}
function manageAskTheSellerPage()
{
    if (! current_user_can("manage_options")) {
        wp_die("You do not have access to this page !");
    }
    include_once get_template_directory() . "/adminPanel/views/manageAskTheSellerPage.php";
}
function manageAskTheSellerPage_custom()
{
    if (! current_user_can("manage_options")) {
        wp_die("You do not have access to this page !");
    }
    include_once get_template_directory() . "/adminPanel/views/manageAskTheSellerPage_custom.php";
}
// Add Setting for save Options
add_action('admin_init', function () {
    register_setting('mainThemeSettingPage', 'mainThemeSettingPage');
    register_setting('settingProductsSlider', 'settingProductsSlider');
    register_setting('manageAskTheSellerPage', 'manageAskTheSellerPage');
    register_setting('manageAskTheSellerPage_custom', 'manageAskTheSellerPage_custom');
}
);
add_action( 'admin_enqueue_scripts', function (){
    wp_enqueue_media();
} );


// Add My Script To Dashboard and Use Function For Show Media-upload window
add_action('admin_print_scripts', function () {

    wp_register_style(
        'idea_admin_panel_style',
         get_template_directory_uri() . '/assets/css/idea_theme_admin.css',
        null,
        1,
        'all'
    );
    wp_enqueue_style( 'idea_admin_panel_style' );


    wp_enqueue_style('thickbox'); // call to media files in wp
    wp_enqueue_script('media-upload');
    wp_register_script('my_upload', get_template_directory_uri() . "/assets/js/adminPanel.js", array(
        'jquery',
        'media-upload',
        'thickbox'
    ),'1.3.0',true);
    wp_enqueue_script('my_upload');


}
);






 //ADD widgets layout
add_action('widgets_init', function () {
    register_sidebar(array(
        'name' => 'Blog Sidebar',
        'id' => 'sidebar_blog',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => 'Story Sidebar',
        'id' => 'sidebar_story',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => 'The first column of the footer ',
        'id' => 'footer_first_column',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h5 class="h6 ColumnTitle">',
        'after_title' => '</h5>',
    ));
    register_sidebar(array(
        'name' => 'The second column of the footer ',
        'id' => 'footer_second_column',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<span class="h5 text-white">',
        'after_title' => '</span>',
    ));
    register_sidebar(array(
        'name' => 'Social Network',
        'id' => 'social_network',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h6 class="h6 d-none">',
        'after_title' => '</h6>',
    ));


});




//function to display number of posts.
function getPostViews($postID){
    $count_key = 'product_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

// Add count views for product
function setPostViews($postID) {
    $count_key = 'product_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        update_post_meta($postID, $count_key, $count);
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('View');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}



add_theme_support( 'post-thumbnails' );



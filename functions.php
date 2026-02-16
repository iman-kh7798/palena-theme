<?php


require get_template_directory() . '/functions/makePageWishList.php';
require get_template_directory() . '/functions/postTypes/registerPostTypeSlider.php';
require get_template_directory() . '/functions/postTypes/registerPostTypeProduct.php';
require get_template_directory() . '/functions/postTypes/registerPostTypeStory.php';

require get_template_directory() . '/functions/productFunctions/productDetails.php';
require get_template_directory() . '/functions/productFunctions/productGallery.php';
require get_template_directory() . '/functions/productFunctions/productDimension.php';
//require get_template_directory() . '/functions/productFunctions/productMetal.php';
require get_template_directory() . '/functions/productFunctions/productWood.php';
require get_template_directory() . '/functions/productFunctions/productFamily.php';
require get_template_directory() . '/functions/productFunctions/productMarble.php';
require get_template_directory() . '/functions/productFunctions/product_cat_thumbnail.php';
require get_template_directory() . '/functions/productFunctions/product_horizontal_thumbnail.php';
require get_template_directory() . '/functions/productFunctions/product_vertical_thumbnail.php';

require get_template_directory() . '/functions/storyFunctions/storyGallery.php';

// include widgets
require get_template_directory() . '/functions/SocialNetworks.php';
require get_template_directory() . '/functions/ideaCsrfToken.php';
require get_template_directory() . '/functions/productFunctions/askTheSeller.php';
require get_template_directory() . '/functions/productFunctions/askTheSeller_custom.php';


require get_template_directory() . '/functions/basicFunctions.php';
require get_template_directory() . '/functions/themeSetting.php';

function idea_is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;


    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// Increase the image resize threshold to 4000px on the longest edge
function smartwp_big_image_size_threshold( $threshold ) {
 return 4000;
}
add_filter( 'big_image_size_threshold', 'smartwp_big_image_size_threshold', 999, 1);


/*--------------------Disable Right Click-----------------------------------*/
function disable_right_click() {
    echo "<script>document.oncontextmenu = function(){return false;};</script>";
}
add_action( 'wp_footer', 'disable_right_click' );


function remove_jquery_migrate( $scripts ) {

    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {

        $script = $scripts->registered['jquery'];

        if ( $script->deps ) {
            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
    }
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );


function golden_oak_web_design_blog_generate_rewrite_rules( $wp_rewrite ) {
    $new_rules = array(
        '(([^/]+/)*blog)/page/?([0-9]{1,})/?$' => 'index.php?pagename=$matches[1]&paged=$matches[3]',
        'blog/([^/]+)/?$' => 'index.php?post_type=post&name=$matches[1]',
        'blog/[^/]+/attachment/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]',
        'blog/[^/]+/attachment/([^/]+)/trackback/?$' => 'index.php?post_type=post&attachment=$matches[1]&tb=1',
        'blog/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
        'blog/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
        'blog/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&attachment=$matches[1]&cpage=$matches[2]',
        'blog/[^/]+/attachment/([^/]+)/embed/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
        'blog/[^/]+/embed/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
        'blog/([^/]+)/embed/?$' => 'index.php?post_type=post&name=$matches[1]&embed=true',
        'blog/[^/]+/([^/]+)/embed/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
        'blog/([^/]+)/trackback/?$' => 'index.php?post_type=post&name=$matches[1]&tb=1',
        'blog/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
        'blog/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
        'blog/page/([0-9]{1,})/?$' => 'index.php?post_type=post&paged=$matches[1]',
        'blog/[^/]+/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
        'blog/([^/]+)/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
        'blog/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&cpage=$matches[2]',
        'blog/([^/]+)(/[0-9]+)?/?$' => 'index.php?post_type=post&name=$matches[1]&page=$matches[2]',
        'blog/[^/]+/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]',
        'blog/[^/]+/([^/]+)/trackback/?$' => 'index.php?post_type=post&attachment=$matches[1]&tb=1',
        'blog/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
        'blog/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
        'blog/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&attachment=$matches[1]&cpage=$matches[2]',
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'golden_oak_web_design_blog_generate_rewrite_rules' );

function golden_oak_web_design_update_post_link( $post_link, $id = 0 ) {
    $post = get_post( $id );
    if( is_object( $post ) && $post->post_type == 'post' ) {
        return home_url( '/blog/' . $post->post_name );
    }
    return $post_link;
}
add_filter( 'post_link', 'golden_oak_web_design_update_post_link', 1, 3 );


// Product Registrations
function custom_product_registration_post_type() {
    $labels = array(
        'name'               => 'Product Registrations',
        'singular_name'      => 'Product Registration',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Product Registration',
        'edit_item'          => 'Edit Product Registration',
        'new_item'           => 'New Product Registration',
        'view_item'          => 'View Product Registration',
        'search_items'       => 'Search Product Registrations',
        'not_found'          => 'No product registrations found',
        'not_found_in_trash' => 'No product registrations found in trash',
        'parent_item_colon'  => '',
        'menu_name'          => 'Product Registrations'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'product-registration' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'taxonomies'         => array( 'product_registration_category' ),
    );

    register_post_type( 'product_registration', $args );

    $taxonomy_labels = array(
        'name'                       => 'Categories',
        'singular_name'              => 'Category',
        'search_items'               => 'Search Categories',
        'all_items'                  => 'All Categories',
        'parent_item'                => 'Parent Category',
        'parent_item_colon'          => 'Parent Category:',
        'edit_item'                  => 'Edit Category',
        'update_item'                => 'Update Category',
        'add_new_item'               => 'Add New Category',
        'new_item_name'              => 'New Category Name',
        'menu_name'                  => 'Categories',
        'view_item'                  => 'View Category',
        'separate_items_with_commas' => 'Separate categories with commas',
        'add_or_remove_items'        => 'Add or remove categories',
        'choose_from_most_used'      => 'Choose from the most used categories',
        'not_found'                  => 'No categories found',
    );

    $taxonomy_args = array(
        'labels'            => $taxonomy_labels,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'rewrite'           => array( 'slug' => 'product-registration-category' ),
    );

    register_taxonomy( 'product_registration_category', 'product_registration', $taxonomy_args );
}
add_action( 'init', 'custom_product_registration_post_type' );



//  product_registration search
function handle_search_form() {
    if (isset($_POST['post_number']) && !empty($_POST['post_number'])) {
        $post_number = sanitize_text_field($_POST['post_number']);
        
        $args = array(
            'post_type' => 'product_registration',
            'name' => $post_number,
            'exact' => true,
            'posts_per_page' => 1
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                wp_redirect(get_permalink($post_id));
                exit;
            }
        } else {
            // تنظیم کوکی برای نشان دادن نتیجه عدم وجود و ریدایرکت به صفحه نتیجه
            setcookie('search_error', '1', time() + 10, '/');
            wp_redirect('https://palenafurniture.com/verify-authenticity-result/');
            exit;
        }

        wp_reset_postdata();
    }
}
add_action('template_redirect', 'handle_search_form');




add_action( 'admin_menu', 'remove_ask_the_seller_page' );

function remove_ask_the_seller_page() {
    remove_menu_page( 'ask_the_seller' ); // Replace 'ask_the_seller' with the actual slug of the page
}
add_action( 'admin_menu', 'remove_ask_the_seller_custom_page' );

function remove_ask_the_seller_custom_page() {
    remove_menu_page( 'ask_the_seller_custom' ); // Replace 'ask_the_seller_custom' with the actual slug of the page
}

function register_my_menus() {
    register_nav_menus(array(
        'footer-one' => __('Footer Menu-One'),
        'footer-two' => __('Footer Menu-Two'),
        'footer-three' => __('Footer Menu-Three'),
        'footer-four' => __('Footer Menu-Four')
    ));
}
add_action('init', 'register_my_menus');








// Product register Comment /////////////////////////////////////////////




function display_search_results_and_form($content) {
    // بررسی اینکه آیا در صفحه جستجو خاص هستیم و شماره پست ارسال شده است
    if (is_page('verify-authenticity-result') && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_number'])) {
        $post_number = intval($_POST['post_number']);
        $post_id = $post_number; // استفاده از شماره پست برای جستجو

        // دریافت داده‌های ثبت‌شده
        $form_data = get_post_meta($post_id, 'product_registration_data', true);

        // نمایش شماره پست
        $content .= '<div class="productRegistrationResult">';
        $content .= '<div class="container">';
        $content .= '<div class="row">';
        $content .= '<div class="col-12">';
        $content .= '<h1>Serial Number: ' . esc_html($post_number) . '</h1>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';

        // نمایش فرم ثبت‌نام
        ob_start();

        if (isset($_COOKIE['form_submission_status']) && $_COOKIE['form_submission_status'] === 'success') {
            echo '<p class="confirmForm">Thank you! Your submission has been received.</p>';
            setcookie('form_submission_status', '', time() - 3600, '/');
        } elseif (isset($_COOKIE['form_submission_status']) && $_COOKIE['form_submission_status'] === 'error') {
            echo '<p style="color: red;">Please fill in all required fields.</p>';
            setcookie('form_submission_status', '', time() - 3600, '/');
        }

        ?>
        <form id="product-registration-form" method="post">
            <p>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
            </p>
            <p>
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" placeholder="Phone Number" required>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </p>
            <p>
                <label for="shipping_address">Shipping Address:</label>
                <input type="text" id="shipping_address" name="shipping_address" placeholder="Shipping Address" required>
            </p>
            <p>
                <label for="professional_info">Professional Info:</label>
                <textarea id="professional_info" name="professional_info" placeholder="Professional Info" required></textarea>
            </p>
            <p>
                <input type="submit" name="submit_product_registration" value="Submit">
            </p>
        </form>
        <?php

        $form = ob_get_clean();
        $content .= '<div class="container productRegistration">';
        $content .= '<div class="row justify-content-center mt-5">';
        $content .= '<div class="col-12 mb-5">';
        $content .= '<div class="mb-4">' . $form . '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';

        // نمایش داده‌های ثبت‌شده
        if ($form_data && is_array($form_data)) {
            $latest_data = end($form_data);

            $content .= '<p><strong>Client Information:</strong></p>';
            $content .= '<ul>';
            $content .= '<li>Name: ' . esc_html($latest_data['name']) . '</li>';
            $content .= '<li>Phone Number: ' . esc_html($latest_data['phone']) . '</li>';
            $content .= '<li>Email: ' . esc_html($latest_data['email']) . '</li>';
            $content .= '<li>Shipping Address: ' . esc_html($latest_data['shipping_address']) . '</li>';
            $content .= '<li>Professional Info: ' . esc_html($latest_data['professional_info']) . '</li>';
            $content .= '</ul>';
        } else {
            $content .= '';
        }
    }
    return $content;
}
add_filter('the_content', 'display_search_results_and_form');

// نمایش آخرین داده‌های ثبت‌نام در محتوای پست
function display_latest_product_registration_data_in_content($content) {
    if (is_singular('product_registration') && is_main_query()) {
        $post_id = get_the_ID();
        $form_data = get_post_meta($post_id, 'product_registration_data', true);

        if ($form_data && is_array($form_data)) {
            // دریافت آخرین داده
            $latest_data = end($form_data);

            $content .= '<p><strong>Client Information:</strong></p>';
            $content .= '<ul>';
            $content .= '<li>Name: ' . esc_html($latest_data['name']) . '</li>';
            $content .= '<li>Phone Number: ' . esc_html($latest_data['phone']) . '</li>';
            $content .= '<li>Email: ' . esc_html($latest_data['email']) . '</li>';
            $content .= '<li>Shipping Address: ' . esc_html($latest_data['shipping_address']) . '</li>';
            $content .= '<li>Professional Info: ' . esc_html($latest_data['professional_info']) . '</li>';
            $content .= '</ul>';
        } else {
            $content .= '';
        }
    }
    return $content;
}
add_filter('the_content', 'display_latest_product_registration_data_in_content');

// افزودن فرم به محتوای پست
function add_custom_form_to_product_registration($content) {
    if (is_singular('product_registration') && is_main_query()) {
        ob_start();

        // بررسی وضعیت ارسال فرم
        if (isset($_COOKIE['form_submission_status']) && $_COOKIE['form_submission_status'] === 'success') {
            echo '<p style="color: green;">Thank you! Your submission has been received.</p>';
            // حذف کوکی بعد از نمایش پیام
            setcookie('form_submission_status', '', time() - 3600, '/');
        } elseif (isset($_COOKIE['form_submission_status']) && $_COOKIE['form_submission_status'] === 'error') {
            echo '<p style="color: red;">Please fill in all required fields.</p>';
            // حذف کوکی بعد از نمایش پیام
            setcookie('form_submission_status', '', time() - 3600, '/');
        }

        ?>
        <form id="product-registration-form" method="post">
            <p>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
            </p>
            <p>
                <input type="text" id="phone" name="phone" placeholder="Phone Number" required>
            </p>
            <p>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </p>
            <p>
                <input type="text" id="shipping_address" name="shipping_address" placeholder="Shipping Address" required>
            </p>
            <p>
                <textarea id="professional_info" name="professional_info" placeholder="Professional Info" required></textarea>
            </p>
            <p>
                <input type="submit" name="submit_product_registration" value="Submit">
            </p>
        </form>
        <?php
        $form = ob_get_clean();
        $content .= '<div class="container productRegistration">';
        $content .= '<div class="row justify-content-center mt-5">';
        $content .= '<div class="col-12 mb-5">';
        $content .= '<div class="mb-4">' . $form . '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
    }
    return $content;
}
add_filter('the_content', 'add_custom_form_to_product_registration');

// پردازش ارسال فرم
function handle_product_registration_form_submission() {
    if (isset($_POST['submit_product_registration'])) {
        $name = sanitize_text_field($_POST['name']);
        $phone = sanitize_text_field($_POST['phone']);
        $email = sanitize_email($_POST['email']);
        $shipping_address = sanitize_text_field($_POST['shipping_address']);
        $professional_info = sanitize_textarea_field($_POST['professional_info']);
        $post_id = get_the_ID(); // شناسه پست جاری

        // اعتبارسنجی فیلدهای فرم
        if (empty($name) || empty($phone) || empty($email) || empty($shipping_address) || empty($professional_info)) {
            // تنظیم پیغام خطا و بازگشت به صفحه قبلی
            setcookie('form_submission_status', 'error', time() + 10, '/'); // اعتبار 10 ثانیه
            wp_redirect(get_permalink($post_id));
            exit;
        }

        // دریافت داده‌های موجود و افزودن داده‌های جدید
        $existing_data = get_post_meta($post_id, 'product_registration_data', true);
        if (!is_array($existing_data)) {
            $existing_data = array();
        }

        $existing_data[] = array(
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'shipping_address' => $shipping_address,
            'professional_info' => $professional_info
        );
        update_post_meta($post_id, 'product_registration_data', $existing_data);

        // ذخیره وضعیت موفقیت‌آمیز در کوکی
        setcookie('form_submission_status', 'success', time() + 10, '/'); // اعتبار 10 ثانیه

        // ریدایرکت به خود صفحه برای جلوگیری از ارسال مجدد فرم
        wp_redirect(get_permalink($post_id));
        exit;
    }
}
add_action('template_redirect', 'handle_product_registration_form_submission');

function add_custom_meta_box() {
    add_meta_box(
        'product_registration_data_meta_box', // شناسه جعبه متا
        'Customer Data', // عنوان جعبه متا
        'display_product_registration_meta_box_content', // تابع نمایش محتوا
        'product_registration', // نوع پست سفارشی
        'normal', // مکان (normal, side, or advanced)
        'high' // اولویت نمایش
    );
}
add_action('add_meta_boxes', 'add_custom_meta_box');


function display_product_registration_meta_box_content($post) {
    $form_data = get_post_meta($post->ID, 'product_registration_data', true);

    if ($form_data && is_array($form_data)) {
        echo '<table style="width:100%;border-collapse:collapse;">';
        echo '<thead><tr><th>Name</th><th>Phone</th><th>Email</th><th>Shipping Address</th><th>Professional Info</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        
        echo '<tr><td colspan="6" style="text-align:right;">';
        echo '<form method="post" action="' . admin_url('admin-post.php') . '">';
        wp_nonce_field('delete_first_data_action', 'delete_first_data_nonce'); // اضافه کردن nonce
        echo '<input type="hidden" name="action" value="delete_first_product_registration_data">';
        echo '<input type="hidden" name="post_ID" value="' . esc_attr($post->ID) . '">';
       
        echo '</form>';
        echo '</td></tr>';

        foreach ($form_data as $index => $data) {
            echo '<tr>';
            echo '<td>' . esc_html($data['name']) . '</td>';
            echo '<td>' . esc_html($data['phone']) . '</td>';
            echo '<td>' . esc_html($data['email']) . '</td>';
            echo '<td>' . esc_html($data['shipping_address']) . '</td>';
            echo '<td>' . esc_html($data['professional_info']) . '</td>';
            echo '<td>';
            echo '<form method="post" action="' . admin_url('admin-post.php') . '">';
            wp_nonce_field('delete_data_action', 'delete_data_nonce'); // اضافه کردن nonce
            echo '<input type="hidden" name="action" value="delete_product_registration_data">';
            echo '<input type="hidden" name="post_ID" value="' . esc_attr($post->ID) . '">';
            echo '<input type="hidden" name="delete_data_index" value="' . esc_attr($index) . '">';
            echo '<input type="submit" name="delete_data_submit" value="Delete" onclick="return confirm(\'Are you sure you want to delete this entry?\');">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No data submitted.';
    }
}




// پردازش درخواست حذف اولین متا
function handle_delete_first_product_registration_data() {
    if (isset($_POST['delete_first_data_submit'])) {
        // بررسی nonce
        if (!isset($_POST['delete_first_data_nonce']) || !wp_verify_nonce($_POST['delete_first_data_nonce'], 'delete_first_data_action')) {
            wp_die('Security check failed');
        }

        // دریافت شناسه پست از فیلد مخفی
        $post_id = intval($_POST['post_ID']);

        // دریافت داده‌های متا
        $form_data = get_post_meta($post_id, 'product_registration_data', true);

        if ($form_data && is_array($form_data)) {
            // حذف اولین داده از آرایه
            if (!empty($form_data)) {
                array_shift($form_data); // حذف اولین عنصر از آرایه
                $form_data = array_values($form_data); // بازنشانی اندیس‌ها

                // ذخیره‌سازی داده‌های به‌روز شده
                if (empty($form_data)) {
                    delete_post_meta($post_id, 'product_registration_data');
                } else {
                    update_post_meta($post_id, 'product_registration_data', $form_data);
                }

                // تنظیم وضعیت موفقیت‌آمیز در کوکی
                setcookie('delete_first_status', 'success', time() + 10, '/');
            } else {
                setcookie('delete_first_status', 'error', time() + 10, '/');
            }
        } else {
            setcookie('delete_first_status', 'error', time() + 10, '/');
        }

        wp_safe_redirect(admin_url('post.php?post=' . $post_id . '&action=edit'));
        exit;
    } else {
        wp_die('Invalid request.');
    }
}
add_action('admin_post_delete_first_product_registration_data', 'handle_delete_first_product_registration_data');

// پردازش درخواست حذف داده‌ها
function handle_delete_product_registration_data() {
    // ثبت شروع پردازش
    error_log('Start processing delete request.');

    if (isset($_POST['delete_data_submit']) && isset($_POST['delete_data_index'])) {
        // بررسی nonce
        if (!isset($_POST['delete_data_nonce']) || !wp_verify_nonce($_POST['delete_data_nonce'], 'delete_data_action')) {
            error_log('Nonce verification failed.');
            wp_die('Security check failed');
        }

        // دریافت شناسه پست از فیلد مخفی
        $post_id = intval($_POST['post_ID']);
        $index = intval($_POST['delete_data_index']);
        error_log('Post ID: ' . $post_id);
        error_log('Index: ' . $index);

        // دریافت داده‌های ثبت‌شده
        $form_data = get_post_meta($post_id, 'product_registration_data', true);

        // ثبت داده‌های دریافتی
        error_log('Form Data: ' . print_r($form_data, true));

        if ($form_data && is_array($form_data)) {
            // بررسی اینکه آیا اندیس مورد نظر معتبر است
            if (isset($form_data[$index])) {
                // حذف داده از آرایه
                unset($form_data[$index]);
                $form_data = array_values($form_data); // بازنشانی اندیس‌ها

                // ثبت داده‌های جدید
                error_log('Updated Form Data: ' . print_r($form_data, true));

                if (empty($form_data)) {
                    // اگر هیچ داده‌ای باقی نمانده باشد، متادیتا را حذف کن
                    delete_post_meta($post_id, 'product_registration_data');
                    error_log('No remaining data. Metadata deleted.');
                } else {
                    update_post_meta($post_id, 'product_registration_data', $form_data);
                    error_log('Metadata updated.');
                }

                // تنظیم وضعیت موفقیت در کوکی
                setcookie('delete_status', 'success', time() + 10, '/');
            } else {
                // داده پیدا نشد
                error_log('Data not found at index ' . $index);
                setcookie('delete_status', 'error', time() + 10, '/');
            }
        } else {
            // داده‌ها پیدا نشدند
            error_log('Form data is not valid or empty.');
            setcookie('delete_status', 'error', time() + 10, '/');
        }

        // به جای ریدایرکت، کاربر را در همان صفحه ویرایش پست نگه دارید
        wp_safe_redirect(admin_url('post.php?post=' . $post_id . '&action=edit'));
        exit;
    } else {
        error_log('Invalid request or missing parameters.');
        wp_die('Invalid request.');
    }
}
add_action('admin_post_delete_product_registration_data', 'handle_delete_product_registration_data');

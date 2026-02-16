<?php
add_action('init', function() {
    register_post_type('product', [
        'label' => __('Products', 'txtdomain'),
        'public' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-book',
        'supports'            => array( 'title', 'editor', 'revisions'),
        'hierarchical'        => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'has_archive'         => true,
        'can_export'          => true,
        'exclude_from_search' => true,
        'yarpp_support'       => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
//        'rewrite' => ['slug' => 'product'],
        'taxonomies' => ['product_cat','size','product_seller'],
        'labels' => [
            'singular_name' => __('Product', 'txtdomain'),
            'add_new_item' => __('Add new Product', 'txtdomain'),
            'new_item' => __('New Product', 'txtdomain'),
            'view_item' => __('View Product', 'txtdomain'),
            'not_found' => __('No Products found', 'txtdomain'),
            'not_found_in_trash' => __('No Products found in trash', 'txtdomain'),
            'all_items' => __('All Products', 'txtdomain'),
        ],
    ]);

    register_taxonomy('product_cat', ['product'], [
        'label' => __('Product Categories', 'txtdomain'),
        'hierarchical' => true,
        'rewrite' => ['slug' => 'product_cat'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,
        'labels' => [
            'singular_name' => __('Category', 'txtdomain'),
            'all_items' => __('All Categories', 'txtdomain'),
            'edit_item' => __('Edit Category', 'txtdomain'),
            'view_item' => __('View Category', 'txtdomain'),
            'update_item' => __('Update Category', 'txtdomain'),
            'add_new_item' => __('Add New Category', 'txtdomain'),
            'new_item_name' => __('New Category Name', 'txtdomain'),
            'search_items' => __('Search Categories', 'txtdomain'),
            'parent_item' => __('Parent Category', 'txtdomain'),
            'parent_item_colon' => __('Parent Category:', 'txtdomain'),
            'not_found' => __('No Categories found', 'txtdomain'),
        ]
    ]);
    register_taxonomy_for_object_type('product_cat', 'product');


    register_taxonomy('product_seller', ['product'], [
        'label' => __('Seller', 'txtdomain'),
        'hierarchical' => true,
        'rewrite' => ['slug' => 'seller'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,
//        'meta_box_cb'=> 'cb_taxonomy_select_meta_box',
        'labels' => [
            'singular_name' => __('Seller', 'txtdomain'),
            'all_items' => __('All Sellers', 'txtdomain'),
            'edit_item' => __('Edit Seller', 'txtdomain'),
            'view_item' => __('View Seller', 'txtdomain'),
            'update_item' => __('Update Seller', 'txtdomain'),
            'add_new_item' => __('Add New Seller', 'txtdomain'),
            'new_item_name' => __('New Seller Name', 'txtdomain'),
            'search_items' => __('Search Sellers', 'txtdomain'),
            'popular_items' => __('Popular Sellers', 'txtdomain'),
            'separate_items_with_commas' => __('Separate authors with comma', 'txtdomain'),
            'choose_from_most_used' => __('Choose from most used Sellers', 'txtdomain'),
            'not_found' => __('No Sellers found', 'txtdomain'),
            'menu_name' =>'Sellers',
        ]
    ]);
    register_taxonomy_for_object_type('product_seller', 'product');

});

//hook into the init action and call create_topics_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_sizes_nonhierarchical_taxonomy', 0 );

function create_sizes_nonhierarchical_taxonomy() {

// Labels part for the GUI

    $labels = array(
        'name' => 'Size',
        'singular_name' => 'Size',
        'search_items' =>  'Search Size',
        'popular_items' => 'Popular Sizes',
        'all_items' => 'All Sizes',
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' =>'Edit Size',
        'update_item' =>'Update Size',
        'add_new_item' =>'Add New Size',
        'new_item_name' =>'New Size Name',
        'separate_items_with_commas' =>'Separate Sizes with commas',
        'add_or_remove_items' =>'Add or remove Sizes',
        'choose_from_most_used' =>'Choose from the most used Sizes',
        'menu_name' =>'Sizes',
    );

// Now register the non-hierarchical taxonomy like tag

    register_taxonomy('size','product',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'size' ),
        'show_tagcloud'=> false,
        'meta_box_cb'=> 'cb_taxonomy_select_meta_box_size',
    ));
}
/**
 * Display taxonomy selection as dropdown
 *
 * @param WP_Post $post
 * @param array $box
 */
function cb_taxonomy_select_meta_box_size($post, $box)
{
    $defaults = array('taxonomy' => 'size');

    if (!isset($box['args']) || !is_array($box['args']))
        $args = array();
    else
        $args = $box['args'];

    extract(wp_parse_args($args, $defaults), EXTR_SKIP);

    $tax = get_taxonomy($taxonomy);
    $selected = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
    $hierarchical = $tax->hierarchical;
    ?>
    <div id="taxonomy-<?php echo $taxonomy; ?>" class="selectdiv">
        <?php
        if (current_user_can($tax->cap->edit_terms)):
            if ($hierarchical) {
                wp_dropdown_categories(array(
                    'taxonomy' => $taxonomy,
                    'class' => 'widefat',
                    'hide_empty' => 0,
                    'name' => "tax_input[$taxonomy][]",
                    'selected' => count($selected) >= 1 ? $selected[0] : '',
                    'orderby' => 'name',
                    'hierarchical' => 1,
                    'show_option_all' => " "
                ));
            } else {
                ?>
                <select name="<?php echo "tax_input[$taxonomy][]"; ?>" class="widefat" id="sizeSelectSection">
                    <?php foreach (get_terms($taxonomy, array('hide_empty' => false)) as $term): ?>
                        <option value="<?php echo esc_attr($term->slug); ?>" <?php echo selected($term->term_id, count($selected) >= 1 ? $selected[0] : ''); ?>><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
            }
        endif;
        ?>
    </div>
    <?php
}


function cb_taxonomy_select_meta_box($post, $box)
{
    $defaults = array('taxonomy' => 'product_seller');

    if (!isset($box['args']) || !is_array($box['args']))
        $args = array();
    else
        $args = $box['args'];

    extract(wp_parse_args($args, $defaults), EXTR_SKIP);

    $tax = get_taxonomy($taxonomy);
    $selected = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
    $hierarchical = $tax->hierarchical;
    ?>
    <div id="taxonomy-<?php echo $taxonomy; ?>" class="selectdiv">
        <?php
        if (current_user_can($tax->cap->edit_terms)):
            if ($hierarchical) {
                wp_dropdown_categories(array(
                    'taxonomy' => $taxonomy,
                    'class' => 'widefat',
                    'hide_empty' => 0,
                    'name' => "tax_input[$taxonomy][]",
                    'selected' => count($selected) >= 1 ? $selected[0] : '',
                    'orderby' => 'name',
                    'hierarchical' => 1,
                    'show_option_all' => " "
                ));
            } else {
                ?>
                <select name="<?php echo "tax_input[$taxonomy][]"; ?>" class="widefat" >
                    <?php foreach (get_terms($taxonomy, array('hide_empty' => false)) as $term): ?>
                        <option value="<?php echo esc_attr($term->slug); ?>" <?php echo selected($term->term_id, count($selected) >= 1 ? $selected[0] : ''); ?>><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
            }
        endif;
        ?>
    </div>
    <?php
}

function my_disable_gutenberg( $current_status, $post_type ) {

    // Disabled post types
    $disabled_post_types = array( 'product' );

    // Change $can_edit to false for any post types in the disabled post types array
    if ( in_array( $post_type, $disabled_post_types, true ) ) {
        $current_status = false;
    }

    return $current_status;
}
add_filter( 'use_block_editor_for_post_type', 'my_disable_gutenberg', 10, 2 );



add_filter('post_row_actions', function($action, $post) {
    if ($post->post_type == 'product') {
        // Remove "Quick Edit"
        unset($action['inline hide-if-no-js']);
    }
    return $action;
}, 10, 2);




// Add the custom columns to the product post type:
add_filter( 'manage_product_posts_columns', 'set_custom_edit_product_columns' );
function set_custom_edit_product_columns($columns) {
//    unset( $columns['author'] );
    $columns['Image'] = __( 'Image / Images', 'your_text_domain' );
//    $columns['publisher'] = __( 'Publisher', 'your_text_domain' );

    return $columns;
}

// Add the Image to the custom columns for the product post type:
add_action( 'manage_product_posts_custom_column' , 'custom_product_column', 10, 2 );
function custom_product_column( $column, $post_id ) {
    switch ( $column ) {

        case 'Image' :
            $size1=get_the_terms( $post_id, 'size' );
            $size=$size1[0]->slug;
            if ($size == 'horizontal'){
                $photos_query_Horizontal_thumb = get_post_meta( $post_id, 'Horizontal_thumb_data', true );
                $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                if (isset($photos_array_Horizontal_thumb['image_url']) && $photos_array_Horizontal_thumb['image_url'] != null){
                    $url_array_Horizontal_thumb = (array)$photos_array_Horizontal_thumb['image_url'];
                    if (count($url_array_Horizontal_thumb)):
                        foreach ($url_array_Horizontal_thumb as $image_Url):
                            ?>
                            <img src="<?=$image_Url?>" style="width: 90%">
                        <?php
                        endforeach;
                    endif;
                }
            }
            if ($size == 'vertical'){
                $photos_query_vertical_thumb = get_post_meta( $post_id, 'Vertical_thumb_data', true );
                $photos_array_vertical_thumb = (array)($photos_query_vertical_thumb);
                if (isset($photos_array_vertical_thumb['image_url']) && $photos_array_vertical_thumb['image_url'] != null){
                    $url_array_vertical_thumb = (array)$photos_array_vertical_thumb['image_url'];
                    if (count($url_array_vertical_thumb)):
                        foreach ($url_array_vertical_thumb as $image_Url):
                            ?>
                            <img src="<?=$image_Url?>" style="width: 60%">
                        <?php
                        endforeach;
                    endif;
                }

            }
            if ($size == 'horizontal-and-vertical'){
                ?>
                <div style="display: flex; align-content: center;align-items: center;justify-content: space-between;">
                    <?php
                $photos_query_vertical_thumb = get_post_meta( $post_id, 'Vertical_thumb_data', true );
                $photos_array_vertical_thumb = (array)($photos_query_vertical_thumb);
                    if (isset($photos_array_vertical_thumb['image_url']) && $photos_array_vertical_thumb['image_url'] != null){
                        $url_array_vertical_thumb = (array)$photos_array_vertical_thumb['image_url'];
                        if (count($url_array_vertical_thumb)):
                            foreach ($url_array_vertical_thumb as $image_Url):
                                ?>
                                <img src="<?=$image_Url?>" style="width: 40%">
                            <?php
                            endforeach;
                        endif;
                    }

                $photos_query_Horizontal_thumb = get_post_meta( $post_id, 'Horizontal_thumb_data', true );
                $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                    if (isset($photos_array_Horizontal_thumb['image_url']) && $photos_array_Horizontal_thumb['image_url'] != null){
                        $url_array_Horizontal_thumb = (array)$photos_array_Horizontal_thumb['image_url'];
                        if (count($url_array_Horizontal_thumb)):
                            foreach ($url_array_Horizontal_thumb as $image_Url):
                                ?>
                                <img src="<?=$image_Url?>" style="width: 60%">
                            <?php
                            endforeach;
                        endif;
                    }
                ?>
                </div>
                <?php
            }


            break;

//        case 'publisher' :
//            echo get_post_meta( $post_id , 'publisher' , true );
//            break;

    }
}

// initial hook
add_action( 'save_post', 'wpse105926_save_post_callback' );

function wpse105926_save_post_callback( $post_id ) {

    // verify post is not a revision
    if ( ! wp_is_post_revision( $post_id ) ) {

        // unhook this function to prevent infinite looping
        remove_action( 'save_post', 'wpse105926_save_post_callback' );

        // update the post slug
        wp_update_post( array(
            'ID' => $post_id,
            'post_name' => '' // do your thing here
        ));

        // re-hook this function
        add_action( 'save_post', 'wpse105926_save_post_callback' );

    }
}

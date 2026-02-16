<?php
add_action('init', function() {
    register_post_type('story', [
        'label' => __('Stories', 'txtdomain'),
        'public' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-book',
        'show_in_rest' => true,
//        'rewrite' => ['slug' => 'story'],
        'taxonomies' => ['story_author', 'story_cat'],

        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'comments'),
        'hierarchical'        => true,
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

        'labels' => [
            'singular_name' => __('Story', 'txtdomain'),
            'add_new_item' => __('Add new Story', 'txtdomain'),
            'new_item' => __('New Story', 'txtdomain'),
            'view_item' => __('View Story', 'txtdomain'),
            'not_found' => __('No Stories found', 'txtdomain'),
            'not_found_in_trash' => __('No Stories found in trash', 'txtdomain'),
            'all_items' => __('All Stories', 'txtdomain'),
        ],
    ]);

    register_taxonomy('story_cat', ['story'], [
        'label' => __('Story Categories', 'txtdomain'),
        'hierarchical' => true,
        'rewrite' => ['slug' => 'story_cat'],
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
    register_taxonomy_for_object_type('story_cat', 'story');

    register_taxonomy('story_author', ['story'], [
        'label' => __('Authors', 'txtdomain'),
        'hierarchical' => true,
        'rewrite' => ['slug' => 'story_author'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,
        'labels' => [
            'singular_name' => __('Author', 'txtdomain'),
            'all_items' => __('All Authors', 'txtdomain'),
            'edit_item' => __('Edit Author', 'txtdomain'),
            'view_item' => __('View Author', 'txtdomain'),
            'update_item' => __('Update Author', 'txtdomain'),
            'add_new_item' => __('Add New Author', 'txtdomain'),
            'new_item_name' => __('New Author Name', 'txtdomain'),
            'search_items' => __('Search Authors', 'txtdomain'),
            'popular_items' => __('Popular Authors', 'txtdomain'),
            'separate_items_with_commas' => __('Separate authors with comma', 'txtdomain'),
            'choose_from_most_used' => __('Choose from most used Authors', 'txtdomain'),
            'not_found' => __('No Authors found', 'txtdomain'),
        ]
    ]);
    register_taxonomy_for_object_type('story_author', 'story');
});
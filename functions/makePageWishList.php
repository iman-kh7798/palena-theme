<?php
if (!function_exists('ideaMakeWishListPage')){
    function ideaMakeWishListPage(){


        $currentTime=date('Y-m-d H:i:s',current_time('U'));
        $date_GMT = new DateTime("now", new DateTimeZone('GMT') );
        $date_GMT=$date_GMT->format('Y-m-d H:i:s');
        $postTitle='wishList';
        $postName='wish-list';
        global $wpdb;
        $args=[
            'post_author' => 1,
            'post_date' => $currentTime,
            'post_date_gmt' => $date_GMT,
            'post_title' => $postTitle,
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_name' => $postName,
            'post_modified'=>$currentTime,
            'post_modified_gmt'=>$date_GMT,
            'post_parent' => 0,
            'menu_order' => 0,
            'post_type'=>'page',
        ];
        $tablename = $wpdb->prefix.'posts';
        $results = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE post_name='{$postName}' AND post_type='page'", OBJECT );
        if ($results && count($results)){
            $result=$results[0];
            $wpdb->update($wpdb->prefix.'posts', $args, array('ID'=>$result->ID));
        }else{
            $res= $wpdb->insert( $tablename, $args );
        }
        $results = $wpdb->get_results( "SELECT ID FROM {$wpdb->prefix}posts WHERE post_title='{$postTitle}' AND post_name='{$postName}'AND post_type='page'", OBJECT );
        if ($results){
            $results=$results[0];
            $results->ID;
            add_post_meta($results->ID,'_wp_page_template','page-wishList.php');
        }
    }
}

add_action('after_setup_theme', 'ideaMakeWishListPage');
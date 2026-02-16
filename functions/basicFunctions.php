<?php



// Add menu layout
add_action('init', function () {
    register_nav_menus([
            'top_menu' => "site top menu",
        ]);
});














/*  نمایش همه دسته بندی های محصولات  */
function wo_get_all_categories()
{
    $args = [
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => 0,
    ];
    $product_cat = get_terms($args);

    foreach ($product_cat as $parent_product_cat) {

        echo '
      <ul>
        <li><a href="' . get_term_link($parent_product_cat->term_id) . '">' . $parent_product_cat->name . '</a>
        <ul>
          ';
        $child_args = [
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'parent' => $parent_product_cat->term_id,
        ];
        $child_product_cats = get_terms($child_args);
        foreach ($child_product_cats as $child_product_cat) {
            echo '<li><a href="' . get_term_link($child_product_cat->term_id) . '">' . $child_product_cat->name . '</a></li>';
        }

        echo '</ul>
      </li>
    </ul>';
    }
}

/* ایجاد دسته بندی محصولات با ویژگی زیر شاخه ای تا عمق 3  */
function wo_get_all_sub_category_by_term_id($term_id=0){
    $array=[];
    $args=[
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'parent' => intval($term_id),
    ];
    $product_cats = get_terms($args);
    if (count($product_cats)){
        foreach ($product_cats as $key=>$cat){
            $array[$cat->term_id]['link']=get_term_link($cat->term_id);
            $array[$cat->term_id]['name']=$cat->name;
            $array[$cat->term_id]['term_id']=$cat->term_id;
            $array[$cat->term_id]['hasChile']=false;
            $array[$cat->term_id]['child']=[];

            $args2=[
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent' => $cat->term_id,
            ];
            $product_cats2 = get_terms($args2);
            if (count($product_cats2)){
                $array[$cat->term_id]['hasChile']=true;
                foreach ($product_cats2 as $key=>$cat2){
                    $array[$cat->term_id]['child'][$cat2->term_id]['link']=get_term_link($cat2->term_id);
                    $array[$cat->term_id]['child'][$cat2->term_id]['name']=$cat2->name;
                    $array[$cat->term_id]['child'][$cat2->term_id]['term_id']=$cat2->term_id;
                    $array[$cat->term_id]['child'][$cat2->term_id]['hasChile']=false;
                    $array[$cat->term_id]['child'][$cat2->term_id]['child']=[];

                    $args3=[
                        'taxonomy' => 'product_cat',
                        'hide_empty' => false,
                        'parent' => $cat2->term_id,
                    ];
                    $product_cats3 = get_terms($args3);
                    if (count($product_cats3)){
                        $array[$cat->term_id]['child'][$cat2->term_id]['hasChile']=true;
                        foreach ($product_cats3 as $key=>$cat3){
                            $array[$cat->term_id]['child'][$cat2->term_id]['child'][$cat3->term_id]['link']=get_term_link($cat3->term_id);
                            $array[$cat->term_id]['child'][$cat2->term_id]['child'][$cat3->term_id]['name']=$cat3->name;
                            $array[$cat->term_id]['child'][$cat2->term_id]['child'][$cat3->term_id]['term_id']=$cat3->term_id;
                            $array[$cat->term_id]['child'][$cat2->term_id]['child'][$cat3->term_id]['hasChile']=false;
                            $array[$cat->term_id]['child'][$cat2->term_id]['child'][$cat3->term_id]['child']=[];


                        }
                    }

                }
            }
        }
    }
    return $array;

}

/** Remove categories from shop and other pages
 * in Woocommerce
 */
function wc_hide_selected_terms( $terms, $taxonomies, $args=null ) {
    $new_terms = array();
    if ( in_array( 'product_cat', $taxonomies ) && !is_admin()  ) {
        foreach ( $terms as $key => $term ) {
            if ( ! in_array( $term->slug, array( 'uncategorized' ) ) ) {
                $new_terms[] = $term;
            }
        }
        $terms = $new_terms;
    }
    return $terms;
}
add_filter( 'get_terms', 'wc_hide_selected_terms', 10, 3 );



function get_image_details($url): object
{
    $attachment_id = attachment_url_to_postid( $url );
    $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true );
    $title = get_the_title($attachment_id);
    $caption = wp_get_attachment_caption($attachment_id);
    $img = get_post($attachment_id);
    return (object)['id'=>$attachment_id,'alt'=>$alt,'title'=>$title,'caption'=>$caption,'description'=>$img->post_content];
}



function enqueue_select2_jquery() {
    wp_register_style( 'select2css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', false, '4.0', 'all' );
    wp_register_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js');
    wp_enqueue_style( 'select2css' );
    wp_enqueue_script( 'select2' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_select2_jquery' );
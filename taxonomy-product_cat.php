<?php

get_header();

if (function_exists('yoast_breadcrumb')) :
    ?>
    <div class="container-fluid navbar_dark">
        <?php
        yoast_breadcrumb('<p id="breadcrumbs"  class="navbar_dark breadcrumb-item active pt-2 pb-3">', '</p>');
        ?>
    </div>
<?php
endif;

$args = array(
    'post_type' => 'product',
    "orderby" => 'meta_value_num',
    "meta_key" => 'Priority',
    "order" => 'DESC',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => get_query_var('taxonomy'),
            'field' => 'slug',
            'terms' => get_query_var('term'),

        ),
    )
);
?>
<div class="large_archive container-fluid">
    <div class="my-3 section_title ">
        <h3 class="h5"><?= ucwords(str_replace('-', ' ', get_query_var('term'))) ?></h3>
    </div>
    <div class="row">
        <?php
        $newPosts = new WP_Query($args);
        $size = null;
        if ($newPosts->have_posts()) :

            while ($newPosts->have_posts()) : $newPosts->the_post();
                global $post;
                $size1 = get_the_terms($post, 'size');
                $size = $size1[0]->slug; ?>

                <?php
                if ($size == 'horizontal'):
                    ?>
                    <div class="mt-4 col-12">
                        <div class="card mb-2 border-0">
                            <?php $photos_query_Horizontal_thumb = get_post_meta($post->ID, 'Horizontal_thumb_data', true);
                            $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                            $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                            if (count($url_array_Horizontal_thumb)):
                                foreach ($url_array_Horizontal_thumb as $image_Url):
                                    $Horizontal_thumb_Detail = get_image_details($image_Url); ?>
                                    <img src="<?= $image_Url ?>" class="card-img-top img-fluid mr-auto ml-auto w-75"
                                         alt="<?= $Horizontal_thumb_Detail->alt ?>"
                                         title="<?= $Horizontal_thumb_Detail->title ?>">
                                <?php endforeach; endif; ?>
                            <div class="card-body">
                                <h5 class="h6"><a class="product_name stretched-link"
                                                  href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h5>
                            </div>
                        </div>

                    </div>
                <?php endif;
                if ($size == 'vertical'):
                    ?>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card mb-2 border-0">
                            <?php $photos_query_Vertical_thumb = get_post_meta($post->ID, 'Vertical_thumb_data', true);
                            $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                            $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                            if (count($url_array_Vertical_thumb)):
                                foreach ($url_array_Vertical_thumb as $image_Url):
                                    $Vertical_thumb_Detail = get_image_details($image_Url); ?>
                                    <img src="<?= $image_Url ?>" class="card-img-top img-fluid mr-auto ml-auto w-100"
                                         alt="<?= $Vertical_thumb_Detail->alt ?>"
                                         title="<?= $Vertical_thumb_Detail->title ?>">
                                <?php endforeach; endif; ?>
                            <div class="card-body">
                                <h5 class="h6"><a class="product_name stretched-link"
                                                  href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h5>
                            </div>
                        </div>

                    </div>
                <?php endif;
                if ($size == 'horizontal-and-vertical'):
                    ?>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card mb-3 border-0">
                            <?php $photos_query_Vertical_thumb = get_post_meta($post->ID, 'Vertical_thumb_data', true);
                            $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                            $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                            if (count($url_array_Vertical_thumb)):
                                foreach ($url_array_Vertical_thumb as $image_Url):
                                    $Vertical_thumb_Detail = get_image_details($image_Url); ?>
                                    <img src="<?= $image_Url ?>" class="card-img-top img-fluid mr-auto ml-auto w-100"
                                         alt="<?= $Vertical_thumb_Detail->alt ?>"
                                         title="<?= $Vertical_thumb_Detail->title ?>">
                                <?php endforeach; endif; ?>
                            <div class="card-body">
                                <h5 class="h6"><a class="product_name stretched-link"
                                                  href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h5>
                            </div>
                        </div>

                    </div>
                    <div class="mt-4 col-12 col-sm-6 col-md-8">
                        <div class="card mb-3 border-0">
                            <?php $photos_query_Horizontal_thumb = get_post_meta($post->ID, 'Horizontal_thumb_data', true);
                            $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                            $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                            if (count($url_array_Horizontal_thumb)):
                                foreach ($url_array_Horizontal_thumb as $image_Url):
                                    $Horizontal_thumb_Detail = get_image_details($image_Url); ?>
                                    <img src="<?= $image_Url ?>" class="card-img-top img-fluid mr-auto ml-auto w-100"
                                         alt="<?= $Horizontal_thumb_Detail->alt ?>"
                                         title="<?= $Horizontal_thumb_Detail->title ?>">
                                <?php endforeach; endif; ?>
                            <div class="card-body">
                                <h5 class="h6"><a class="product_name stretched-link" href="<?= get_permalink() ?>"></a>
                                </h5>
                            </div>
                        </div>

                    </div>
                <?php endif; ?>

            <?php
            endwhile;
            wp_reset_query();

        endif;
        ?>
    </div>
</div><?php
get_footer();

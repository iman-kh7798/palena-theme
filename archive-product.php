<?php get_header(); ?>
<?php if (function_exists('yoast_breadcrumb')) :
    ?>
    <div class="container-fluid navbar_dark">
        <?php
        yoast_breadcrumb('<p id="breadcrumbs"  class="navbar_dark breadcrumb-item active pt-2 pb-2">', '</p>');
        ?>
    </div>
<?php
endif; ?>
    <div class="container-fluid large_archive">

<div class="my-3 section_title ">
    All Products
    </h1>
    </div>
        <div class="row">
            <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        global $post;
                        $size1 = get_the_terms($post, 'size');
                        $size = $size1[0]->slug;
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
                                <h2 class="h6"><a class="product_name stretched-link"
                                                  href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h2>
                            </div>
                        </div>

                    </div>
                    
                <?php

                endwhile;


                /* Restore original Post Data */
                wp_reset_postdata();
            else:
                echo "nothing to show ! .";
            endif;
            if (function_exists('wp_pagenavi')) { ?>
            <div class="col-12 my-5">
                <?php wp_pagenavi(); ?>
            </div>
            <?php }
            ?>
            
          
        

        </div>
    </div>
<?php get_footer();


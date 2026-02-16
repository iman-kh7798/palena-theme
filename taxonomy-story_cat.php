
<?php

get_header();
//if (function_exists('yoast_breadcrumb')) {
//    yoast_breadcrumb('<p id="breadcrumbs"  class="container breadcrumb-item active pt-2 pb-2">', '</p>');
//}
if (function_exists('yoast_breadcrumb')) :
   ?>
<div class="container-fluid navbar_dark">
    <?php
    yoast_breadcrumb('<p id="breadcrumbs"  class="container navbar_dark breadcrumb-item active pt-2 pb-2">', '</p>');
    ?>
</div>
<?php
endif;

$args = array(
    'post_type' => 'story',
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
   <div class="container-fluid">
    <div class="row">
<?php get_template_part('sidebar_story'); ?>
    <div class="col-12 col-md-12 col-lg-9 col-sm-12">
        <div class="large_archive container-fluid">
            <div class="my-3 section_title ">
                <h3 class="h5"><?= get_query_var('term') ?></h3>
            </div>
            <div class="row">
                <?php
                $newPosts = new WP_Query($args);
                if ($newPosts->have_posts()) :
                    while ($newPosts->have_posts()) : $newPosts->the_post();
                        global $post; ?>
                        <div class="head_blog_main_text d-flex flex-column mb-3">
                            <h2 class="title_blog_main_text head_title"><?php the_title(); ?></h2>
                            <div class="d-flex row text-justify">
                                <div class="col-12">
                                    <?php the_post_thumbnail('',['class'=>'img-fluid']); ?>
                                </div>
                                <div class="col-12">
                                    <p class="text-justify p-2"><?php the_excerpt(); ?>  </p>
                                </div>

                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm m-2 btn_read_more"
                                   title="<?php the_title_attribute(); ?>">Read More ...</a>
                            </div>
                        </div>
                        <hr>

                    <?php
                    endwhile;
                    wp_reset_query();

                endif;
                ?>
            </div>
        </div>
    </div>
    </div>
   </div>
<?php
get_footer();

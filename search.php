<?php
if (isset($_GET['s']) && trim($_GET['s']) == ''){
    wp_redirect(home_url( '/product' ));
}
get_header();
do_action( 'woocommerce_before_main_content' );
if ( function_exists('yoast_breadcrumb') ) {
  yoast_breadcrumb( '<p id="breadcrumbs"  class="container breadcrumb-item active pt-2 pb-2">','</p>' );
}

?>
     <div class="container Section1_Archive">
        <?php
        global $wp_query;
        if (is_tax('product_cat')) {
            $current_cat = $wp_query->queried_object;
            if ($current_cat->description) {
                ?>
                    <div class="category_description mb-2">
                        <div class="head_description d-flex flex-column">
                            <h1 class="head_title p-2 title_cat_description"><?= $current_cat->name ?></h1>
                                <div class="col-12 more cat_description pl-4 pr-4 pt-2 pb-2 text-justify">
                                      <?= $current_cat->description ?>
                                </div>
                        </div>
                    </div>
                <?php
            }
        }

        ?>
        <div class="row d-flex flex-row-reverse mt-3">
            <div class="col-12 col-md-9 Archive_Products">
                <div class="Header d-flex justify-content-between JK_bg_grey_color mb-1 pr-2 pl-2 align-items-center">
                    <h1 class="h6 py-2 pr-4 ">Search</h1>
                </div>
                <div class="Product_Box  container">
                    <div class="row justify-content-center justify-content-md-between ">
                        <?php  if (have_posts()) :
                            while (have_posts()) :
                                the_post();
                                global $post;
                                global $post; ?>
                                <div class="card p-0 px-1 col-12  col-md-6 col-lg-4 mt-1 align-items-center pt-2">

                                    <div class="card-body w-100 py-2 text-center align-items-center">
                                        <h2 class="card-title h7 font-weight-light px-1"><?php the_title(); ?></h2>

                                            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-info h9">مشاهده</a>
                                        </div>
                                    </div>
                                </div>
                                <?php

                          endwhile;
                        else :
                            echo "nothing to show ! . .";
                        endif;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
            <?php get_template_part('sidebar'); ?>
        </div>
    </div>
<?php
get_footer();


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
    <div class="container-fluid">


        <div class="row">

            <div class="col-12">
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        ?>
                        <div class="head_blog_main_text d-flex flex-column mb-3">
<!--                            <h2 class="title_blog_main_text head_title">--><?php //the_title(); ?><!--</h2>-->
                            <div class="d-flex row text-justify">
                                <div class="">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('full',['class'=>'img-fluid']); ?>

                                    </a>
                                </div>
<!--                                <div class="col-12">-->
<!--                                    <p class="text-justify p-2">--><?php //the_excerpt(); ?><!--  </p>-->
<!--                                </div>-->

                            </div>
<!--                            <div class="d-flex justify-content-end">-->
<!--                                <a href="--><?php //the_permalink(); ?><!--" class="btn btn_outline_pf btn_read_more"-->
<!--                                   title="--><?php //the_title_attribute(); ?><!--">Read Story ...</a>-->
<!--                            </div>-->
                        </div>
<!--                        <hr>-->

                    <?php

                    endwhile;


                    /* Restore original Post Data */
                    wp_reset_postdata();
                else:
                    echo "nothing to show ! .";
                endif;
                if(function_exists('wp_pagenavi')){
                    wp_pagenavi();
                }
                ?>
            </div>

        </div>
    </div>
<?php get_footer();


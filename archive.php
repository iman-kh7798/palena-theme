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


        <div class="row justify-content-center">
            
            <div class="col-12 col-lg-8">
			<?php
if (have_posts()) :
    while (have_posts()) :
        the_post();
        ?>
        <div class="blog_box d-flex flex-column mb-3">
                            <a  href="<?php the_permalink(); ?>" class="blog_post_title"><h2 class="text-sm"><?php the_title(); ?></h2></a>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-7 d-flex p-2 justify-content-center">
                                        <?php the_post_thumbnail('medium_large',  array( 'class' => 'img-fluid' )); ?>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-5">
                                        <?php  echo '<p class="text-justify pt-2">' . get_the_excerpt() . '</p>' ?>
                                        <span class="d-flex justify-content-end">
						                    <a href="<?php the_permalink(); ?>" class="btn btn_outline_pf w-50 mt-1 text-sm"
                                               title="<?php the_title_attribute(); ?>">more...</a>
                                        </span>
                                    </div>

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
if(function_exists('wp_pagenavi')){ ?>
    <div class="mt-5 mb-5">
        <?php wp_pagenavi(); ?>
    </div>
<?php }
?>
            </div>

        </div>
    </div>
<?php get_footer();


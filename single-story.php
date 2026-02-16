<?php get_header(); ?>
<?php if (function_exists('yoast_breadcrumb')) :
    ?>
    <div class="container-fluid navbar_dark">
        <?php
        yoast_breadcrumb('<p id="breadcrumbs"  class="container navbar_dark breadcrumb-item active pt-2 pb-2">', '</p>');
        ?>
    </div>
<?php
endif; ?>
    <div class="container-fluid">


        <div class="row flex-row-reverse">

            <div class="col-12">
<!--                <div class="w-100">--><?php //the_post_thumbnail('',['class'=>'img-fluid']); ?><!--</div>-->
                <div class="head_blog_main_text mb-3 d-flex flex-column text-justify">
                <?php
                  if (have_posts()):while (have_posts()) :
                       the_post();
                      ?>
<!--                        <h1 class="head_title p-2 title_blog_main_text">--><?php //the_title(); ?><!--</h1>-->
                       <?php echo '<p class="text-justify p-2">' . the_content() . '</p>';

                    endwhile;
                    endif;
                    ?>
                </div>
                            </div>
            <?php get_template_part('sidebar_story'); ?>
            </div>
        </div>
    </div>
<?php get_footer();
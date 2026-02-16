<?php get_header(); ?>
<?php if (function_exists('yoast_breadcrumb')) :
    ?>
    <div class="container-fluid navbar_dark test_blog">
        <?php
        yoast_breadcrumb('<p id="breadcrumbs"  class="container navbar_dark breadcrumb-item active pt-2 pb-2">', '</p>');
        ?>
    </div>
<?php
endif; ?>
    <div class="container productRegistration">
        <div class="row flex-row-reverse">

            <div class="col-12 p-5">
                <div class="head_blog_main_text d-flex flex-column text-justify">
                    <?php
                    if (have_posts()):while (have_posts()) :
                        the_post();
                        ?>
                        <h1 class="head_title p-2 mb-4 title_blog_main_text"><?php the_title(); ?></h1>
                        <?php  echo '<p class="text-justify">' . the_content() . '</p>';

                    endwhile;
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </div>
    </div>
<?php get_footer();
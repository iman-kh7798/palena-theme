<?php
/*
Template Name: Product Registration
*/
get_header();
?>
<?php if (function_exists('yoast_breadcrumb')) :
    ?>
    <div class="container-fluid navbar_dark">
        <?php
        yoast_breadcrumb('<p id="breadcrumbs"  class="navbar_dark breadcrumb-item active pt-2 pb-2">', '</p>');
        ?>
    </div>
<?php
endif; ?>
    <div class="container-fluid productRegistration">
        <div class="row">
            <div class="col-12">
                <div class="registerHeader">

                         <?php
                            $hero_image_url = get_post_meta(get_the_ID(), 'hero_image', true);
                            if ($hero_image_url) {
                                echo '<img class="cover" src="' . esc_url($hero_image_url) . '" alt="product registration">';
                                echo '<img src="' . esc_url($hero_image_url) . '" alt="product registration">';
                            }
                            ?>

                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5 pt-4">
            <div class="col-12 col-lg-9">
                <h2>Inviting Reflection: Your Palena Art Ownership</h2>
            </div>

            <div class="col-12 mt-4 pb-3">
                <div class="formWrapper">
                    <form method="post" action="/verify-authenticity-result/">
                        <input type="text" id="post_number" name="post_number"
                               placeholder="Product Serial Number"><br><br>
                        <input type="submit" value="VERIFY" class="form-control">
                    </form>
                </div>
            </div>


            <div class="col-12 col-lg-9 mb-5">
                <div class="mb-4"><?php handle_search_form(); ?></div>
                <div><?php the_content(); ?></div>
            </div>

        </div>
    </div>
<?php get_footer();


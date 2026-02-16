<?php
/*
Template Name: Product Registration Result
*/
get_header(); ?>
<?php if (function_exists('yoast_breadcrumb')) : ?>
    <div class="container-fluid navbar_dark">
        <?php yoast_breadcrumb('<p id="breadcrumbs"  class="navbar_dark breadcrumb-item active pt-2 pb-2">', '</p>'); ?>
    </div>
<?php endif; ?>

    <div class="container productRegistration">
        <div class="row justify-content-center mt-5">
            <div class="col-12 mb-5">
                <?php
                echo '<div class="prNotFound"><p>This Product Not Registered.</p>
                <a href="/verify-authenticity/">Back to Verify Authenticity</a></div>';
                ?>
            </div>
        </div>
    </div>


<?php get_footer();


<?php
get_header();
$theme_settings = get_option('mainThemeSettingPage');

?>
<!-- main slider -->
<div class=" ">
    <div class="main_slider">
        <?php
        $args = [
            'post_type' => 'slider',
            'posts_per_page' => -1,
        ];
        $query_slider = new WP_Query($args);
        $topslider = [];
        $counterKey = 0;
        if ($query_slider->have_posts()):
            while ($query_slider->have_posts()):
                $query_slider->the_post();
                global $post;
                $image1Details = get_image_details(get_post_meta($post->ID, 'slider_img_mobile_slider', true));
                $image2Details = get_image_details(get_post_meta($post->ID, 'slider_img', true));
        ?>
                <div class="swiper-slide">
                    <a class="main_slider_item" href="<?= get_post_meta($post->ID, 'slider_link', true); ?>"></a>
                    <video autoplay muted loop playsinline preload="auto" class="d-md-none">
                        <source src="<?= get_post_meta($post->ID, 'slider_img_mobile_slider', true); ?>" type="video/mp4">
                        <source src="<?php echo get_template_directory_uri(); ?>/assets/img/Banner-Mobile.webm" type="video/webm">
                        <!--                            <source src="video.ogv" type="video/ogg">-->
                        Your browser isn't Supported Video.
                    </video>
                    <!--<video
                               class="d-md-none" preload="auto"
                               src="<?php /*= get_post_meta($post->ID, 'slider_img_mobile_slider', true); */ ?>"
                               autoplay muted loop></video>-->
                    <video class="d-none d-md-block" preload="auto"
                        src="<?= get_post_meta($post->ID, 'slider_img', true); ?>" autoplay muted loop></video>

                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

    </div>
</div>

<!--Trending Products!-->
<?php
$TrendingProductsArray = [];
if (isset($theme_settings['TrendingProducts']) && is_array($theme_settings['TrendingProducts'])) {
    $TrendingProductsArray = $theme_settings['TrendingProducts'];
}
$args = array(
    'post_type' => array('product'),
    'orderby' => 'ASC',
    'post__in' => $TrendingProductsArray,
    'posts_per_page' => 20
);

$loop = new WP_Query($args);
if ($loop->have_posts()) : ?>

    <div class="trending_products my-2 mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="my-3 pl-lg-1 section_title">
                        <h3>Trending Products</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (count($TrendingProductsArray)): ?>
        <div class="trending_products">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="swiper trendingProductsSlider">
                            <div class="swiper-wrapper">
                                <?php
                                while ($loop->have_posts()) :
                                    $loop->the_post();
                                    global $post;
                                    $size1 = get_the_terms($post, 'size');
                                    $size = $size1[0]->name;
                                    //  for ($i=0;$i<20;$i++){
                                    if ($size == 'horizontal'):
                                ?>
                                        <div class="swiper-slide">
                                            <div class="card  border-0 card-img">
                                                <?php $photos_query_Horizontal_thumb = get_post_meta($post->ID, 'Horizontal_thumb_data', true);
                                                $gallery_data = get_post_meta($post->ID, 'gallery_data', true);
                                                $gallery_data_image_url = $gallery_data['image_url'];
                                                $gallery_data_first_image_url = isset($gallery_data_image_url[0]) ? $gallery_data_image_url[0] : '';
                                                $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                                $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                                if (count($url_array_Horizontal_thumb)):
                                                    foreach ($url_array_Horizontal_thumb as $image_Url):
                                                        $Horizontal_thumb_Detail = get_image_details($image_Url);
                                                        $gallery_data_first_image_Detail = get_image_details($gallery_data_first_image_url);
                                                ?>
                                                        <img src="<?= $image_Url ?>"
                                                            class="card-img-top img-fluid  w-100"
                                                            alt="<?= $Horizontal_thumb_Detail->alt ?>"
                                                            title="<?= $Horizontal_thumb_Detail->title ?>">
                                                        <?php if ($gallery_data_first_image_url): ?>
                                                            <img src="<?= $gallery_data_first_image_url ?>"
                                                                class="card-img-top img-fluid w-100 card-img-hover"
                                                                alt="<?= $gallery_data_first_image_Detail->alt ?>"
                                                                title="<?= $gallery_data_first_image_Detail->title ?>">
                                                        <?php endif; ?>
                                                <?php endforeach;
                                                endif; ?>
                                                <div class="card-body">
                                                    <h5 class="h6"><a class="product_name stretched-link"
                                                            href="<?= the_permalink() ?>"><?= the_title() ?></a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;
                                    if ($size == 'vertical'):
                                    ?>
                                        <div class="swiper-slide">
                                            <div class="card  border-0 card-img">
                                                <?php $photos_query_Vertical_thumb = get_post_meta($post->ID, 'Vertical_thumb_data', true);
                                                $gallery_data = get_post_meta($post->ID, 'gallery_data', true);
                                                $gallery_data_image_url = $gallery_data['image_url'];
                                                $gallery_data_first_image_url = isset($gallery_data_image_url[0]) ? $gallery_data_image_url[0] : '';
                                                $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                                                $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                                                if (count($url_array_Vertical_thumb)):
                                                    foreach ($url_array_Vertical_thumb as $image_Url):
                                                        $Vertical_thumb_Detail = get_image_details($image_Url);
                                                        $gallery_data_first_image_Detail = get_image_details($gallery_data_first_image_url);
                                                ?>
                                                        <img src="<?= $image_Url ?>"
                                                            class="card-img-top img-fluid w-100"
                                                            alt="<?= $Vertical_thumb_Detail->alt ?>"
                                                            title="<?= $Vertical_thumb_Detail->title ?>">
                                                        <?php if ($gallery_data_first_image_url): ?>
                                                            <img src="<?= $gallery_data_first_image_url ?>"
                                                                class="card-img-top img-fluid w-100 card-img-hover"
                                                                alt="<?= $gallery_data_first_image_Detail->alt ?>"
                                                                title="<?= $gallery_data_first_image_Detail->title ?>">
                                                        <?php endif; ?>
                                                <?php endforeach;
                                                endif; ?>
                                                <div class="card-body">
                                                    <h5 class="h6"><a class="product_name stretched-link"
                                                            href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                                    </h5>
                                                </div>
                                            </div>

                                        </div>
                                    <?php endif;
                                    if ($size == 'horizontal and vertical'):
                                    ?>
                                        <div class="swiper-slide">
                                            <div class="card  border-0">
                                                <?php $photos_query_Vertical_thumb = get_post_meta($post->ID, 'Vertical_thumb_data', true);
                                                $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                                                $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                                                if (count($url_array_Vertical_thumb)):
                                                    foreach ($url_array_Vertical_thumb as $image_Url):
                                                        $Vertical_thumb_Detail = get_image_details($image_Url); ?>
                                                        <img src="<?= $image_Url ?>"
                                                            class="card-img-top img-fluid mr-auto ml-auto w-100"
                                                            alt="<?= $Vertical_thumb_Detail->alt ?>"
                                                            title="<?= $Vertical_thumb_Detail->title ?>">
                                                <?php endforeach;
                                                endif; ?>
                                                <div class="card-body">
                                                    <h5 class="h6"><a class="product_name stretched-link"
                                                            href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                                    </h5>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="swiper-slide">
                                            <div class="card  border-0">
                                                <?php $photos_query_Horizontal_thumb = get_post_meta($post->ID, 'Horizontal_thumb_data', true);
                                                $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                                $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                                if (count($url_array_Horizontal_thumb)):
                                                    foreach ($url_array_Horizontal_thumb as $image_Url):
                                                        $Horizontal_thumb_Detail = get_image_details($image_Url); ?>
                                                        <img src="<?= $image_Url ?>"
                                                            class="card-img-top img-fluid mr-auto ml-auto w-100"
                                                            alt="<?= $Horizontal_thumb_Detail->alt ?>"
                                                            title="<?= $Horizontal_thumb_Detail->title ?>">
                                                <?php endforeach;
                                                endif; ?>
                                                <div class="card-body">
                                                    <h5 class="h6"><a class="product_name stretched-link"
                                                            href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                                    </h5>
                                                </div>
                                            </div>

                                        </div>
                                    <?php endif;
                                    ?>

                                <?php
                                // } // end for
                                endwhile;
                                wp_reset_query()
                                ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<?php
    endif;
endif;
?>


<!--Trending Products 2 !-->
<?php
$TrendingProductsArray2 = [];
if (isset($theme_settings['TrendingProducts2']) && is_array($theme_settings['TrendingProducts2'])) {
    $TrendingProductsArray2 = $theme_settings['TrendingProducts2'];
}
$args = array(
    'post_type' => array('product'),
    'orderby' => 'ASC',
    'post__in' => $TrendingProductsArray2,
    'posts_per_page' => 20
);


$loop = new WP_Query($args);
if ($loop->have_posts() && count($TrendingProductsArray2)) : ?>

    <div class="trending_products mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div dir="rtl" class="swiper trendingProductsSlider_2">
                        <div class="swiper-wrapper">
                            <?php
                            while ($loop->have_posts()) :
                                $loop->the_post();
                                global $post;
                                $size1 = get_the_terms($post, 'size');
                                $size = $size1[0]->name;
                                //  for ($i=0;$i<20;$i++){
                                if ($size == 'horizontal'):
                            ?>
                                    <div class="swiper-slide">
                                        <div class="card  border-0 card-img">
                                            <?php $photos_query_Horizontal_thumb = get_post_meta($post->ID, 'Horizontal_thumb_data', true);
                                            $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                            $gallery_data = get_post_meta($post->ID, 'gallery_data', true);
                                            $gallery_data_image_url = $gallery_data['image_url'];
                                            $gallery_data_first_image_url = isset($gallery_data_image_url[0]) ? $gallery_data_image_url[0] : '';
                                            $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                            if (count($url_array_Horizontal_thumb)):
                                                foreach ($url_array_Horizontal_thumb as $image_Url):
                                                    $Horizontal_thumb_Detail = get_image_details($image_Url);
                                                    $gallery_data_first_image_Detail = get_image_details($gallery_data_first_image_url);
                                            ?>
                                                    <img src="<?= $image_Url ?>" class="card-img-top img-fluid w-100"
                                                        alt="<?= $Horizontal_thumb_Detail->alt ?>"
                                                        title="<?= $Horizontal_thumb_Detail->title ?>">
                                                    <?php if ($gallery_data_first_image_url): ?>
                                                        <img src="<?= $gallery_data_first_image_url ?>"
                                                            class="card-img-top img-fluid w-100 card-img-hover"
                                                            alt="<?= $gallery_data_first_image_Detail->alt ?>"
                                                            title="<?= $gallery_data_first_image_Detail->title ?>">
                                                    <?php endif; ?>
                                            <?php endforeach;
                                            endif; ?>
                                            <div class="card-body">
                                                <h5 class="h6"><a class="product_name stretched-link"
                                                        href="<?= the_permalink() ?>"><?= the_title() ?></a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                                if ($size == 'vertical'):
                                ?>
                                    <div class="swiper-slide">
                                        <div class="card  border-0 card-img">
                                            <?php $photos_query_Vertical_thumb = get_post_meta($post->ID, 'Vertical_thumb_data', true);
                                            $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                                            $gallery_data = get_post_meta($post->ID, 'gallery_data', true);
                                            $gallery_data_image_url = $gallery_data['image_url'];
                                            $gallery_data_first_image_url = isset($gallery_data_image_url[0]) ? $gallery_data_image_url[0] : '';

                                            $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                                            if (count($url_array_Vertical_thumb)):
                                                foreach ($url_array_Vertical_thumb as $image_Url):
                                                    $Vertical_thumb_Detail = get_image_details($image_Url);
                                                    $gallery_data_first_image_Detail = get_image_details($gallery_data_first_image_url); ?>
                                                    <img src="<?= $image_Url ?>" class="card-img-top img-fluid w-100"
                                                        alt="<?= $Vertical_thumb_Detail->alt ?>"
                                                        title="<?= $Vertical_thumb_Detail->title ?>">
                                                    <?php if ($gallery_data_first_image_url): ?>
                                                        <img src="<?= $gallery_data_first_image_url ?>"
                                                            class="card-img-top img-fluid w-100 card-img-hover"
                                                            alt="<?= $gallery_data_first_image_Detail->alt ?>"
                                                            title="<?= $gallery_data_first_image_Detail->title ?>">
                                                    <?php endif; ?>
                                            <?php endforeach;
                                            endif; ?>
                                            <div class="card-body">
                                                <h5 class="h6"><a class="product_name stretched-link"
                                                        href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                <?php endif;
                                if ($size == 'horizontal and vertical'):
                                ?>
                                    <div class="swiper-slide">
                                        <div class="card  border-0">
                                            <?php $photos_query_Vertical_thumb = get_post_meta($post->ID, 'Vertical_thumb_data', true);
                                            $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                                            $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                                            if (count($url_array_Vertical_thumb)):
                                                foreach ($url_array_Vertical_thumb as $image_Url):
                                                    $Vertical_thumb_Detail = get_image_details($image_Url); ?>
                                                    <img src="<?= $image_Url ?>"
                                                        class="card-img-top img-fluid mr-auto ml-auto w-100"
                                                        alt="<?= $Vertical_thumb_Detail->alt ?>"
                                                        title="<?= $Vertical_thumb_Detail->title ?>">
                                            <?php endforeach;
                                            endif; ?>
                                            <div class="card-body">
                                                <h5 class="h6"><a class="product_name stretched-link"
                                                        href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card  border-0">
                                            <?php $photos_query_Horizontal_thumb = get_post_meta($post->ID, 'Horizontal_thumb_data', true);
                                            $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                            $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                            if (count($url_array_Horizontal_thumb)):
                                                foreach ($url_array_Horizontal_thumb as $image_Url):
                                                    $Horizontal_thumb_Detail = get_image_details($image_Url); ?>
                                                    <img src="<?= $image_Url ?>"
                                                        class="card-img-top img-fluid mr-auto ml-auto w-100"
                                                        alt="<?= $Horizontal_thumb_Detail->alt ?>"
                                                        title="<?= $Horizontal_thumb_Detail->title ?>">
                                            <?php endforeach;
                                            endif; ?>
                                            <div class="card-body">
                                                <h5 class="h6"><a class="product_name stretched-link"
                                                        href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                <?php endif;
                                ?>

                            <?php
                            // } // end for
                            endwhile;
                            wp_reset_query()
                            ?>
                        </div>
                        <div class="sw_pg">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
endif;
?>


<?php
$StoresArray = [];

if (isset($theme_settings['Stores']) && is_array($theme_settings['Stores'])) {
    $StoresArray = $theme_settings['Stores'];
}
$args = array(
    'post_type' => array('story'),
    'orderby' => 'ASC',
    'post__in' => $StoresArray
);

$loop = new WP_Query($args);
if (count($StoresArray) && $loop->have_posts()) : ?>
    <!--Story!-->
    <div class="story container-fluid px-0 mt-5">
        <div class="swiper story_slider">
            <div class="swiper-wrapper">
                <?php
                while ($loop->have_posts()) :
                    $loop->the_post();
                    global $post;
                    $photos_query_StoryGallery = get_post_meta($post->ID, 'gallery_data', true);
                    $photos_array_StoryGallery = (array)($photos_query_StoryGallery);
                    $url_array_StoryGallery = $photos_array_StoryGallery['image_url'];
                    if (count($url_array_StoryGallery)):
                        foreach ($url_array_StoryGallery as $image_Url):
                            $StoryGallery_Detail = get_image_details($image_Url); ?>
                            <div class="swiper-slide">
                                <div class="my-3 story_title ">
                                </div>
                                <div class="story_img">
                                    <a href="<?= get_the_permalink($post->ID) ?>">
                                        <img src="<?= $image_Url ?>" class="img-fluid   w-100"
                                            alt="<?= $StoryGallery_Detail->alt ?>"
                                            title="<?= $StoryGallery_Detail->title ?>">
                                    </a>
                                </div>
                            </div>
                <?php endforeach;
                    endif;
                endwhile;
                wp_reset_query()
                ?>
            </div>
            <div class="sw_pg">
                <div class="swiper-pagination"></div>
            </div>
        </div>


    </div>
<?php
endif;
?>

<?php
//echo do_shortcode('[contact-form-7 id="4d010bc" title="Contact form 1"]');
get_footer();

<?php get_header();
$url_array_Gallery_data = null;
?>
<?php if (function_exists('yoast_breadcrumb')) :
?>
    <div class="container-fluid navbar_dark">
        <?php
        yoast_breadcrumb('<p id="breadcrumbs"  class="navbar_dark breadcrumb-item active pt-2 pb-3">', '</p>');
        ?>
    </div>
<?php
endif; ?>
<?php if (have_posts()) :
    while (have_posts()) :
        the_post();
        setPostViews(get_the_ID());
        global $post; ?>
        <div class="product_info content-container mt-5">
            <div class="row">
                <div class="col-12">
                    <div id="galleryCarousel"
                        class="carousel slide">
                        <div class="carousel-inner ">
                            <?php
                            $photos_query = get_post_meta(get_the_ID(), 'gallery_data', true);
                            $photos_array = (array) $photos_query;
                            $urls = $photos_array['image_url'] ?? [];

                            if (!empty($urls)):
                                foreach ($urls as $index => $url_item):

                                    $file_extension = strtolower(pathinfo($url_item, PATHINFO_EXTENSION));
                                    $active_class = ($index === 0) ? 'active' : '';
                            ?>

                                    <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                        <div class="carousel-item <?= $active_class ?>">
                                            <img
                                                src="<?= esc_url($url_item) ?>"
                                                class="w-100 img-fluid object-fit-cover"
                                                style="aspect-ratio: 3/2;"
                                                alt="gallery image">
                                        </div>

                                    <?php elseif (in_array($file_extension, ['mp4', 'webm', 'ogg'])): ?>
                                        <div class="carousel-item <?= $active_class ?>">
                                            <video class="d-block w-100"
                                                controls>
                                                <source src="<?= esc_url($url_item) ?>"
                                                    type="video/<?= esc_attr($file_extension) ?>">
                                                مرورگر شما از ویدیو پشتیبانی نمی‌کند
                                            </video>
                                        </div>
                                    <?php endif; ?>

                            <?php endforeach;
                            endif; ?>

                        </div>

                        <!-- controls -->
                        <a class="carousel-control-prev" href="#galleryCarousel" role="button" data-slide="prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223" />
                            </svg>
                        </a>

                        <a class="carousel-control-next" href="#galleryCarousel" role="button" data-slide="next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-12 pb-4">
                    <div class="sticky-top">
                        <div class="row pt-3 justify-content-between">
                            <div class="col-12 col-md-6">
                                <h1 class="h2"><?php the_title(); ?></h1>
                                <div class="text-justify ">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <a id="WishListCollectionLink" class="<?= $InWishList === true ? '' : 'd-none' ?> ml-2"
                                    style="font-size: .8rem; color: #969696" href="<?= site_url('/') ?>wish-list">(View
                                    Your Collection)</a>
                                <div class="productAction">
                                    <button style="background-color: #000;color:white;" class="btn btn_outline_pf  w-100 mt-4 text-sm" data-toggle="modal"
                                        data-target="#ask_seller_modal">REQUEST A QUOTE
                                    </button>
                                    <button style="background-color: #000;color:white;" class="btn btn_outline_pf  w-100 mt-3 text-sm" data-toggle="modal"
                                        data-target="#ask_seller_modal_custom">REQUEST CUSTOMIZATION
                                    </button>
                                    <!-- Modal -->

                                    <div class="modal fade " id="ask_seller_modal_custom" tabindex="-1" data-backdrop="false"
                                        aria-labelledby="ask_seller_modal_custom" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ask_seller_modal_custom_Label">Request Customization</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body mt-3">
                                                    <?php echo do_shortcode('[forminator_form id="7941"]'); ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade " id="ask_seller_modal" tabindex="-1" data-backdrop="false"
                                        aria-labelledby="ask_seller_modal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Request a Quote</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body mt-3">
                                                    <?php echo do_shortcode('[forminator_form id="7940"]'); ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 w-100 text-center font-weight-bold" style="font-size: 12px;" id="addToWishListSection"
                                    data-post="<?= $post->ID ?>">
                                    <?php
                                    $InWishList = false;
                                    if (isset($_COOKIE['myWishList']) && in_array($post->ID, json_decode(html_entity_decode(stripslashes($_COOKIE['myWishList']))))) {
                                        $InWishList = true;
                                    } ?>
                                    <div style="text-decoration: underline;" id="inWishList" class="<?= $InWishList === true ? '' : 'd-none' ?>">
                                        REMOVE FROM WISH LIST
                                    </div>

                                    <div style="text-decoration: underline;" id="notInWishList" class="<?= $InWishList === true ? 'd-none' : '' ?> text-decoration-underline">
                                        ADD TO WISH LIST
                                    </div>
                                </div>
                                <div class="accordion single-product-accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-block text-left" style="background-color: white;" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <div class="d-flex justify-content-between">
                                                        <span>Collapsible Group Item #1</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                                        </svg>
                                                    </div>

                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                Some placeholder content for the first accordion panel. This panel is shown by default, thanks to the <code>.show</code> class.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <h2 class="h5">THE MATERIALS & FINISHES</h2>
                    <div class="row">
                        <?php
                        $photos_query = get_post_meta(get_the_ID(), 'gallery_data', true);
                        $photos_array = (array) $photos_query;
                        $urls = array_slice($photos_array['image_url'], 0, 3)  ?? [];

                        if (!empty($urls)):
                            foreach ($urls as $index => $url_item):

                                $file_extension = strtolower(pathinfo($url_item, PATHINFO_EXTENSION));
                                $active_class = ($index === 0) ? 'active' : '';
                        ?>

                                <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <div class="col-4 ">
                                        <a href="<?= esc_url($url_item) ?>">
                                            <img
                                                src="<?= esc_url($url_item) ?>"
                                                class="w-100 img-fluid object-fit-cover"
                                                style="aspect-ratio: 3/2;"
                                                alt="gallery image">
                                        </a>
                                    </div>
                                <?php elseif (in_array($file_extension, ['mp4', 'webm', 'ogg'])): ?>
                                <?php endif; ?>
                        <?php endforeach;
                        endif;
                        ?>
                        <div class="col-12 mt-4">
                            <img
                                src="<?= esc_url($urls[0]) ?>"
                                class="w-100 img-fluid object-fit-cover"
                                style="aspect-ratio: 3/2;"
                                alt="gallery image">
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php
        $Family = get_post_meta($post->ID, 'family', true);

        if (!empty($Family)) {
        ?>
            <div class="content-container mt-5 family_box">
                <div class="row archive">
                    <div class="col-12">
                        <h5 class="h5">Family</h5>
                    </div>

                    <?php
                    foreach ($Family as $FamilyItem):
                        $familyPost = get_post($FamilyItem);
                        $size1 = get_the_terms($familyPost, 'size');
                        $size = $size1[0]->slug;
                        if ($size == 'horizontal'):
                    ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Horizontal_thumb = get_post_meta($FamilyItem, 'Horizontal_thumb_data', true);
                                    $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                    $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                    if (count($url_array_Horizontal_thumb)):
                                        foreach ($url_array_Horizontal_thumb as $image_Url):
                                            $Horizontal_thumb_Detail = get_image_details($image_Url); ?>
                                            <img src="<?= $image_Url ?>"
                                                class="card-img-top img-fluid mr-auto ml-auto w-75"
                                                alt="<?= $Horizontal_thumb_Detail->alt ?>"
                                                title="<?= $Horizontal_thumb_Detail->title ?>">
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        <?php endif;
                        if ($size == 'vertical'):
                        ?>
                            <div class="col-6 col-md-4">
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Vertical_thumb = get_post_meta($FamilyItem, 'Vertical_thumb_data', true);
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
                                </div>

                            </div>
                        <?php endif;
                        if ($size == 'horizontal-and-vertical'):
                        ?>
                            <div class="mt-4 col-12 col-md-4">
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Vertical_thumb = get_post_meta($FamilyItem, 'Vertical_thumb_data', true);
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
                                                href="<?= get_permalink($familyPost) ?>"><?= $familyPost->post_title ?></a>
                                        </h5>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-4 col-12 col-md-4">
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Horizontal_thumb = get_post_meta($FamilyItem, 'Horizontal_thumb_data', true);
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
                                                href="<?= get_permalink($familyPost) ?>"><?= $familyPost->post_title ?></a>
                                        </h5>
                                    </div>
                                </div>

                            </div>
                    <?php endif;
                    endforeach;
                    ?>

                </div>
            </div>
<?php
        }

    endwhile;
endif;

get_footer();

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
        <div class="product_info container-fluid mt-5">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php
                    $photos_query = get_post_meta($post->ID, 'gallery_data', true);
                    $photos_array = (array)$photos_query;
                    $url_array_Gallery_data = $photos_array['image_url'] ?? null;

                    if ($url_array_Gallery_data):
                        foreach ($url_array_Gallery_data as $key => $url_item):
                            $galleryImagDetail = get_image_details($url_item);
                            $file_extension = pathinfo($url_item, PATHINFO_EXTENSION);

                            if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                <a data-fancybox="gallery" href="<?= esc_url($url_item) ?>" data-caption=" ">
                                    <img loading="lazy" class="img-fluid mb-3"
                                         src="<?= esc_url($url_item) ?>">
                                </a>
                            <?php elseif (in_array($file_extension, ['mp4', 'webm', 'ogg'])): ?>
                            <div class="video-wrapper">
                                    <video loading="lazy" class="video-fluid mb-3">
                                        <source src="<?= esc_url($url_item) ?>"
                                                type="video/<?= esc_attr($file_extension) ?>">
                                        <?= esc_html__('Your browser does not support the video tag.', 'your-text-domain') ?>
                                    </video>
                                <a data-fancybox="gallery" href="<?= esc_url($url_item) ?>" class="video-link"></a>
                                </div>
                            <?php endif;
                        endforeach;
                    endif;
                    ?>

                </div>
                <div class="info_tabs col-12 col-md-6 pb-4">
                    <div class="sticky-top">
                        <h1 class="pt-3"><?php the_title(); ?></h1>
                        <nav>
                            <div class="nav nav-tabs border-0 mt-4" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="overview_tab" data-toggle="tab" href="#nav_overview"
                                   role="tab" aria-controls="nav_overview" aria-selected="true">Overview</a>
                                <a class="nav-link" id="detail_tab" data-toggle="tab" href="#nav_detail" role="tab"
                                   aria-controls="nav_detail" aria-selected="false">Detail</a>
                                <a class="nav-link" id="material_tab" data-toggle="tab" href="#nav_material" role="tab"
                                   aria-controls="nav_material" aria-selected="false">Material</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="pan_info pb-3 tab-pane fade show active" id="nav_overview" role="tabpanel"
                                 aria-labelledby="overview_tab">
                                <div class="text-justify ">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            <div class=" tab-pane fade" id="nav_detail" role="tabpanel"
                                 aria-labelledby="nav-profile-tab">
                                <div class="pan_info pb-3">
                                    <?= nl2br(get_post_meta($post->ID, 'details', true)); ?>
                                </div>
                            </div>
                            <div class=" tab-pane fade" id="nav_material" role="tabpanel"
                                 aria-labelledby="nav-materials-tab">
                                <div class="pan_info pb-5">
                                    <?php
                                    $theme_settings = get_option('mainThemeSettingPage');
                                    $fancyCounter = 0;
                                    if (isset($theme_settings['ProductComponents']) && is_array($theme_settings['ProductComponents'])):
                                        foreach ($theme_settings['ProductComponents'] as $p_component):
                                            $fancyCounter++;
                                            $photos_query_Wood_data = (array)get_post_meta($post->ID, $p_component . '_data', true);
                                            if (isset($photos_query_Wood_data['image_url']) && count($photos_query_Wood_data['image_url'])):
                                                $url_array_Wood_data = $photos_query_Wood_data['image_url'];
                                                ?>
                                                <div class="mt-3">
                                                    <div class="section_title ">
                                                        <h3 class="h5 font-weight-light"><?= $p_component ?></h3>
                                                    </div>
                                                    <div class="swiper gallery_slider pb-4">
                                                        <div class="swiper-wrapper">
                                                            <?php
                                                            foreach ($url_array_Wood_data as $key2 => $url_item):
                                                                $metalDetail = get_image_details($url_item) ?>

                                                                <div class="swiper-slide">
                                                                    <div data-slide="<?= $key2 ?>">
                                                                        <a style="max-width: 200px"
                                                                           data-fancybox="galleryIdea<?= $fancyCounter ?>"
                                                                           href="<?= $url_item ?>"
                                                                           data-caption="<?php echo $metalDetail->alt; ?>">
                                                                            <img loading="lazy" class="img-fluid"
                                                                                 src="<?= $url_item ?>"
                                                                                 alt="<?= $metalDetail->alt ?>"
                                                                                 title="<?= $metalDetail->title ?>">
                                                                            <span><?php echo $metalDetail->title; ?></span></a>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="swiper-pagination"></div>
                                                    </div>
                                                </div>


                                            <?php
                                            endif;
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="productButtonWrapper btn_box d-flex justify-content-between justify-content-md-start">
                            <div class="d-flex align-items-center productButtonFirst">
                                <div class="productButton btn btn-sm d-flex align-items-center" id="addToWishListSection"
                                     data-post="<?= $post->ID ?>">
                                    <?php
                                    $InWishList = false;
                                    if (isset($_COOKIE['myWishList']) && in_array($post->ID, json_decode(html_entity_decode(stripslashes($_COOKIE['myWishList']))))) {
                                        $InWishList = true;
                                    } ?>
                                    <div id="inWishList" class="<?= $InWishList === true ? '' : 'd-none' ?>">
                                        <img src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/WishList_Remove.svg"
                                             width="40" alt="Remove TO WISH LIST">
                                        REMOVE FROM WISH LIST
                                    </div>

                                    <div id="notInWishList" class="<?= $InWishList === true ? 'd-none' : '' ?>">
                                        <img src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/WishList_Add.svg"
                                             width="40" alt="ADD TO WISH LIST">
                                        ADD TO WISH LIST
                                    </div>
                                </div>

                            </div>
                            <?php $Spec_link = get_post_meta($post->ID, 'Spec_link', true);
                            if ($Spec_link != null): ?>
                                <a href="<?= $Spec_link ?>" download
                                   class="productButton btn dimension d-flex align-items-center btn"
                                   target="_blank"
								   style="display: none !important;">
                                    <img class="mr-1"
                                         src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/Spec.svg"
                                         width="20" alt="SPEC">
                                    SPECH SHEET
                                </a>

                            <?php endif; ?>
                        </div>
                        <a id="WishListCollectionLink" class="<?= $InWishList === true ? '' : 'd-none' ?> ml-2"
                           style="font-size: .8rem; color: #969696" href="<?= site_url('/') ?>wish-list">(View
                            Your Collection)</a>
                        <div class="productAction">
                            <button class="btn btn_outline_pf  w-100 mt-4 text-sm" data-toggle="modal"
                                    data-target="#ask_seller_modal">REQUEST A QUOTE
                            </button>
                            <button class="btn btn_outline_pf  w-100 mt-3 text-sm" data-toggle="modal"
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
                    </div>
                </div>
            </div>
        </div>


        <?php
//           $terms = wp_get_post_terms( $post->ID, 'product_cat');
//           echo '<ul>';
//           foreach ($terms as $term) {
//               echo '<li><a href="'.get_term_link($term->slug, 'product_cat').'">'.$term->name.'</a></li>';
//           }
//           echo '</ul>';

        $Family = get_post_meta($post->ID, 'family', true);
//           $Family = (array) $Family;
//           var_dump($Family);

        if (!empty($Family)) {
            ?>
            <div class="container-fluid mt-5 family_box">
                <div class="row archive">
                    <div class="col-12"><h5>Family</h5></div>

                    <?php
                    foreach ($Family as $FamilyItem):
                        $familyPost = get_post($FamilyItem);
                        $size1 = get_the_terms($familyPost, 'size');
                        $size = $size1[0]->slug;
                        if ($size == 'horizontal'):
                            ?>
                            <div class="mt-4 col-6 col-md-4 col-lg-3">
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
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name stretched-link"
                                                          href="<?= get_permalink($familyPost) ?>"><?= $familyPost->post_title ?></a>
                                        </h5>
                                    </div>
                                </div>

                            </div>
                        <?php endif;
                        if ($size == 'vertical'):
                            ?>
                            <div class="mt-4 col-6 col-md-4 col-lg-3">
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
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name stretched-link"
                                                          href="<?= get_permalink($familyPost) ?>"><?= $familyPost->post_title ?></a>
                                        </h5>
                                    </div>
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
                                        <?php endforeach; endif; ?>
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
                                        <?php endforeach; endif; ?>
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



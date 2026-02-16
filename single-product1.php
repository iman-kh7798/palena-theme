<?php get_header();
$url_array_Gallery_data=null;
?>
<?php if (function_exists('yoast_breadcrumb')) :
   ?>
<div class="container-fluid navbar_dark">
    <?php
    yoast_breadcrumb('<p id="breadcrumbs"  class="container navbar_dark breadcrumb-item active pt-2 pb-2">', '</p>');
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
                    $photos_query = get_post_meta( $post->ID, 'gallery_data', true );
                    $photos_array = (array)($photos_query);
                    $url_array_Gallery_data = $photos_array['image_url'] ?? null;
                    if ($url_array_Gallery_data):
                        foreach ($url_array_Gallery_data as $key=>$url_item):
                            $galleryImagDetail= get_image_details($url_item); ?>

                            <a data-fancybox="gallery" href="<?= $url_item ?>"><img loading="lazy"  class="img-fluid mb-3" src="<?= $url_item ?>" alt="<?=$galleryImagDetail->alt?>" title="<?=$galleryImagDetail->title?>"></a>

                        <?php  endforeach; endif;?>

                </div>
                <div class=" info_tabs col-12 col-md-6 ">
                    <div class="sticky-top">
                        <h1><?php the_title(); ?></h1>
                        <nav>
                            <div class="nav nav-tabs border-0 mt-4" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="overview_tab" data-toggle="tab" href="#nav_overview" role="tab" aria-controls="nav_overview" aria-selected="true">Overview</a>
                                <a class="nav-link" id="detail_tab" data-toggle="tab" href="#nav_detail" role="tab" aria-controls="nav_detail" aria-selected="false">Detail</a>
                                <a class="nav-link" id="material_tab" data-toggle="tab" href="#nav_material" role="tab" aria-controls="nav_material" aria-selected="false">Material</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="pan_info  tab-pane fade show active" id="nav_overview" role="tabpanel" aria-labelledby="overview_tab">
                                <div class="text-justify ">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            <div class=" tab-pane fade" id="nav_detail" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="pan_info ">
                                    <?= nl2br(get_post_meta($post->ID, 'details', true));  ?>
                                </div>
                            </div>
                            <div class=" tab-pane fade" id="nav_material" role="tabpanel" aria-labelledby="nav-materials-tab">
                                <div class="pan_info ">
                                    <?php
                                    $theme_settings = get_option( 'mainThemeSettingPage' );
                                    $fancyCounter=0;
                                    if (isset($theme_settings['ProductComponents']) && is_array($theme_settings['ProductComponents'])):
                                        foreach ($theme_settings['ProductComponents'] as $p_component):
                                            $fancyCounter++;
                                            $photos_query_Wood_data = (array)get_post_meta( $post->ID, $p_component.'_data', true );
                                            if (isset($photos_query_Wood_data['image_url']) && count($photos_query_Wood_data['image_url'])):
                                                $url_array_Wood_data = $photos_query_Wood_data['image_url'];
                                                ?>
                                                <div class="container-fluid mt-5 ">
                                                    <div class="my-3 section_title ">
                                                        <h3 class="h5 font-weight-light"><?=$p_component?></h3>
                                                    </div>
                                                    <div class="swiper gallery_slider px-3 pb-4">
                                                        <div class="swiper-wrapper">
                                                            <?php
                                                            foreach ($url_array_Wood_data as $key2=>$url_item):
                                                                $metalDetail=get_image_details($url_item)?>

                                                                <div class="swiper-slide">
                                                                    <div  data-slide="<?=$key2?>">
                                                                        <a style="max-width: 200px" data-fancybox="galleryIdea<?=$fancyCounter?>" href="<?= $url_item ?>" data-caption="<?=nl2br($metalDetail->description)?>"> <img loading="lazy" class="img-fluid" src="<?= $url_item ?>" alt="<?=$metalDetail->alt?>" title="<?=$metalDetail->title?>"></a>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach;?>
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

                        <div class="btn_box d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="btn btn-sm pa_btn_light d-flex align-items-center" id="addToWishListSection" data-post="<?=$post->ID?>">
                                    <?php
                                    $InWishList=false;
                                    if (isset($_COOKIE['myWishList']) && in_array($post->ID,json_decode( html_entity_decode( stripslashes ($_COOKIE['myWishList'] ) ) ))) {
                                        $InWishList=true;
                                    }?>
                                    <div id="inWishList" class="<?= $InWishList===true ? '' : 'd-none' ?>">
                                        <img src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/remove_from_wish_list.svg" width="40" alt="Remove TO WISH LIST">
                                        REMOVE FROM WISH LIST
                                    </div>

                                    <div id="notInWishList" class="<?= $InWishList===true ? 'd-none' : '' ?>">
                                        <img src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/bag.png" width="40" alt="ADD TO WISH LIST">
                                        ADD TO WISH LIST
                                    </div>
                                </div>
                                <a id="WishListCollectionLink" class="<?= $InWishList===true ? '' : 'd-none' ?> ml-2" style="font-size: .8rem; color: #969696" href="<?=site_url('/')?>wish-list">(View Your Collection)</a>
                            </div>
                            <?php $Spec_link = get_post_meta($post->ID, 'Spec_link', true);
                            if ($Spec_link != null ): ?>
                                <a href="<?=$Spec_link?>" download class="btn dimension d-flex align-items-center btn pa_btn_light px-5" target="_blank">
                                    <img class="mr-1" src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/spec2.png" width="20" alt="SPEC">
                                    SPEC
                                </a>

                            <?php endif; ?>


<!--                            <button class="btn pa_btn_light px-5 dimension " data-toggle="modal" data-target="#Dimension">Dimension</button>-->
<!--                            <div class="modal fade" id="Dimension" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="DimensionLabel" aria-hidden="true">-->
<!--                                <div class=" modal-dialog modal-dialog-centered">-->
<!--                                    <div class="modal-content">-->
<!--                                        <div class="modal-header">-->
<!--                                            <h5 class="modal-title" id="staticBackdropLabel">Dimension For --><?php //the_title(); ?><!--</h5>-->
<!--                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                                                <span aria-hidden="true">&times;</span>-->
<!--                                            </button>-->
<!--                                        </div>-->
<!--                                        <div class="modal-body">-->
<!--                                            --><?php
//                                            $photos_query = get_post_meta( $post->ID, 'Dimension_data', true );
//                                            $photos_array = (array)($photos_query);
//                                            $url_array = $photos_array['image_url'];
//                                            foreach ($url_array as $url_item):
//                                                $DimensionDetail= get_image_details($url_item);?>
<!--                                                <img loading="lazy" class="img-fluid" src="--><?//= $url_item ?><!--" alt="--><?//=$DimensionDetail->alt?><!--" title="--><?//=$DimensionDetail->title?><!--">-->
<!--                                            --><?php //endforeach;?>
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                        <div >
                            <button class="btn btn_outline_pf  w-100 mt-4 text-sm" data-toggle="modal" data-target="#ask_seller_modal">REQUEST A QUOTE</button>
                            <button class="btn btn_outline_pf  w-100 mt-4 text-sm" data-toggle="modal" data-target="#ask_seller_modal_custom">REQUEST CUSTOMIZATION</button>
                            <!-- Modal -->

                            <div class="modal fade " id="ask_seller_modal_custom" tabindex="-1" data-backdrop="false" aria-labelledby="ask_seller_modal_custom" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ask_seller_modal_custom_Label">Seller Form</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            idea_csrf_create();
                                            askTheSellerScripts();
                                            askTheSellerScripts_custom();
                                            ?>
                                            <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="POST" onsubmit="return false;" id="AskTheSellerForm_custom">
                                                <?=ideaCsrfField2() ?>
                                                <input type="hidden" name="action" value="ask_the_seller_final_form_custom">

                                                <input type="hidden" name="product" value="<?=$post->ID?>">
                                                <input type="hidden" name="postTitle" value="<?php the_title(); ?>">
                                                <input type="hidden" name="postLink" value="<?= get_the_permalink($post->ID); ?>">
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="name_custom">Name</label><small class="text-danger ml-1">*</small>
                                                    <input type="text" required autocomplete="off" class="form-control form-control-sm" id="name_custom" name="name" aria-describedby="name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="phone_custom">Phone</label><small class="text-danger ml-1">*</small>
                                                    <input type="text" required autocomplete="off" class="form-control form-control-sm" id="phone_custom" name="phone" aria-describedby="phone">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="email_custom">Email</label><small class="text-danger ml-1">*</small>
                                                    <input type="email" required autocomplete="off" class="form-control form-control-sm" id="email_custom" name="email" aria-describedby="email">
                                                </div>


                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" autocomplete="off" class="custom-control-input" id="dimensions_input_custom" name="dimensions_input" data-toggle='collapse'  data-target='#dimensions_custom'>
                                                        <label class="custom-control-label" for="dimensions_input_custom">Dimensions</label>
                                                    </div>
                                                </div>
                                                <div class="collapse mb-2" id="dimensions_custom">
                                                    <div class="form-group">
                                                        <label class="col-form-label-sm" for="length_custom">Length / Depth</label>
                                                        <input type="text" autocomplete="off" class="form-control form-control-sm" id="length_custom" name="length" aria-describedby="length">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label-sm" for="width_custom">Width</label>
                                                        <input type="text" autocomplete="off" class="form-control form-control-sm" id="width_custom" name="width" aria-describedby="width">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label-sm" for="height_custom">Height</label>
                                                        <input type="text" autocomplete="off" class="form-control form-control-sm" id="height_custom" name="height" aria-describedby="height">
                                                        <small id="dimHelp" class="form-text text-muted">*Dims are in inch</small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="user_message_custom">Materials</label>
                                                    <small id="materialHelp" class="form-text text-muted">Please write us about your material customization</small>
                                                    <textarea class="form-control form-control-sm" autocomplete="off" id="user_message_custom" name="user_message" rows="3"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn_outline_pf" id="submitAskTheSellerForm_custom">Send Message</button>
                                                    <button type="button" class="btn btn-sm btn_outline_pf" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade " id="ask_seller_modal" tabindex="-1" data-backdrop="false" aria-labelledby="ask_seller_modal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Seller Form</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            idea_csrf_create();
                                            askTheSellerScripts();
                                            ?>
                                            <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="POST" onsubmit="return false;" id="AskTheSellerForm">
                                                <?=ideaCsrfField() ?>
                                                <input type="hidden" name="action" value="ask_the_seller_final_form">

                                                <input type="hidden" name="product" value="<?=$post->ID?>">
                                                <input type="hidden" name="postTitle" value="<?php the_title(); ?>">
                                                <input type="hidden" name="postLink" value="<?= get_the_permalink($post->ID); ?>">
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="name">Name</label><small class="text-danger ml-1">*</small>
                                                    <input type="text" required autocomplete="off" class="form-control form-control-sm" id="name" name="name" aria-describedby="name">
                                                </div>
<!--                                                <div class="form-group">-->
<!--                                                    <label class="col-form-label-sm" for="family">Family</label><small class="text-danger ml-1">*</small>-->
<!--                                                    <input type="text" required autocomplete="off" class="form-control form-control-sm" id="family" name="family" aria-describedby="family">-->
<!--                                                </div>-->
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="phone">Phone</label><small class="text-danger ml-1">*</small>
                                                    <input type="text" required autocomplete="off" class="form-control form-control-sm" id="phone" name="phone" aria-describedby="phone">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="email">Email</label><small class="text-danger ml-1">*</small>
                                                    <input type="email" required autocomplete="off" class="form-control form-control-sm" id="email" name="email" aria-describedby="email">
                                                </div>
                                                <?php
                                                $size='';
                                                $sizes=(array)wp_get_post_terms( $post->ID, 'size');
                                                if (isset($sizes[0]) && isset($sizes[0]->slug)){
                                                    $size=$sizes[0]->slug;
                                                    if ($size == 'horizontal-and-vertical'){
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-form-label-sm" for="user_message">Size</label>
                                                            <select name="size" id="size" class="form-control form-control-sm">
                                                                <option value="Horizontal">Horizontal</option>
                                                                <option value="Vertical">Vertical</option>
                                                            </select>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-form-label-sm" for="user_message">Your Message</label>
                                                    <textarea class="form-control form-control-sm" autocomplete="off" id="user_message" name="user_message" rows="3"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" autocomplete="off" class="custom-control-input" id="designer_input" name="designer_input" data-toggle='collapse'  data-target='#designer'>
                                                        <label class="custom-control-label" for="designer_input">I'm a Designer</label>
                                                    </div>
                                                </div>
                                                <div class="collapse mb-2" id="designer">
                                                    <div class="form-group">
                                                        <label class="col-form-label-sm" for="Company">Company</label>
                                                        <input type="text" autocomplete="off" class="form-control form-control-sm" id="Company" name="Company" aria-describedby="name">
                                                    </div>
<!--                                                    <div class="form-group">-->
<!--                                                        <label class="col-form-label-sm" for="Resale">Resale / TaxID</label>-->
<!--                                                        <input type="text" autocomplete="off" class="form-control form-control-sm" id="Resale" name="Resale" aria-describedby="Resale">-->
<!--                                                    </div>-->
                                                    <div class="form-group">
                                                        <label class="col-form-label-sm" for="address">City / State / Country</label>
                                                        <input type="text" autocomplete="off" class="form-control form-control-sm" id="address" name="address" aria-describedby="country">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn_outline_pf" id="submitAskTheSellerForm">Send Message</button>
                                                    <button type="button" class="btn btn-sm btn_outline_pf" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
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

        if (!empty($Family)){
            ?>
            <div class="container-fluid mt-5 family_box">
                <div class="row">
                    <div class="col-12"><h5>Family</h5></div>

                    <?php
                    foreach ($Family as $FamilyItem):
                        $familyPost=get_post($FamilyItem);
                        $size1=get_the_terms( $familyPost, 'size' );
                        $size=$size1[0]->slug;
                        if ($size == 'horizontal'):
                            ?>
                            <div class="mt-4 col-12 col-md-4" >
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Horizontal_thumb = get_post_meta( $FamilyItem, 'Horizontal_thumb_data', true );
                                    $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                    $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                    if (count($url_array_Horizontal_thumb)):
                                        foreach ($url_array_Horizontal_thumb as $image_Url):
                                            $Horizontal_thumb_Detail=get_image_details($image_Url);?>
                                            <img src="<?=$image_Url?>" class="card-img-top img-fluid mr-auto ml-auto w-75" alt="<?=$Horizontal_thumb_Detail->alt?>" title="<?=$Horizontal_thumb_Detail->title?>">
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name stretched-link" href="<?=get_permalink($familyPost)?>"><?=$familyPost->post_title?></a></h5>
                                    </div>
                                </div>

                            </div>
                        <?php endif;
                        if ($size == 'vertical'):
                            ?>
                            <div class="mt-4 col-12 col-md-4">
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Vertical_thumb = get_post_meta( $FamilyItem, 'Vertical_thumb_data', true );
                                    $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                                    $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                                    if (count($url_array_Vertical_thumb)):
                                        foreach ($url_array_Vertical_thumb as $image_Url):
                                            $Vertical_thumb_Detail=get_image_details($image_Url);?>
                                            <img src="<?=$image_Url?>" class="card-img-top img-fluid mr-auto ml-auto w-100" alt="<?=$Vertical_thumb_Detail->alt?>" title="<?=$Vertical_thumb_Detail->title?>">
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name stretched-link" href="<?=get_permalink($familyPost)?>"><?=$familyPost->post_title?></a></h5>
                                    </div>
                                </div>

                            </div>
                        <?php endif;
                        if ($size == 'horizontal-and-vertical'):
                            ?>
                            <div class="mt-4 col-12 col-md-4">
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Vertical_thumb = get_post_meta( $FamilyItem, 'Vertical_thumb_data', true );
                                    $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                                    $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                                    if (count($url_array_Vertical_thumb)):
                                        foreach ($url_array_Vertical_thumb as $image_Url):
                                            $Vertical_thumb_Detail=get_image_details($image_Url);?>
                                            <img src="<?=$image_Url?>" class="card-img-top img-fluid mr-auto ml-auto w-100" alt="<?=$Vertical_thumb_Detail->alt?>" title="<?=$Vertical_thumb_Detail->title?>">
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name stretched-link" href="<?=get_permalink($familyPost)?>"><?=$familyPost->post_title?></a></h5>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-4 col-12 col-md-4" >
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Horizontal_thumb = get_post_meta( $FamilyItem, 'Horizontal_thumb_data', true );
                                    $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                    $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                    if (count($url_array_Horizontal_thumb)):
                                        foreach ($url_array_Horizontal_thumb as $image_Url):
                                            $Horizontal_thumb_Detail=get_image_details($image_Url);?>
                                            <img src="<?=$image_Url?>" class="card-img-top img-fluid mr-auto ml-auto w-100" alt="<?=$Horizontal_thumb_Detail->alt?>" title="<?=$Horizontal_thumb_Detail->title?>">
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name stretched-link" href="<?=get_permalink($familyPost)?>"><?=$familyPost->post_title?></a></h5>
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



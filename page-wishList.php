<?php /* Template Name:wishList*/ ?>
<?php get_header();
askTheSellerScripts();?>
<div class="container-fluid">
    <h1 class="h5 my-3">My Wish list</h1>
<?php
$hasWishList=false;
if (isset($_COOKIE['myWishList'])) {
    $wishListArray=(array)json_decode( html_entity_decode( stripslashes ($_COOKIE['myWishList'] ) ) );
    $queryArray=[];
    foreach ($wishListArray as $wishListItem){
        $queryArray[]=sanitize_text_field($wishListItem);
    }
    $args = array(
        'post_type' => array( 'product' ),
        'orderby' => 'ASC',
        'post__in' => $queryArray
    );
    $productIds=[];

    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) :?>
        <div class="row">

            <div class="col-12 archive">
                <div class="row">
                    <?php
                    while ( $loop->have_posts() ) :
                        $loop->the_post();
                        global $post;
                        $size1=get_the_terms( $post, 'size' );
                        $size=$size1[0]->name;
                        $productIds[]=$post->ID;
                        ?>

                        <?php
                        if ($size == 'horizontal'):
                            ?>
                            <div class="mt-4 col-12" >
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Horizontal_thumb = get_post_meta( $post->ID, 'Horizontal_thumb_data', true );
                                    $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                    $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                    if (count($url_array_Horizontal_thumb)):
                                        foreach ($url_array_Horizontal_thumb as $image_Url):
                                            $Horizontal_thumb_Detail=get_image_details($image_Url);?>
                                            <img src="<?=$image_Url?>" class="card-img-top img-fluid mr-auto ml-auto w-75" alt="<?=$Horizontal_thumb_Detail->alt?>" title="<?=$Horizontal_thumb_Detail->title?>">
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name text-dark stretched-link" href="<?=get_permalink()?>"><?=get_the_title()?></a></h5>
                                    </div>
                                </div>

                            </div>
                        <?php endif;
                        if ($size == 'vertical'):
                            ?>
                            <div class="mt-4 col-12 col-sm-6 col-md-4">
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Vertical_thumb = get_post_meta( $post->ID, 'Vertical_thumb_data', true );
                                    $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                                    $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                                    if (count($url_array_Vertical_thumb)):
                                        foreach ($url_array_Vertical_thumb as $image_Url):
                                            $Vertical_thumb_Detail=get_image_details($image_Url);?>
                                            <img src="<?=$image_Url?>" class="card-img-top img-fluid mr-auto ml-auto w-100" alt="<?=$Vertical_thumb_Detail->alt?>" title="<?=$Vertical_thumb_Detail->title?>">
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name text-dark stretched-link" href="<?=get_permalink()?>"><?=get_the_title()?></a></h5>
                                    </div>
                                </div>

                            </div>
                        <?php endif;
                        if ($size == 'horizontal and vertical'):
                            ?>
                            <div class="mt-4 col-12 col-sm-6 col-md-4">
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Vertical_thumb = get_post_meta( $post->ID, 'Vertical_thumb_data', true );
                                    $photos_array_Vertical_thumb = (array)($photos_query_Vertical_thumb);
                                    $url_array_Vertical_thumb = $photos_array_Vertical_thumb['image_url'];
                                    if (count($url_array_Vertical_thumb)):
                                        foreach ($url_array_Vertical_thumb as $image_Url):
                                            $Vertical_thumb_Detail=get_image_details($image_Url);?>
                                            <img src="<?=$image_Url?>" class="card-img-top img-fluid mr-auto ml-auto w-100" alt="<?=$Vertical_thumb_Detail->alt?>" title="<?=$Vertical_thumb_Detail->title?>">
                                        <?php endforeach; endif; ?>
                                    <div class="card-body">
                                        <h5 class="h6"><a class="product_name text-dark stretched-link" href="<?=get_permalink()?>"><?=get_the_title()?></a></h5>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-4 col-12 col-sm-6 col-md-8" >
                                <div class="card mb-3 border-0">
                                    <?php $photos_query_Horizontal_thumb = get_post_meta( $post->ID, 'Horizontal_thumb_data', true );
                                    $photos_array_Horizontal_thumb = (array)($photos_query_Horizontal_thumb);
                                    $url_array_Horizontal_thumb = $photos_array_Horizontal_thumb['image_url'];
                                    if (count($url_array_Horizontal_thumb)):
                                        foreach ($url_array_Horizontal_thumb as $image_Url):
                                            $Horizontal_thumb_Detail=get_image_details($image_Url);?>
                                            <img src="<?=$image_Url?>" class="card-img-top img-fluid mr-auto ml-auto w-100" alt="<?=$Horizontal_thumb_Detail->alt?>" title="<?=$Horizontal_thumb_Detail->title?>">
                                        <?php endforeach; endif; ?>
                                </div>

                            </div>
                        <?php endif; ?>



                    <?php endwhile;
                    wp_reset_query();?>
                </div>
            </div>
            <div class="col-12 col-lg-6 mr-auto ml-auto ">
                LIST SUBMIT 
                <br>
                <?php echo do_shortcode('[forminator_form id="9919"]'); ?>
            </div>

        </div>
    <?php
    endif;
}else{
    ?>
        <p class="alert alert-warning">You do not have a product in Wish list yet </p>
        <?php
}
?>
    </div>
<?php get_footer();

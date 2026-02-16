<?php
$theme_settings = get_option( 'mainThemeSettingPage' );
$args = array(
    'taxonomy' => "product_seller",
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false,
);
$product_sellers = (array)get_terms($args);


?>
<div class="wrap">

    <h1>Site Setting</h1>

    <form action="options.php" method="post" enctype="multipart/form-data" id="setNewSettingFromTheme">
		<?php
		settings_fields( 'mainThemeSettingPage' );
		?>
        <table class="wp-list-table widefat fixed striped table-view-list posts">
            <tr>
                <td colspan="4" class="row-title column-primary" style="border-top: 1px solid #0000ff; padding-top: 15px;"> Select Site Logo</td>
                <td colspan="2" class="manage-column" style="border-top: 1px solid #0000ff; padding-top: 15px;">
                    <label>
                        <span style="background: #38bb24; color: white"  id="upload_logo_btn" class="button"><?= isset( $theme_settings['logo_url'] ) && !empty( $theme_settings['logo_url'] ) ? 'Change Logo' : 'Select Logo' ?></span>
                        <input type="hidden" id="image_url" name="mainThemeSettingPage[logo_url]"
                               value="<?php if ( isset( $theme_settings['logo_url'] ) and ! empty( $theme_settings['logo_url'] ) ) {
                                   echo $theme_settings['logo_url'];
                               } ?>">
                    </label>
                </td>
                <td colspan="2" style="border-top: 1px solid #0000ff; padding-top: 15px;">
                    <img id="img_preview" style="max-width: 100%"
                         src="<?php if ( isset( $theme_settings['logo_url'] ) and ! empty( $theme_settings['logo_url'] ) ) {
                             echo $theme_settings['logo_url'];
                         } ?>" alt="">
                </td>
            </tr>

            <tr>
                <td colspan="8" class="row-title column-primary" style="border-top: 1px solid #0000ff; padding-top: 15px;">Sellers email address :</td>

            </tr>

            <?php if (count($product_sellers)):
                foreach ($product_sellers as $product_seller):?>
                    <tr>
                        <td colspan="4" class="manage-column">
                            <span><?=$product_seller->name?></span>
                        </td>
                        <td colspan="4">
                            <input type="text" class="widefat" required name="mainThemeSettingPage[<?=$product_seller->slug?>_email_address]"
                                   value="<?php if ( isset( $theme_settings[$product_seller->slug.'_email_address'] ) and ! empty( $theme_settings[$product_seller->slug.'_email_address'] ) ) {
                                       echo $theme_settings[$product_seller->slug.'_email_address'];
                                   }else{echo get_option('admin_email');} ?>">
                        </td>
                    </tr>
                <?php
                endforeach;
            else:?>
                <tr>
                    <td colspan="8" class="manage-column row-title">
                        <p class="widefat row-title" style="color: red">You have not defined any sellers yet !</p>
                    </td>
                </tr>
            <?php
            endif;
            ?>
            <tr>
                <td colspan="8" class="row-title column-primary" style="border-top: 1px solid #0000ff; padding-top: 15px;">Product components  :</td>

            </tr>
            <tr>
                <td colspan="8" class="" id="AddNewProductComponentSection">

                    <?php
                    if (isset($theme_settings['ProductComponents']) && is_array($theme_settings['ProductComponents'])):
                        foreach ($theme_settings['ProductComponents'] as $p_component):
                            ?>
                    <div style="margin: 10px;">
                        <span style="color: red; margin-right: 5px; cursor: pointer" title="delete" onclick="this.parentElement.remove()">x</span>
                        <input type="text" name="mainThemeSettingPage[ProductComponents][]"
                               value="<?=str_replace(' ','_',$p_component)?>">
                    </div>
                        <?php
                        endforeach;
                    endif;
                    ?>

                </td>

            </tr>
            <tr>
                <td colspan="8"><span id="AddNewProductComponent"  class="button" style="background: #38bb24; color: white">Add New Product Component</span></td>

            </tr>
            <tr>
                <td colspan="8" class="row-title column-primary" style="border-top: 1px solid #0000ff; padding-top: 15px;">Trending Products  :</td>

            </tr>
            <tr>
                <td colspan="4" class="" style=" padding-top: 15px;border: 1px solid #ccc">
                    <p>Box 1</p>
                    <input type="text" id="searchProductBox1" class="searchBox1 widefat" placeholder="search product title">
                    <?php
                    $TrendingProductsArray=[];
                    if (isset($theme_settings['TrendingProducts']) && is_array($theme_settings['TrendingProducts'])){
                        $TrendingProductsArray=$theme_settings['TrendingProducts'];
                    }
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                    );
                    $query_products = new WP_Query($args);

                    if ($query_products->have_posts()):
                        ?>

                    <div class="" style="width: 100%; height: 400px;overflow-y: auto">
                        <?php
                        while ($query_products->have_posts()):
                            $query_products->the_post();
                            global $post;
                            $p_title1=get_the_title();
                            ?>
                            <fieldset style="margin: 10px;" class="box1Items" data-title_org="<?=$p_title1?>" data-title="<?=strtolower($p_title1)?>"><label >
                                    <input name="mainThemeSettingPage[TrendingProducts][]" type="checkbox" <?=in_array($post->ID,$TrendingProductsArray) ? ' checked ' : ''?>  value="<?=$post->ID?>">
                                    <?=$p_title1?></label>
                            </fieldset>

                        <?php endwhile; ?>
                        <?php
                        wp_reset_postdata();
                        else:?>
                            <p class="widefat row-title" style="color: red">You have`t any Product yet !</p>
                        <?php
                        endif;
                        ?>
                    </div>

                </td>
                <td colspan="4" class="" style=" padding-top: 15px;border: 1px solid #ccc">
                    <p>Box 2</p>
                    <input type="text" id="searchProductBox2" class="searchBox2 widefat" placeholder="search product title">
                    <?php
                    $TrendingProducts2Array2=[];
                    if (isset($theme_settings['TrendingProducts2']) && is_array($theme_settings['TrendingProducts2'])){
                        $TrendingProducts2Array2=$theme_settings['TrendingProducts2'];
                    }
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                    );
                    $query_products2 = new WP_Query($args);
                    ?>
                    <div class="" style="width: 100%; height: 400px;overflow-y: auto">
                        <?php
                        if ($query_products2->have_posts()):
                            while ($query_products2->have_posts()):
                                $query_products2->the_post();
                                global $post;
                                $p_title2=get_the_title(); ?>
                                <fieldset style="margin: 10px;" class="box2Items" data-title_org="<?=$p_title2?>" data-title="<?=strtolower($p_title2)?>"><label >
                                        <input name="mainThemeSettingPage[TrendingProducts2][]" type="checkbox" <?=in_array($post->ID,$TrendingProducts2Array2) ? ' checked ' : ''?>  value="<?=$post->ID?>">
                                        <?=$p_title2?></label>
                                </fieldset>

                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else:?>
                            <p class="widefat row-title" style="color: red">You have`t any Product yet !</p>
                        <?php
                        endif;
                        ?>
                    </div>

                </td>

            </tr>
            <tr>
                <td colspan="8" class="row-title column-primary" style="border-top: 1px solid #0000ff; padding-top: 15px;">Stores  :</td>

            </tr>
            <tr>
                <td colspan="8" class="" style=" padding-top: 15px;">
                    <?php
                    $StoresArray=[];
                    if (isset($theme_settings['Stores']) && is_array($theme_settings['Stores'])){
                        $StoresArray=$theme_settings['Stores'];
                    }
                    $args = array(
                        'post_type' => 'story',
                        'posts_per_page' => -1,
                    );
                    $query_Stores = new WP_Query($args);
                    if ($query_Stores->have_posts()):
                        while ($query_Stores->have_posts()):
                            $query_Stores->the_post();
                            global $post;?>
                            <fieldset style="margin: 10px;"><label >
                                    <input name="mainThemeSettingPage[Stores][]" type="checkbox" <?=in_array($post->ID,$StoresArray) ? ' checked ' : ''?>  value="<?=$post->ID?>">
                                    <?=the_title()?></label>
                            </fieldset>

                    <?php
                       endwhile;
                        wp_reset_postdata();
                    else:?>
                        <p class="widefat row-title" style="color: red">You have`t any Story yet !</p>
                    <?php
                        endif;
                    ?>
                </td>

            </tr>


        </table>

        <p class="submit">
            <button type="submit" class="button-primary">Save Settings</button>
        </p>
    </form>
</div>


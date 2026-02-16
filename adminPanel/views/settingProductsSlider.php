<?php
$slider_link = get_post_meta($post->ID, 'slider_link', true);
// $slider_description = get_post_meta($post->ID, 'slider_description', true);
$slider_img = get_post_meta($post->ID, 'slider_img', true);
$slider_img_mobile_slider = get_post_meta($post->ID, 'slider_img_mobile_slider', true);
wp_nonce_field('slider_meta_box_nonce', 'meta_box_nonce');
?>
<table class="form-table">

    <tr>
        <th class="row-title">slide link : </th>
        <td>
            <fieldset>
                <input type="text" class="widefat" name="slider_link"
                       value="<?php echo !empty($slider_link) ? $slider_link : null; ?>"
                >
            </fieldset>
        </td>
    </tr>
    <tr>
        <th class="row-title">select image for Tablet and Desktop devices</th>
        <td>
            <fieldset>
                <label>
                    <button type="button" id="upload_img_btn" class="btn-primary">select Image </button>
                    <input type="text" id="image_url" name="slider_img"
                           value="<?php echo !empty($slider_img) ? $slider_img : ''; ?>">
                </label>
            </fieldset>
            <fieldset>
                <img id="img_preview" style="max-width: 300px"
                     src="<?php if ( isset( $slider_img ) and ! empty( $slider_img ) ) {
                         echo $slider_img;
                     } ?>" alt="">
            </fieldset>
        </td>
    </tr>
    <tr>
        <th class="row-title">select image for Mobile devices </th>
        <td>
            <fieldset>
                <label>
                    <button type="button" id="upload_img_btn_mobile_slider" class="btn-primary">select Image </button>
                    <input type="text" id="image_url_mobile_slider" name="slider_img_mobile_slider"
                           value="<?php echo !empty($slider_img_mobile_slider) ? $slider_img_mobile_slider : ''; ?>">
                </label>
            </fieldset>
            <fieldset>
                <img id="img_preview_mobile_slider" style="max-width: 300px"
                     src="<?php if ( isset( $slider_img_mobile_slider ) and ! empty( $slider_img_mobile_slider ) ) {
                         echo $slider_img_mobile_slider;
                     } ?>" alt="">
            </fieldset>
        </td>
    </tr>

</table>

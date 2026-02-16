<?php


/* Image thumbnail for category */

/* If this CPT, use scripts and styles to display Media Library popup */
function media_uploader_product_cat() {
    global $post_type;
    if( 'product' == $post_type) {
        if(function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }
        else {
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }
    }
}
add_action('admin_enqueue_scripts', 'media_uploader_product_cat');

/*show the form field*/

add_action( 'product_cat_add_form_fields', 'add_image_field', 10, 2 );
add_action( 'product_cat_edit_form_fields', 'add_image_field', 10, 2 );
function add_image_field($taxonomy) {
    if(is_object($taxonomy)) // edit term not add term
        $selectedimgid = get_term_meta( $taxonomy->term_id, 'product_cat_thumbnail_id', true );

    ?>
    <div class="form-field term-thumbnail-wrap">
        <label>Thumbnail</label>
        <div id="product_cat_thumbnail" style="float: left; margin-right: 10px; width: 200px"><img style="width: 100%; height: auto;" src="<?php if(isset($selectedimgid)) echo wp_get_attachment_image_src($selectedimgid)[0]; else echo "PLACEHOLDER-IMAGE-HERE.jpg";?>" width="60px" height="60px" /></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="product_cat_thumbnail_id" name="product_cat_thumbnail_id" value="<?php if(isset($selectedimgid)) echo $selectedimgid; ?>" />
            <button type="button" class="upload_image_button button">Upload/Add image</button>
            <button type="button" class="remove_image_button button">Remove image</button>
        </div>
        <script type="text/javascript">

            // Only show the "remove image" button when needed
            if ( ! jQuery( '#product_cat_thumbnail_id' ).val() ) {
                jQuery( '.remove_image_button' ).hide();
            }

            // Uploading files
            var file_frame;

            jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: 'Choose an image',
                    button: {
                        text: 'Use image'
                    },
                    multiple: false
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
                    var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                    jQuery( '#product_cat_thumbnail_id' ).val( attachment.id );
                    jQuery( '#product_cat_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
                    jQuery( '.remove_image_button' ).show();
                });

                // Finally, open the modal.
                file_frame.open();
            });

            jQuery( document ).on( 'click', '.remove_image_button', function() {
                jQuery( '#product_cat_thumbnail' ).find( 'img' ).attr( 'src', 'PLACEHOLDER-IMAGE-HERE.jpg' );
                jQuery( '#product_cat_thumbnail_id' ).val( '' );
                jQuery( '.remove_image_button' ).hide();
                return false;
            });

            jQuery( document ).ajaxComplete( function( event, request, options ) {
                if ( request && 4 === request.readyState && 200 === request.status
                    && options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

                    var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
                    if ( ! res || res.errors ) {
                        return;
                    }
                    // Clear Thumbnail fields on submit
                    jQuery( '#product_cat_thumbnail' ).find( 'img' ).attr( 'src', 'PLACEHOLDER-IMAGE-HERE.jpg' );
                    jQuery( '#product_cat_thumbnail_id' ).val( '' );
                    jQuery( '.remove_image_button' ).hide();
                    // Clear Display type field on submit
                    jQuery( '#display_type' ).val( '' );
                    return;
                }
            } );

        </script>
        <div class="clear"></div>
    </div>
    <?php

}



/* and save it */

add_action( 'edited_product_cat', 'product_cat_extra_fields_save', 10, 2);
add_action( 'created_product_cat', 'product_cat_extra_fields_save', 10, 2);
function product_cat_extra_fields_save( $term_id ) {

    if ( !isset( $_POST['product_cat_thumbnail_id'] ) ) return;
    update_term_meta( $term_id, "product_cat_thumbnail_id", $_POST['product_cat_thumbnail_id'] );

}



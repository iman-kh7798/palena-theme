<?php

function property_Marble_add_metabox(){
    add_meta_box(
        'post_custom_Marble',
        'Marble',
        'property_Marble_metabox_callback',
        'product', // Change post type name
        'normal',
        'core'
    );
}
add_action( 'admin_init', 'property_Marble_add_metabox' );


function property_Marble_metabox_callback(){
    wp_nonce_field( basename(__FILE__), 'sample_nonce' );
    global $post;
    if (idea_is_edit_page('new')){
        $Marble_data = null;
    }else{
        $postID=isset($_GET['post']) && $_GET['post'] != null ? $_GET['post'] : null;
        $Marble_data = get_post_meta( $postID, 'Marble_data', true );
    }

    ?>
    <div id="Marble_wrapper">
        <div id="img_box_container_Marble">
            <?php
            if ( isset( $Marble_data['image_url'] ) ){
            for( $i = 0; $i < count( $Marble_data['image_url'] ); $i++ ){
            ?>
            <div class="Marble_single_row dolu">
                <div class="Marble_area image_container ">
                    <img class="Marble_img_img" src="<?php esc_html_e( $Marble_data['image_url'][$i] ); ?>" height="55" width="55" onclick="open_Marble_uploader_image_this(this)"/>
                    <input type="hidden"
                           class="meta_image_url_Marble"
                           name="Marble[image_url][]"
                           value="<?php esc_html_e( $Marble_data['image_url'][$i] ); ?>"
                    />
                </div>
                <div class="Marble_area">
                    <span class="button remove" onclick="remove_Marble_img(this)" title="Remove"/><i class="fas fa-trash-alt"></i></span>
                </div>
                <div class="clear" />
            </div>
        </div>
        <?php
        }
        }
        ?>
    </div>
    <div style="display:none" id="master_box_Marble">
        <div class="Marble_single_row">
            <div class="Marble_area image_container" onclick="open_Marble_uploader_image(this)">
                <input class="meta_image_url_Marble" value="" type="hidden" name="Marble[image_url][]" />
            </div>
            <div class="Marble_area">
                <span class="button remove" onclick="remove_Marble_img(this)" title="Remove"/><i class="fas fa-trash-alt"></i></span>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div id="add_Marble_single_row">
        <input class="button add" type="button" value="+" onclick="open_Marble_uploader_image_plus();" title="Add image"/>
    </div>
    </div>
    <?php
}


function property_Marble_styles_scripts(){
    global $post;
    if( 'product' != $post->post_type )
        return;
    ?>
    <style type="text/css">
        .Marble_area {
            float:right;
        }
        .image_container {
            float:left!important;
            width: 100px;
            /*background: url('https://i.hizliresim.com/dOJ6qL.png');*/
            height: 100px;
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 3px;
            cursor: pointer;
        }
        .image_container img{
            height: 100px;
            width: 100px;
            border-radius: 3px;
        }
        .clear {
            clear:both;
        }
        #Marble_wrapper {
            width: 100%;
            height: auto;
            position: relative;
            display: inline-block;
        }
        #Marble_wrapper input[type=text] {
            width:300px;
        }
        #Marble_wrapper .Marble_single_row {
            float: left;
            display:inline-block;
            width: 100px;
            position: relative;
            margin-right: 8px;
            margin-bottom: 20px;
        }
        .dolu {
            display: inline-block!important;
        }
        #Marble_wrapper label {
            padding:0 6px;
        }
        .button.remove {
            background: none;
            color: #efb9b9;
            position: absolute;
            border: none;
            top: 4px;
            right: 7px;
            font-size: 1.2em;
            padding: 0px;
            box-shadow: none;
        }
        .button.remove:hover {
            background: none;
            color: #b60000;
        }
        .button.add {
            background: #c3c2c2;
            color: #ffffff;
            border: none;
            box-shadow: none;
            width: 100px;
            height: 100px;
            line-height: 100px;
            font-size: 4em;
        }
        .button.add:hover, .button.add:focus {
            background: #e2e2e2;
            box-shadow: none;
            color: #0f88c1;
            border: none;
        }
    </style>
    <script defer src="<?= esc_url(get_template_directory_uri()); ?>/assets/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
    <link href = "<?= esc_url(get_template_directory_uri()); ?>/assets/css/jquery-ui.css" rel = "stylesheet">
    <script defer src="<?= esc_url(get_template_directory_uri()); ?>/assets/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
    <script src = "<?= esc_url(get_template_directory_uri()); ?>/assets/js/jquery-ui.js"></script>
    <script type="text/javascript">
        function remove_Marble_img(value) {
            var parent=jQuery(value).parent().parent();
            parent.remove();
        }
        var media_uploader = null;
        function open_Marble_uploader_image(obj){
            media_uploader = wp.media({
                frame:    "post",
                state:    "insert",
                multiple: false
            });
            media_uploader.on("insert", function(){
                var json = media_uploader.state().get("selection").first().toJSON();

                var image_url = json.url;
                var html = '<img class="Marble_img_img" src="'+image_url+'" height="55" width="55" onclick="open_Marble_uploader_image_this(this)"/>';
                jQuery(obj).append(html);
                jQuery(obj).find('.meta_image_url_Marble').val(image_url);
            });
            media_uploader.open();
        }
        function open_Marble_uploader_image_this(obj){
            media_uploader = wp.media({
                frame:    "post",
                state:    "insert",
                multiple: false
            });
            media_uploader.on("insert", function(){
                var json = media_uploader.state().get("selection").first().toJSON();

                var image_url = json.url;
                console.log(image_url);
                jQuery(obj).attr('src',image_url);
                jQuery(obj).siblings('.meta_image_url_Marble').val(image_url);
            });
            media_uploader.open();
        }

        function open_Marble_uploader_image_plus(){
            media_uploader = wp.media({
                frame:    "post",
                state:    "insert",
                multiple: true
            });
            media_uploader.on("insert", function(){

                var length = media_uploader.state().get("selection").length;
                var images = media_uploader.state().get("selection").models;

                for(var i = 0; i < length; i++){
                    var image_url = images[i].changed.url;
                    if (image_url == undefined){
                        image_url = images[i].attributes.url;
                    }
                    var box = jQuery('#master_box_Marble').html();
                    jQuery(box).appendTo('#img_box_container_Marble');
                    var element = jQuery('#img_box_container_Marble .Marble_single_row:last-child').find('.image_container');
                    var html = '<img class="Marble_img_img" src="'+image_url+'" height="55"  />';
                    element.append(html);
                    element.find('.meta_image_url_Marble').val(image_url);
                }
            });
            media_uploader.open();
        }
        jQuery(function() {
            jQuery("#img_box_container_Marble").sortable(); // Activate jQuery UI sortable feature
        });
    </script>
    <?php
}
add_action( 'admin_head-post.php', 'property_Marble_styles_scripts' );
add_action( 'admin_head-post-new.php', 'property_Marble_styles_scripts' );



function property_Marble_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sample_nonce' ] ) && wp_verify_nonce( $_POST[ 'sample_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Correct post type
    if ( 'product' != $_POST['post_type'] ) // here you can set the post type name
        return;

    if ( $_POST['Marble'] ){

        // Build array for saving post meta
        $Marble_data = array();
        for ($i = 0; $i < count( $_POST['Marble']['image_url'] ); $i++ ){
            if ( '' != $_POST['Marble']['image_url'][$i]){
                $Marble_data['image_url'][]  = $_POST['Marble']['image_url'][ $i ];
            }
        }

        if ( $Marble_data )
            update_post_meta( $post_id, 'Marble_data', $Marble_data );
        else
            delete_post_meta( $post_id, 'Marble_data' );
    }
    // Nothing received, all fields are empty, delete option
    else{
        delete_post_meta( $post_id, 'Marble_data' );
    }
}
add_action( 'save_post', 'property_Marble_save' );
<?php
//function add_horizontal_thumb_meta_boxes() {
//    add_meta_box('horizontal_thumb', 'Horizontal Image', 'horizontal_thumb', 'product', 'normal', 'high');
//}
//add_action('add_meta_boxes', 'add_horizontal_thumb_meta_boxes');
//
//function horizontal_thumb() {
//    wp_nonce_field(plugin_basename(__FILE__), 'horizontal_thumb_nonce');
//    $html = '<p class="description">';
//    $html .= 'Upload your PDF here.';
//    $html .= '</p>';
//    $html .= '<input type="file" id="horizontal_thumb" name="horizontal_thumb" value="" size="25">';
//    echo $html;
//}
//
//add_action('save_post', 'save_horizontal_thumb_meta_data');
//function save_horizontal_thumb_meta_data($id) {
//    if(!empty($_FILES['horizontal_thumb']['name'])) {
//        $supported_types = array('application/pdf');
//        $arr_file_type = wp_check_filetype(basename($_FILES['horizontal_thumb']['name']));
//        $uploaded_type = $arr_file_type['type'];
//
//        if(in_array($uploaded_type, $supported_types)) {
//            $upload = wp_upload_bits($_FILES['horizontal_thumb']['name'], null, file_get_contents($_FILES['horizontal_thumb']['tmp_name']));
//            if(isset($upload['error']) && $upload['error'] != 0) {
//                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
//            } else {
//                update_post_meta($id, 'horizontal_thumb', $upload);
//            }
//        }
//        else {
//            wp_die("The file type that you've uploaded is not a PDF.");
//        }
//    }
//}
//
//function update_edit_form_horizontal_thumb() {
//    echo ' enctype="multipart/form-data"';
//}
//add_action('post_edit_form_tag', 'update_edit_form_horizontal_thumb');



function property_Horizontal_thumb_add_metabox(){
    add_meta_box(
        'post_custom_Horizontal_image',
        'Horizontal Image',
        'property_Horizontal_thumb_metabox_callback',
        'product', // Change post type name
        'side',
        'core'
    );
}
add_action( 'admin_init', 'property_Horizontal_thumb_add_metabox' );


function property_Horizontal_thumb_metabox_callback(){
    wp_nonce_field( basename(__FILE__), 'sample_nonce' );
    global $post;
    if (idea_is_edit_page('new')){
        $Horizontal_thumb_data = null;
    }else{
        $postID=isset($_GET['post']) && $_GET['post'] != null ? $_GET['post'] : null;
        $Horizontal_thumb_data = get_post_meta( $postID, 'Horizontal_thumb_data', true );
    }

    ?>


    <div id="horizontal_thumb_wrapper"  >
        <div id="img_box_container_horizontal_thumb">
            <?php
            $hasCount =false;
            if ( isset( $Horizontal_thumb_data['image_url'] ) ){
            for( $i = 0; $i < count( $Horizontal_thumb_data['image_url'] ); $i++ ){
                $hasCount=true;
            ?>
            <div class="horizontal_thumb_single_row dolu">
                <div class="horizontal_thumb_area image_container ">
                    <img class="horizontal_thumb_img_img" src="<?php esc_html_e( $Horizontal_thumb_data['image_url'][$i] ); ?>" style="height: auto; width: 250px"/>
                    <input type="hidden"
                           class="meta_image_url_horizontal_thumb"
                           name="horizontal_thumb[image_url][]"
                           value="<?php esc_html_e( $Horizontal_thumb_data['image_url'][$i] ); ?>"
                    />
                </div>
                <div class="horizontal_thumb_area">
                    <span class="button remove" onclick="remove_horizontal_thumb_img(this)" title="Remove"/><i class="fas fa-trash-alt"></i></span>
                </div>
                <div class="clear" />
            </div>
        </div>
        <?php
        }
        }
        ?>
    </div>
    <div style="display:none" id="master_box_horizontal_thumb">
        <div class="horizontal_thumb_single_row">
            <div class="horizontal_thumb_area image_container" >
                <input class="meta_image_url_horizontal_thumb" value="" type="hidden" name="horizontal_thumb[image_url][]" />
            </div>
            <div class="horizontal_thumb_area">
                <span class="button remove" onclick="remove_horizontal_thumb_img(this)" title="Remove"/><i class="fas fa-trash-alt"></i></span>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div id="add_horizontal_thumb_single_row">
        <input class="button add addBtn" <?= $hasCount === true ? ' style="display:none;"' : ''?> type="button" value="+" onclick="open_horizontal_thumb_uploader_image_plus();" title="Add image"/>
    </div>
    </div>
    <?php
}


function property_horizontal_thumb_styles_scripts(){
    global $post;
    if( 'product' != $post->post_type )
        return;
    ?>
    <style type="text/css">
        .horizontal_thumb_area {
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
        #horizontal_thumb_wrapper {
            width: 100%;
            height: auto;
            position: relative;
            display: inline-block;
        }
        #horizontal_thumb_wrapper input[type=text] {
            width:300px;
        }
        #horizontal_thumb_wrapper .horizontal_thumb_single_row {
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
        #horizontal_thumb_wrapper label {
            padding:0 6px;
        }
        .button.remove {
            background: none;
            color: #efb9b9;
            position: absolute;
            border: none;
            top: 0;
            left: 0;
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
        function remove_horizontal_thumb_img(value) {
            var parent=jQuery(value).parent().parent();
            parent.remove();
            jQuery('.addBtn').show();
        }
        var media_uploader = null;
        function open_horizontal_thumb_uploader_image(obj){
            media_uploader = wp.media({
                frame:    "post",
                state:    "insert",
                multiple: false
            });
            media_uploader.on("insert", function(){
                var json = media_uploader.state().get("selection").first().toJSON();
                var image_url = json.url;
                var html = '<img class="horizontal_thumb_img_img" src="'+image_url+'" style="height: auto; width: 250px"/>';
                console.log(image_url);
                jQuery(obj).append(html);
                jQuery(obj).find('.meta_image_url_horizontal_thumb').val(image_url);
            });
            media_uploader.open();
        }
        function open_horizontal_thumb_uploader_image_this(obj){
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
                jQuery(obj).siblings('.meta_image_url_horizontal_thumb').val(image_url);
            });
            media_uploader.open();
        }

        function open_horizontal_thumb_uploader_image_plus(){
            media_uploader = wp.media({
                frame:    "post",
                state:    "insert",
                multiple: false
            });
            media_uploader.on("insert", function(){

                var length = media_uploader.state().get("selection").length;
                var images = media_uploader.state().get("selection").models

                for(var i = 0; i < length; i++){
                    var image_url = images[i].changed.url;
                    if (image_url === undefined){
                        image_url = images[i].attributes.url;
                    }
                    var box = jQuery('#master_box_horizontal_thumb').html();
                    jQuery(box).appendTo('#img_box_container_horizontal_thumb');
                    var element = jQuery('#img_box_container_horizontal_thumb .horizontal_thumb_single_row:last-child').find('.image_container');
                    var html = '<img class="horizontal_thumb_img_img" src="'+image_url+'" style="height: auto; width: 250px"/>';
                    element.append(html);
                    element.find('.meta_image_url_horizontal_thumb').val(image_url);
                }
                jQuery('.addBtn').hide();
            });
            media_uploader.open();
        }
        jQuery(function() {
            jQuery("#img_box_container_horizontal_thumb").sortable(); // Activate jQuery UI sortable feature
        });
    </script>
    <?php
}
add_action( 'admin_head-post.php', 'property_horizontal_thumb_styles_scripts' );
add_action( 'admin_head-post-new.php', 'property_horizontal_thumb_styles_scripts' );



function property_horizontal_thumb_save( $post_id ) {
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

    if ( $_POST['horizontal_thumb'] ){

        // Build array for saving post meta
        $Horizontal_thumb_data = array();
        for ($i = 0; $i < count( $_POST['horizontal_thumb']['image_url'] ); $i++ ){
            if ( '' != $_POST['horizontal_thumb']['image_url'][$i]){
                $Horizontal_thumb_data['image_url'][]  = $_POST['horizontal_thumb']['image_url'][ $i ];
            }
        }

        if ( $Horizontal_thumb_data )
            update_post_meta( $post_id, 'Horizontal_thumb_data', $Horizontal_thumb_data );
        else
            delete_post_meta( $post_id, 'Horizontal_thumb_data' );
    }
    // Nothing received, all fields are empty, delete option
    else{
        delete_post_meta( $post_id, 'Horizontal_thumb_data' );
    }
}
add_action( 'save_post', 'property_horizontal_thumb_save' );
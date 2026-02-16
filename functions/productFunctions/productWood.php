<?php

$theme_settings = get_option( 'mainThemeSettingPage' );
if (isset($theme_settings['ProductComponents']) && is_array($theme_settings['ProductComponents'])):
    foreach ($theme_settings['ProductComponents'] as $p_component) {
        $p_component= str_replace(' ','_',$p_component);

        add_action('admin_init',
            function () use ($p_component) {
                add_meta_box(
                    'post_custom_' . $p_component,
                    $p_component,
                    function () use ($p_component) {
                        wp_nonce_field(basename(__FILE__), 'sample_nonce' . $p_component);
                        global $post;
                        if (idea_is_edit_page('new')){
                            $Wood_data = null;
                        }else{
                            $postID=isset($_GET['post']) && $_GET['post'] != null ? $_GET['post'] : null;
                            $Wood_data = get_post_meta($postID, $p_component . '_data', true);
                        }

                        ?>
                        <div id="<?= $p_component ?>_wrapper">
                            <div id="img_box_container_<?= $p_component ?>">
                                <?php
                                if (isset($Wood_data['image_url'])){
                                for ($i = 0;
                                $i < count($Wood_data['image_url']);
                                $i++){
                                ?>
                                <div class="<?= $p_component ?>_single_row dolu">
                                    <div class="<?= $p_component ?>_area image_container ">
                                        <img class="<?= $p_component ?>_img_img"
                                             src="<?php esc_html_e($Wood_data['image_url'][$i]); ?>" height="55" width="55"
                                             onclick="open_<?= $p_component ?>_uploader_image_this(this)"/>
                                        <input type="hidden"
                                               class="meta_image_url_<?= $p_component ?>"
                                               name="<?= $p_component ?>[image_url][]"
                                               value="<?php esc_html_e($Wood_data['image_url'][$i]); ?>"
                                        />
                                    </div>
                                    <div class="<?= $p_component ?>_area">
                                    <span class="button remove" onclick="remove_<?= $p_component ?>_img(this)"
                                          title="Remove"/><i class="fas fa-trash-alt"></i></span>
                                    </div>
                                    <div class="clear"/>
                                </div>
                            </div>
                            <?php
                            }
                            }
                            ?>
                        </div>
                        <div style="display:none" id="master_box_<?= $p_component ?>">
                            <div class="<?= $p_component ?>_single_row">
                                <div class="<?= $p_component ?>_area image_container"
                                     onclick="open_<?= $p_component ?>_uploader_image(this)">
                                    <input class="meta_image_url_<?= $p_component ?>" value="" type="hidden"
                                           name="<?= $p_component ?>[image_url][]"/>
                                </div>
                                <div class="<?= $p_component ?>_area">
                                <span class="button remove" onclick="remove_<?= $p_component ?>_img(this)"
                                      title="Remove"/><i class="fas fa-trash-alt"></i></span>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div id="add_<?= $p_component ?>_single_row">
                            <input class="button add" type="button" value="+"
                                   onclick="open_<?= $p_component ?>_uploader_image_plus();" title="Add image"/>
                        </div>
                        </div>
                        <?php
                    },
                    'product', // Change post type name
                    'normal',
                    'core'
                );
            });





        add_action( 'admin_head-post.php',  function () use ($p_component) {
            global $post;
            if( 'product' != $post->post_type )
                return;
            ?>
            <style type="text/css">
                .<?=$p_component?>_area {
                    float:right;
                }
                .image_container {
                    float:left!important;
                    width: 100px;
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
                #<?=$p_component?>_wrapper {
                    width: 100%;
                    height: auto;
                    position: relative;
                    display: inline-block;
                }
                #<?=$p_component?>_wrapper input[type=text] {
                    width:300px;
                }
                #<?=$p_component?>_wrapper .<?=$p_component?>_single_row {
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
                #<?=$p_component?>_wrapper label {
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
                function remove_<?=$p_component?>_img(value) {
                    var parent=jQuery(value).parent().parent();
                    parent.remove();
                }
                var media_uploader = null;
                function open_<?=$p_component?>_uploader_image(obj){
                    media_uploader = wp.media({
                        frame:    "post",
                        state:    "insert",
                        multiple: false
                    });
                    media_uploader.on("insert", function(){
                        var json = media_uploader.state().get("selection").first().toJSON();
                        var image_url = json.url;
                        var html = '<img class="<?=$p_component?>_img_img" src="'+image_url+'" height="55" width="55" onclick="open_<?=$p_component?>_uploader_image_this(this)"/>';
                        jQuery(obj).append(html);
                        jQuery(obj).find('.meta_image_url_<?=$p_component?>').val(image_url);
                    });
                    media_uploader.open();
                }
                function open_<?=$p_component?>_uploader_image_this(obj){
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
                        jQuery(obj).siblings('.meta_image_url_<?=$p_component?>').val(image_url);
                    });
                    media_uploader.open();
                }

                function open_<?=$p_component?>_uploader_image_plus(){
                    media_uploader = wp.media({
                        frame:    "post",
                        state:    "insert",
                        multiple: true
                    });
                    media_uploader.on("insert", function(){

                        var length = media_uploader.state().get("selection").length;
                        var images = media_uploader.state().get("selection").models

                        for(var i = 0; i < length; i++){
                            var image_url = images[i].changed.url;
                            if (image_url === undefined){
                                image_url = images[i].attributes.url;
                            }
                            var box = jQuery('#master_box_<?=$p_component?>').html();
                            jQuery(box).appendTo('#img_box_container_<?=$p_component?>');
                            var element = jQuery('#img_box_container_<?=$p_component?> .<?=$p_component?>_single_row:last-child').find('.image_container');
                            var html = '<img class="<?=$p_component?>_img_img" src="'+image_url+'" height="55" width="55" onclick="open_<?=$p_component?>_uploader_image_this(this)"/>';
                            element.append(html);
                            element.find('.meta_image_url_<?=$p_component?>').val(image_url);
                        }
                    });
                    media_uploader.open();
                }
                jQuery(function() {
                    jQuery("#img_box_container_<?=$p_component?>").sortable(); // Activate jQuery UI sortable feature
                });
            </script>
            <?php
        });
        add_action( 'admin_head-post-new.php', function () use ($p_component) {
            global $post;
            if( 'product' != $post->post_type )
                return;
            ?>
            <style type="text/css">
                .<?=$p_component?>_area {
                    float:right;
                }
                .image_container {
                    float:left!important;
                    width: 100px;
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
                #<?=$p_component?>_wrapper {
                    width: 100%;
                    height: auto;
                    position: relative;
                    display: inline-block;
                }
                #<?=$p_component?>_wrapper input[type=text] {
                    width:300px;
                }
                #<?=$p_component?>_wrapper .<?=$p_component?>_single_row {
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
                #<?=$p_component?>_wrapper label {
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
                function remove_<?=$p_component?>_img(value) {
                    var parent=jQuery(value).parent().parent();
                    parent.remove();
                }
                var media_uploader = null;
                function open_<?=$p_component?>_uploader_image(obj){
                    media_uploader = wp.media({
                        frame:    "post",
                        state:    "insert",
                        multiple: false
                    });
                    media_uploader.on("insert", function(){
                        var json = media_uploader.state().get("selection").first().toJSON();
                        var image_url = json.url;
                        var html = '<img class="<?=$p_component?>_img_img" src="'+image_url+'" height="55" width="55" onclick="open_<?=$p_component?>_uploader_image_this(this)"/>';
                        jQuery(obj).append(html);
                        jQuery(obj).find('.meta_image_url_<?=$p_component?>').val(image_url);
                    });
                    media_uploader.open();
                }
                function open_<?=$p_component?>_uploader_image_this(obj){
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
                        jQuery(obj).siblings('.meta_image_url_<?=$p_component?>').val(image_url);
                    });
                    media_uploader.open();
                }

                function open_<?=$p_component?>_uploader_image_plus(){
                    media_uploader = wp.media({
                        frame:    "post",
                        state:    "insert",
                        multiple: true
                    });
                    media_uploader.on("insert", function(){

                        var length = media_uploader.state().get("selection").length;
                        var images = media_uploader.state().get("selection").models

                        for(var i = 0; i < length; i++){
                            var image_url = images[i].changed.url;
                            if (image_url === undefined){
                                image_url = images[i].attributes.url;
                            }
                            var box = jQuery('#master_box_<?=$p_component?>').html();
                            jQuery(box).appendTo('#img_box_container_<?=$p_component?>');
                            var element = jQuery('#img_box_container_<?=$p_component?> .<?=$p_component?>_single_row:last-child').find('.image_container');
                            var html = '<img class="<?=$p_component?>_img_img" src="'+image_url+'" height="55" width="55" onclick="open_<?=$p_component?>_uploader_image_this(this)"/>';
                            element.append(html);
                            element.find('.meta_image_url_<?=$p_component?>').val(image_url);
                        }
                    });
                    media_uploader.open();
                }
                jQuery(function() {
                    jQuery("#img_box_container_<?=$p_component?>").sortable(); // Activate jQuery UI sortable feature
                });
            </script>
            <?php
        } );

        add_action( 'save_post', function ( $post_id ) use ($p_component) {
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }
            $is_autosave = wp_is_post_autosave( $post_id );
            $is_revision = wp_is_post_revision( $post_id );
            $is_valid_nonce = ( isset( $_POST[ 'sample_nonce'.$p_component ] ) && wp_verify_nonce( $_POST[ 'sample_nonce'.$p_component ], basename( __FILE__ ) ) ) ? 'true' : 'false';

            if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
                return;
            }
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }

            // Correct post type
            if ( 'product' != $_POST['post_type'] ) // here you can set the post type name
                return;

            if ( $_POST[$p_component] ){

                // Build array for saving post meta
                $Wood_data = array();
                for ($i = 0; $i < count( $_POST[$p_component]['image_url'] ); $i++ ){
                    if ( '' != $_POST[$p_component]['image_url'][$i]){
                        $Wood_data['image_url'][]  = $_POST[$p_component]['image_url'][ $i ];
                    }
                }

                if ( $Wood_data )
                    update_post_meta( $post_id, $p_component.'_data', $Wood_data );
                else
                    delete_post_meta( $post_id, $p_component.'_data' );
            }
            // Nothing received, all fields are empty, delete option
            else{
                delete_post_meta( $post_id, $p_component.'_data' );
            }
        } );
    }


endif;

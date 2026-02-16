<?php

function askTheSellerScripts_custom() {
    add_action( 'wp_footer', function () {
        ?>
<!--        <script src="--><?//= esc_url( get_template_directory_uri() ); ?><!--/assets/js/jquery.form.js"></script>-->
<!--        <script src="--><?//= esc_url( get_template_directory_uri() ); ?><!--/assets/js/jquery.validate.min.js"></script>-->
<!--        <script src="--><?//= esc_url( get_template_directory_uri() ); ?><!--/assets/js/sweetalert.min.js"></script>-->
        <script>
            $(function (){
                $("#AskTheSellerForm_custom").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        // family: {
                        //     required: true,
                        // },
                        phone: {
                            required: true,
                        },
                        email: {
                            required: true,
                            email: true
                        },
                    },
                    messages: {
                        name: {
                            required: "Please enter your Name",
                        },
                        // family: {
                        //     required: "Please enter your Family",
                        // },
                        phone: {
                            required: "Please enter your Phone Number",
                        },
                        email: {
                            required: "Please enter your Email Address",
                            email: "Please enter valid email address",
                        },
                    },
                    errorClass: 'input-has-error',
                    errorElement: 'span',

                    submitHandler: function (form) {
                        var options = {
                            //  beforeSubmit:  showRequest,  // pre-submit callback
                            beforeSubmit: function () {
                                $('#submitAskTheSellerForm_custom').prop('disabled',true).html('Sending Message ...');
                            },
                            success: showResponse,  // post-submit callback
                            error: showErrors,
                            dataType: "json",
                            clearForm: false,        // clear all form fields after successful submit
                            resetForm: false,        // reset the form after successful submit
                        };

                        function showResponse(responseText, statusText, xhr, $form) {
                            if (responseText.status === true) {
                                swal({
                                    icon: "success",
                                    text: responseText.message,
                                    // value: true,
                                    // visible: true,
                                    className: "",
                                    buttons: {
                                        cancel: {
                                            text: "OK",
                                            value: true,
                                            visible: true,
                                            className: "btn  btn-success",
                                            closeModal: true,
                                        }
                                    }

                                });
                                $('input[name="ideaCsrfField2"]').val(responseText.token2);
                                $('#ask_seller_modal').modal('hide');
                            }
                            $('#submitAskTheSellerForm_custom').prop('disabled',false).html('Send Message');
                        }

                        function showErrors(err) {
                            $('#submitAskTheSellerForm_custom').prop('disabled',false).html('Send Message');
                            if (err.status === 422) { // when status code is 422, it's a validation issue

                                swal({
                                    icon: "warning",
                                    text: err.responseJSON.message,
                                    // value: true,
                                    // visible: true,
                                    className: "",
                                    buttons: {
                                        cancel: {
                                            text: "OK",
                                            value: true,
                                            visible: true,
                                            className: "btn btn-warning",
                                            closeModal: true,
                                        }
                                    }

                                });
                            }
                        }

                        $(form).ajaxSubmit(options);
                    },
                });

            })

        </script>
        <?php

    } );
}


//
add_action( 'wp_ajax_ask_the_seller_final_form_custom', 'ask_the_seller_final_form_custom' );
add_action( 'wp_ajax_nopriv_ask_the_seller_final_form_custom', 'ask_the_seller_final_form_custom' );
function ask_the_seller_final_form_custom() {
    if (verifyIdeaCsrf2() == false){
        wp_send_json( [ 'status' => false, 'message' => 'Error In Security Code' ], 422 );
    }
    if(isset($_POST['wishList']) && $_POST['wishList'] == 'ok'){
        //save from wishlist

        $validationStatus = true;
        $validationError  = '';

        if ( ! isset( $_POST['name'] ) || ( isset( $_POST['name'] ) && $_POST['name'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Name Is Required" . "\n";
        }
//        if ( ! isset( $_POST['family'] ) || ( isset( $_POST['family'] ) && $_POST['family'] == '' ) ) {
//            $validationStatus = false;
//            $validationError  .= "Family Is Required" . "\n";
//        }
        if ( ! isset( $_POST['phone'] ) || ( isset( $_POST['phone'] ) && $_POST['phone'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Phone Number Is Required" . "\n";
        }
        if ( ! isset( $_POST['email'] ) || ( isset( $_POST['email'] ) && $_POST['email'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Email Is Required" . "\n";
        }
        if ( $validationStatus === false ) {
            wp_send_json( [ 'status' => false, 'message' => $validationError ], 422 );
            wp_die();
        }

        $sellers_Emails = [];
        $message="";
        if (is_array($_POST['products']) && count($_POST['products'])){
            foreach ($_POST['products'] as $P_ID){



                $sellerNames='';
                $product_sellers = (array)wp_get_post_terms($P_ID, 'product_seller');
                if (count($product_sellers)) {
                    $theme_settings = get_option( 'mainThemeSettingPage' );
                    foreach ($product_sellers as $product_seller){
                        if (isset($theme_settings[$product_seller->slug.'_email_address']) && $theme_settings[$product_seller->slug.'_email_address'] != null){
                            $sellers_Emails[]=$theme_settings[$product_seller->slug.'_email_address'];
                            $sellerNames.=$product_seller->name.' , ';
                        }
                    }
                }


                $dimensions_input='NO';
                $length=null;
                $width=null;
                $height=null;
                if (isset($_POST['dimensions_input']) && $_POST['dimensions_input'] == 'on'){
                    $dimensions_input="YES";
                    $length=sanitize_text_field($_POST['length']);
                    $width=sanitize_text_field($_POST['width']);
                    $height=sanitize_text_field($_POST['height']);
                }

                $postTitle=get_the_title($P_ID);
                $postLink=get_permalink($P_ID);

                $name=sanitize_text_field( $_POST['name'] );
                $phone=sanitize_text_field( $_POST['phone'] );
                $email=sanitize_email( $_POST['email'] );
                $user_message=sanitize_textarea_field( $_POST['user_message'] );

                global $wpdb;
                $tablename = $wpdb->prefix . 'ask_the_seller_custom';
                $data      = array(
                    'name' => $name,
                    'family' => null,
                    'phone' => $phone,
                    'email' => $email,
                    'message' => $user_message,
                    'dimensions_input' => $dimensions_input,
                    'length' => $length,
                    'width' => $width,
                    'height' => $height,
                    'seller' => $sellerNames,
                    'postTitle' => $postTitle,
                    'postLink' => $postLink,
                    'seen' => 'no',
                    'completed' => 'no',
                );
                $res       = $wpdb->insert( $tablename, $data );

                if ( $res ) {

                    $message .= 'new message from '.$name . "<br>";
                    $message.='phone number : '.$phone . "<br>";
                    $message.='email address : '.$email . "<br>";
                    $message.='user message : '.$user_message . "<br>";
                    if ($dimensions_input == 'YES'){
                        $message.='Dimensions ' . "<br>";
                        $message.='length :  ' .$length . "<br>";
                        $message.='width :  ' .$width . "<br>";
                        $message.='height :  ' .$height . "<br>";
                    }
                    $message.='Product Title : '.$postTitle . "<br>";
                    $message.='Product Link : '.$postLink . "<br>";
                    $message.="<br>";



                }


            }


            if (count($sellers_Emails)){
                $sellers_Emails=array_unique($sellers_Emails);
            }

            $subject='new message';
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            if (count($sellers_Emails)){
                foreach ($sellers_Emails as $sellers_Email){
                    wp_mail( $sellers_Email, $subject, $message,$headers);
                }
            }

            wp_send_json( [ 'status' => true, 'message' => 'Mission accomplished successfully .','token2'=>idea_csrf_create2() ], 200 );
            wp_die();

        }







    }else{
        //save from single product

        $validationStatus = true;
        $validationError  = '';

        if ( ! isset( $_POST['name'] ) || ( isset( $_POST['name'] ) && $_POST['name'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Name Is Required" . "\n";
        }
//        if ( ! isset( $_POST['family'] ) || ( isset( $_POST['family'] ) && $_POST['family'] == '' ) ) {
//            $validationStatus = false;
//            $validationError  .= "Family Is Required" . "\n";
//        }
        if ( ! isset( $_POST['phone'] ) || ( isset( $_POST['phone'] ) && $_POST['phone'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Phone Number Is Required" . "\n";
        }
        if ( ! isset( $_POST['email'] ) || ( isset( $_POST['email'] ) && $_POST['email'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Email Is Required" . "\n";
        }
        if ( ! isset( $_POST['product'] ) || ( isset( $_POST['product'] ) && $_POST['product'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Your inputs are not considered secure !" . "\n";
        }
        if ( ! isset( $_POST['postTitle'] ) || ( isset( $_POST['postTitle'] ) && $_POST['postTitle'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Your inputs are not considered secure !" . "\n";
        }
        if ( ! isset( $_POST['postLink'] ) || ( isset( $_POST['postLink'] ) && $_POST['postLink'] == '' ) ) {
            $validationStatus = false;
            $validationError  .= "Your inputs are not considered secure !" . "\n";
        }

        if ( $validationStatus === false ) {
            wp_send_json( [ 'status' => false, 'message' => $validationError ], 422 );
            wp_die();
        }




        $sellers_Emails = [];
        $sellerNames='';
        $product_sellers = (array)wp_get_post_terms(sanitize_text_field($_POST["product"]), 'product_seller');
        if (count($product_sellers)) {
            $theme_settings = get_option( 'mainThemeSettingPage' );
            foreach ($product_sellers as $product_seller){
                if (isset($theme_settings[$product_seller->slug.'_email_address']) && $theme_settings[$product_seller->slug.'_email_address'] != null){
                    $sellers_Emails[]=$theme_settings[$product_seller->slug.'_email_address'];
                    $sellerNames.=$product_seller->name.' , ';
                }
            }
        }


        $dimensions_input='NO';
        $Company=null;
        $Resale=null;
        $address=null;
        if (isset($_POST['dimensions_input']) && $_POST['dimensions_input'] == 'on'){
            $dimensions_input="YES";
            $length=sanitize_text_field($_POST['length']);
            $width=sanitize_text_field($_POST['width']);
            $height=sanitize_text_field($_POST['height']);
        }

        $postTitle=sanitize_text_field($_POST['postTitle']);
        $postLink=esc_url_raw($_POST['postLink']);

        $name=sanitize_text_field( $_POST['name'] );
//        $family=sanitize_text_field( $_POST['family'] );
        $phone=sanitize_text_field( $_POST['phone'] );
        $email=sanitize_email( $_POST['email'] );
        $user_message=sanitize_textarea_field( $_POST['user_message'] );

        global $wpdb;
        $tablename = $wpdb->prefix . 'ask_the_seller_custom';
        $data      = array(
            'name' => $name,
            'family' => null,
            'phone' => $phone,
            'email' => $email,
            'message' => $user_message,
            'dimensions_input' => $dimensions_input,
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'seller' => $sellerNames,
            'postTitle' => $postTitle,
            'postLink' => $postLink,
            'seen' => 'no',
            'completed' => 'no',
        );
        $res       = $wpdb->insert( $tablename, $data );

        if ( $res ) {
            $subject='new message';
            $message = 'new message from '.$name . "<br>";
            $message.='phone number : '.$phone . "<br>";
            $message.='email address : '.$email . "<br>";
            $message.='user message : '.$user_message . "<br>";
            if ($dimensions_input == 'YES'){
                $message.='Dimensions ' . "<br>";
                $message.='length :  ' .$length . "<br>";
                $message.='width :  ' .$width . "<br>";
                $message.='height :  ' .$height . "<br>";
            }
            $message.='Product Title : '.$postTitle . "<br>";
            $message.='Product Link : '.$postLink . "<br>";

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            if (count($sellers_Emails)){
                foreach ($sellers_Emails as $sellers_Email){
                    wp_mail( $sellers_Email, $subject, $message,$headers);
                }
            }

            wp_send_json( [ 'status' => true, 'message' => 'Mission accomplished successfully .','token2'=>idea_csrf_create2() ], 200 );
        }else{
            wp_send_json(['status'=>false,'message'=>'Operation failure !'],422);

        }


    }


}

if ( ! function_exists( 'ask_the_seller_table_custom' ) ) :

    function ask_the_seller_table_custom() {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        //* Create the teams table
        $table_name = $wpdb->prefix . 'ask_the_seller_custom';
        $sql        = "CREATE TABLE $table_name (
              id INTEGER NOT NULL AUTO_INCREMENT,
			  name varchar(100) NULL ,
			  family varchar(100)  NULL ,
			  phone varchar(25) NULL ,
			  email varchar(100) NULL ,
			  message text NULL ,
			  dimensions_input varchar(5) NULL ,
			  length varchar(190) NULL ,
			  width varchar(190) NULL ,
			  height varchar(190) NULL ,
			  postTitle varchar(190) NULL ,
			  postLink text NULL ,
			  seller varchar(190) NULL ,
			  OperatorDescription text NULL ,
			  seen varchar(50) NULL ,
			  completed varchar(50) NULL ,
			  created_at timestamp default current_timestamp ,
              updated_at timestamp ,
			  PRIMARY KEY (id)
                ) $charset_collate;";
        dbDelta( $sql );


        register_activation_hook( __FILE__, 'ask_the_seller_custom' );
    }
endif; // ask_the_seller_table
add_action( 'after_setup_theme', 'ask_the_seller_table_custom' );



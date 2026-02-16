<?php

function askTheSellerScripts() {
    add_action( 'wp_footer', function () {
        ?>
        <script src="<?= esc_url( get_template_directory_uri() ); ?>/assets/js/jquery.form.js"></script>
        <script src="<?= esc_url( get_template_directory_uri() ); ?>/assets/js/jquery.validate.min.js"></script>
        <script src="<?= esc_url( get_template_directory_uri() ); ?>/assets/js/sweetalert.min.js"></script>
        <script>
            $(function (){
                $("#AskTheSellerForm").validate({
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
                                $('#submitAskTheSellerForm').prop('disabled',true).html('Sending Message ...');
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
                                $('input[name="ideaCsrfField"]').val(responseText.token);
                                $('#ask_seller_modal').modal('hide');
                            }
                            $('#submitAskTheSellerForm').prop('disabled',false).html('Send Message');
                        }

                        function showErrors(err) {
                            $('#submitAskTheSellerForm').prop('disabled',false).html('Send Message');
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
add_action( 'wp_ajax_ask_the_seller_final_form', 'ask_the_seller_final_form' );
add_action( 'wp_ajax_nopriv_ask_the_seller_final_form', 'ask_the_seller_final_form' );
function ask_the_seller_final_form() {
    if (verifyIdeaCsrf() == false){
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
                $size='';
                $sizes=(array)wp_get_post_terms( $P_ID, 'size');
                if (isset($sizes[0]) && isset($sizes[0]->slug)){
                    $size=$sizes[0]->slug;

                }


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


                $designer='NO';
                $Company=null;
                $Resale=null;
                $address=null;
                if (isset($_POST['designer_input']) && $_POST['designer_input'] == 'on'){
                    $designer="YES";
                    $Company=sanitize_text_field($_POST['Company']);
//                    $Resale=sanitize_text_field($_POST['Resale']);
                    $address=sanitize_text_field($_POST['address']);
                }

                $postTitle=get_the_title($P_ID);
                $postLink=get_permalink($P_ID);

                $name=sanitize_text_field( $_POST['name'] );
//                $family=sanitize_text_field( $_POST['family'] );
                $phone=sanitize_text_field( $_POST['phone'] );
                $email=sanitize_email( $_POST['email'] );
                $user_message=sanitize_textarea_field( $_POST['user_message'] );


                global $wpdb;
                $tablename = $wpdb->prefix . 'ask_the_seller';
                $data      = array(
                    'name' => $name,
                    'family' => null,
                    'phone' => $phone,
                    'email' => $email,
                    'message' => $user_message,
                    'designer' => $designer,
                    'Company' => $Company,
                    'Resale' => null,
                    'address' => $address,
                    'seller' => $sellerNames,
                    'size' => $size,
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
                    if ($designer == 'YES'){
                        $message.='user is Designer ' . "<br>";
                        $message.='user Company :  ' .$Company . "<br>";
//                        $message.='user Resale :  ' .$Resale . "<br>";
                        $message.='user Address :  ' .$address . "<br>";
                    }
                    $message.='Size : '.$size . "<br>";
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

            wp_send_json( [ 'status' => true, 'message' => 'Mission accomplished successfully .','token'=>idea_csrf_create() ], 200 );
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

        $size='';
        $sizes=(array)wp_get_post_terms( sanitize_text_field($_POST["product"]), 'size');
        if (isset($sizes[0]) && isset($sizes[0]->slug)){
            $size=$sizes[0]->slug;
            if ($size == 'horizontal-and-vertical'){
                if ( ! isset( $_POST['size'] ) || ( isset( $_POST['size'] ) && $_POST['size'] == '' ) ) {
                    $validationError  = "Your inputs are not considered secure !" . "\n";
                    wp_send_json( [ 'status' => false, 'message' => $validationError ], 422 );
                    wp_die();
                }
                $size=sanitize_text_field($_POST['size']);
            }
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


        $designer='NO';
        $Company=null;
        $Resale=null;
        $address=null;
        if (isset($_POST['designer_input']) && $_POST['designer_input'] == 'on'){
            $designer="YES";
            $Company=sanitize_text_field($_POST['Company']);
//            $Resale=sanitize_text_field($_POST['Resale']);
            $address=sanitize_text_field($_POST['address']);
        }

        $postTitle=sanitize_text_field($_POST['postTitle']);
        $postLink=esc_url_raw($_POST['postLink']);

        $name=sanitize_text_field( $_POST['name'] );
//        $family=sanitize_text_field( $_POST['family'] );
        $phone=sanitize_text_field( $_POST['phone'] );
        $email=sanitize_email( $_POST['email'] );
        $user_message=sanitize_textarea_field( $_POST['user_message'] );

        global $wpdb;
        $tablename = $wpdb->prefix . 'ask_the_seller';
        $data      = array(
            'name' => $name,
            'family' => null,
            'phone' => $phone,
            'email' => $email,
            'message' => $user_message,
            'designer' => $designer,
            'Company' => $Company,
            'Resale' => null,
            'address' => $address,
            'seller' => $sellerNames,
            'size' => $size,
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
            if ($designer == 'YES'){
                $message.='user is Designer ' . "<br>";
                $message.='user Company :  ' .$Company . "<br>";
//                $message.='user Resale :  ' .$Resale . "<br>";
                $message.='user Address :  ' .$address . "<br>";
            }
            $message.='Size : '.$size . "<br>";
            $message.='Product Title : '.$postTitle . "<br>";
            $message.='Product Link : '.$postLink . "<br>";

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            if (count($sellers_Emails)){
                foreach ($sellers_Emails as $sellers_Email){
                    wp_mail( $sellers_Email, $subject, $message,$headers);
                }
            }

            wp_send_json( [ 'status' => true, 'message' => 'Mission accomplished successfully .','token'=>idea_csrf_create() ], 200 );
        }else{
            wp_send_json(['status'=>false,'message'=>'Operation failure !'],422);

        }


    }


}

if ( ! function_exists( 'ask_the_seller_table' ) ) :

    function ask_the_seller_table() {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        //* Create the teams table
        $table_name = $wpdb->prefix . 'ask_the_seller';
        $sql        = "CREATE TABLE $table_name (
              id INTEGER NOT NULL AUTO_INCREMENT,
			  name varchar(100) NULL ,
			  family varchar(100)  NULL ,
			  phone varchar(25) NULL ,
			  email varchar(100) NULL ,
			  message text NULL ,
			  designer varchar(5) NULL ,
			  Company varchar(190) NULL ,
			  Resale varchar(190) NULL ,
			  address varchar(190) NULL ,
			  seller varchar(190) NULL ,
			  size varchar(50) NULL ,
			  postTitle varchar(190) NULL ,
			  postLink text NULL ,
			  OperatorDescription text NULL ,
			  seen varchar(50) NULL ,
			  completed varchar(50) NULL ,
			  created_at timestamp default current_timestamp ,
              updated_at timestamp ,
			  PRIMARY KEY (id)
                ) $charset_collate;";
        dbDelta( $sql );


        register_activation_hook( __FILE__, 'ask_the_seller' );
    }
endif; // ask_the_seller_table
add_action( 'after_setup_theme', 'ask_the_seller_table' );



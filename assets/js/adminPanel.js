
let tagArr = document.getElementsByTagName("input");
for (let i = 0; i < tagArr.length; i++) {
    tagArr[i].autocomplete = 'off';
}
$ = jQuery.noConflict();
jQuery(document).ready(function ($) {

    $('#searchProductBox1').on('keyup',function (){
        var title_name=$(this).val();
        $('.box1Items').hide();
        var box1Items=$('.box1Items');
        box1Items.each(function (){
            var title_SearchString= $(this).attr('data-title')
            var title_org= $(this).attr('data-title_org')

            if (title_SearchString.indexOf(title_name) >= 0 || title_org.indexOf(title_name) >= 0 )
            {
                $(this).show();
            }

        })
    })
    $('#searchProductBox2').on('keyup',function (){
        var title_name2=$(this).val();
        $('.box2Items').hide();
        var box1Items2=$('.box2Items');
        box1Items2.each(function (){
            var title_SearchString2= $(this).attr('data-title')
            var title_org2= $(this).attr('data-title_org')

            if (title_SearchString2.indexOf(title_name2) >= 0 || title_org2.indexOf(title_name2) >= 0 )
            {
                $(this).show();
            }

        })
    })
    $('#search_family').on('keyup',function (){
        var title_name=$(this).val();
        $('.box1Items').hide();
        var box1Items=$('.box1Items');
        box1Items.each(function (){
            var title_SearchString= $(this).attr('data-title')
            var title_org= $(this).attr('data-title_org')

            if (title_SearchString.indexOf(title_name) >= 0 || title_org.indexOf(title_name) >= 0 )
            {
                $(this).show();
            }

        })
    })

    //
    // $('#slider_link_show').on('change', function () {
    //     $('#slider_link').val(this.value);
    // });
    //
    // $('#cats').on('change', function () {
    //     $('#slider_link').val(this.value);
    //     $('#slider_link_show').val(this.value);
    // });
















    $('#upload_logo_btn').click(function () {
        media_uploader = wp.media({
            frame:    "post",
            state:    "insert",
            multiple: false
        });
        media_uploader.on("insert", function(){

            var length = media_uploader.state().get("selection").length;
            var images = media_uploader.state().get("selection").models;
            // console.log(images)

            for(var i = 0; i < length; i++){
                var image_url = images[i].changed.url;
                if (image_url === undefined){
                    image_url = images[i].attributes.url;

                }
                $('#image_url').val(image_url);
                $('#img_preview').attr('src',image_url);
            }
        });
        media_uploader.open();

    });
    $('#upload_img_btn').click(function () {

        media_uploader = wp.media({
            frame:    "post",
            state:    "insert",
            multiple: false
        });
        media_uploader.on("insert", function(){

            var length = media_uploader.state().get("selection").length;
            var images = media_uploader.state().get("selection").models;
            // console.log(images)

            for(var i = 0; i < length; i++){
                var image_url = images[i].changed.url;
                if (image_url === undefined){
                    image_url = images[i].attributes.url;

                }
                $('#image_url').val(image_url);
                $('#img_preview').attr('src',image_url);
            }
        });
        media_uploader.open();
        return false;
    });

    $('#upload_img_btn_mobile_slider').click(function () {
        media_uploader = wp.media({
            frame:    "post",
            state:    "insert",
            multiple: false
        });
        media_uploader.on("insert", function(){

            var length = media_uploader.state().get("selection").length;
            var images = media_uploader.state().get("selection").models;
            // console.log(images)

            for(var i = 0; i < length; i++){
                var image_url = images[i].changed.url;
                if (image_url === undefined){
                    image_url = images[i].attributes.url;

                }
                $('#image_url_mobile_slider').val(image_url);
                $('#img_preview_mobile_slider').attr('src',image_url);
            }
        });
        media_uploader.open();

        return false;
    });



    showProductThumbImage();
    jQuery('#sizeSelectSection').on('change',showProductThumbImage);

    jQuery('#AddNewProductComponent').on('click',function (){
        jQuery('#AddNewProductComponentSection').append('<div style="margin: 10px;">\n' +
            '                        <span style="color: red; margin-right: 5px; cursor: pointer" title="delete" onclick="this.parentElement.remove()">x</span>\n' +
            '                        <input type="text" name="mainThemeSettingPage[ProductComponents][]"\n' +
            '                                   value="">\n' +
            '                    </div>');
    });


});
function showRow(id){
    jQuery('.row-shows').hide();
    if (jQuery('#row'+id).hasClass('shoingRowTR')){
        jQuery('#row'+id).removeClass('shoingRowTR');
    }else{
        jQuery('#row'+id).show();
        jQuery('#row'+id).addClass('shoingRowTR');
    }

}
function showProductThumbImage(){
    var sizeSelectSection =jQuery('#sizeSelectSection').find(":selected").val();
    if (sizeSelectSection != undefined){
        if (sizeSelectSection == 'horizontal'){
            jQuery('#post_custom_Horizontal_image').show();
            jQuery('#post_custom_Vertical_image').hide();

        }
        if (sizeSelectSection == 'vertical'){
            jQuery('#post_custom_Horizontal_image').hide();
            jQuery('#post_custom_Vertical_image').show();
        }
        if (sizeSelectSection == 'horizontal-and-vertical'){
            jQuery('#post_custom_Horizontal_image').show();
            jQuery('#post_custom_Vertical_image').show();
        }
    }
}



jQuery(document).ready(function( $ ) {
    $(".product_family").select2();
});
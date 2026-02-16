</main>

<div class="subscribe p-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">
                <div class="text-center">
                    <h4 class="mb-3">Join our mailing list</h4>
                    <p class="mb-3">
                        Get the latest updates on promotions, new products, news and much more.
                    </p>
                </div>

                <div class="container">
                    <?php echo do_shortcode('[mc4wp_form id=1882]'); ?>
                </div>
            </div>
        </div>
    </div>


</div>
<footer class="newfooter">
    <div class="container-fluid p-3 pt-5">
        <div class="row">

            <div class="col-6 col-md-3 col-xl-2 footer_links d-flex flex-column mt-3">
                <span>OUR COMPANY</span>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-one',
                        'container' => 'nav',
                        'container_class' => 'primary-menu-class',
                        'menu_class' => 'menu'
                    ));
                    ?>

            </div>
            <div class="col-6 col-md-3 col-xl-2 footer_links d-flex flex-column mt-3">
                <span>SERVICES</span>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-two',
                        'container' => 'nav',
                        'container_class' => 'primary-menu-class',
                        'menu_class' => 'menu'
                    ));
                    ?>
            </div>
            <div class="col-6 col-md-3 col-xl-2 footer_links d-flex flex-column mt-3">
                <span>LEGAL</span>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-three',
                        'container' => 'nav',
                        'container_class' => 'primary-menu-class',
                        'menu_class' => 'menu'
                    ));
                    ?>
            </div>
            <div class="col-6 col-md-3 col-xl-2 footer_links d-flex flex-column mt-3 last-col-footer">
                <span>CONNECT</span>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-four',
                        'container' => 'nav',
                        'container_class' => 'primary-menu-class',
                        'menu_class' => 'menu'
                    ));
                    ?>

                    
                <?php if ( is_active_sidebar( 'social_network' ) ) : ?>
                    <?php dynamic_sidebar( 'social_network' ); ?>
                <?php endif; ?>


            </div>

            <div class="col-12">
                <div class="copyright col-12 mt-4 p-0">
                    <span>@2024 Palena Furniture Company All rights reserved All content and products on this website are copyrighted and protected by patents</span>
                </div>
            </div>
        </div>


    </div>
</footer>
<script src="<?= esc_url(get_template_directory_uri()); ?>/assets/js/jquery.js"></script>
<script src="<?= esc_url(get_template_directory_uri()); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?= esc_url(get_template_directory_uri()); ?>/assets/js/swiper-bundle.min.js"></script>

<?php
if (is_page(16)) { ?>
    <script>
    jQuery(document).ready(function($) {
    // wishlist product add
    function setHiddenFieldValue() {
        var productNames = [];
        $('.product_name').each(function() {
            var name = $(this).text().trim();
            if (name) {
                productNames.push(name);
            }
        });

        var hiddenField = $('.wishlist-product-list input[name="text-4"]');
        if (hiddenField.length) {
            hiddenField.val(productNames.join(', '));
        }
    }

    $('form').on('submit', function(event) {
        setHiddenFieldValue();
    });

    setTimeout(function() {
        setHiddenFieldValue();
    }, 1000); 
    
});
    </script>
<?php }
?>

<script>
jQuery(document).ready(function($) {
    $('a.wp-block-social-link-anchor').attr('target', '_blank');
    
});




    /*$(document).ready(function () {
        var swiper = new Swiper(".main_slider", {
            slidesPerView: 1,
            loop: true,
            spaceBetween: 30,
            effect: "fade",
            speed: 1600,
            centeredSlides: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
                clickable: true,
            },

        });
    });*/

    var swiper_story_slider = new Swiper(".story_slider", {
        slidesPerView: 1,
        loop: true,
        paginationClickable: true,
        speed: 1600,
        effect: "fade",
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
            clickable: true,
        },

    });

    var swiper_trendingProductsSlider = new Swiper(".trendingProductsSlider", {
        slidesPerView: 2,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
            clickable: true,
        },

        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 15,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 25,
            },
            1360: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },

    });
    var swiper_trendingProductsSlider = new Swiper(".trendingProductsSlider_2", {
        slidesPerView: 2,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: true,
        },
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
            clickable: true,
        },

        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 15,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 25,
            },
            1360: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },

    });
    var gallery_slider = new Swiper(".gallery_slider", {
        slidesPerView: 2,
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
            clickable: true,
        },

        breakpoints: {
            320: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
            576: {
                slidesPerView: 5,
                spaceBetween: 15,
            },
            768: {
                slidesPerView: 6,
                spaceBetween: 20,
            },
            992: {
                slidesPerView: 7,
                spaceBetween: 10,
            },
            1200: {
                slidesPerView: 8,
                spaceBetween: 10,
            },
            1400: {
                slidesPerView: 9,
                spaceBetween: 10,
            },
        },

    });


</script>

<?php
if (is_single()):?>
    <script src="<?= esc_url(get_template_directory_uri()); ?>/assets/js/jquery.fancybox.min.js"></script>

    <script>
        $(document).ready(function() {
            $('[data-fancybox]').each(function() {
                var $this = $(this);
                var caption = $this.find('img').attr('title');
                $this.attr('data-caption', caption);
            });

            $('[data-fancybox]').fancybox({
                caption : function(instance, item) {
                    return $(this).data('caption') || '';
                }
            });
        });
    </script>

    <script>

        // var Gallery_slider_modal = new Swiper(".Gallery_slider_modal", {
        //     slidesPerView:1,
        //     spaceBetween:30,
        //     pagination: {
        //         el: ".swiper-pagination",
        //         clickable: true,
        //     },
        //     navigation: {
        //         nextEl: ".swiper-button-next",
        //         prevEl: ".swiper-button-prev",
        //     },
        //     breakpoints: {
        //         640: {
        //             slidesPerView: 1,
        //             spaceBetween: 20,
        //         },
        //         768: {
        //             slidesPerView: 1,
        //             spaceBetween: 40,
        //         },
        //         1024: {
        //             slidesPerView: 1,
        //             spaceBetween: 50,
        //         },
        //         1360: {
        //             slidesPerView: 1,
        //             spaceBetween: 60,
        //         },
        //     },
        // });
        // $('.galleryItem').on('click',function (){
        //     event.preventDefault();
        //     $('#ModalGallery').modal('show');
        //     $indexCanGo=$(this).attr('data-slide');
        //     $indexCanGo=parseInt($indexCanGo);
        //     Gallery_slider_modal.slideTo($indexCanGo, 1000, false);
        // })

        $('#addToWishListSection').on('click', function () {
            event.preventDefault();
            var P_ID = $(this).attr('data-post');
            var myWishList = getVitaCookie('myWishList');
            if (myWishList != null) {
                var json_str = getVitaCookie('myWishList');
                var arr = JSON.parse(json_str);
                if (jQuery.inArray(P_ID, arr) !== -1) {
                    // delete from array
                    arr = jQuery.grep(arr, function (value) {
                        return value !== P_ID;
                    });
                    var json_str2 = JSON.stringify(arr);
                    setVitaCookie('myWishList', json_str2, 365);
                    $('#inWishList').addClass('d-none');
                    $('#WishListCollectionLink').addClass('d-none');
                    $('#notInWishList').removeClass('d-none');
                } else {
                    arr.push(P_ID);
                    var json_str3 = JSON.stringify(arr);
                    setVitaCookie('myWishList', json_str3, 365);
                    $('#inWishList').removeClass('d-none');
                    $('#WishListCollectionLink').removeClass('d-none');
                    $('#notInWishList').addClass('d-none');
                }
            } else {
                var array = [$(this).attr('data-post')];
                var json_str1 = JSON.stringify(array);
                setVitaCookie('myWishList', json_str1, 365)
                $('#inWishList').removeClass('d-none');
                $('#WishListCollectionLink').removeClass('d-none');
                $('#notInWishList').addClass('d-none');
            }
        })

        function setVitaCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getVitaCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function eraseVitaCookie(name) {
            document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }


    $(document).on('click', function(event) {
        if (!$(event.target).closest('.modal-dialog').length) {
            $('.modal').modal('hide');
        }
    });
    

    </script>





<?php
endif;
wp_footer(); ?>
</body>
</html>

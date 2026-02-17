<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?= esc_url(get_template_directory_uri()); ?>/assets/img/fav_512_Black3.ico"
        type="image/x-icon">
    <link rel="stylesheet" href="<?= esc_url(get_template_directory_uri()); ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= esc_url(get_template_directory_uri()); ?>/assets/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="<?= esc_url(get_template_directory_uri()); ?>/assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="<?= esc_url(get_template_directory_uri()); ?>/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= esc_url(get_template_directory_uri()); ?>/assets/css/palena_style.css?v=1.41">
    <link rel="stylesheet"
        href="<?= esc_url(get_template_directory_uri()); ?>/assets/css/palena_media_query.css?v=1.55">
    <?php if (is_single()): ?>
        <link rel="stylesheet"
            href="<?= esc_url(get_template_directory_uri()); ?>/assets/css/jquery.fancybox.min.css">
    <?php endif; ?>
    <title><?= wp_title() ?></title>
    <?php wp_head(); ?>
    <script src="<?= esc_url(get_template_directory_uri()); ?>/assets/js/jquery.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $('img[title]').each(function() {
                $(this).removeAttr('title');
            });
        });
    </script>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php $mainThemeSettingPage = get_option('mainThemeSettingPage'); ?>
    <header>
        <nav class="main_nav navbar row p-1 m-0 navbar_dark d-flex  align-items-center justify-content-between justify-content-md-start ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <?php wp_nav_menu([
                            'container'      => 'ul',
                            'theme_location' => 'top_menu',
                            'menu_class'     => 'navbar-nav mr-auto'
                        ]); ?>

                    </div>
                </div>
            </div>

        </nav>

    </header>
    <main id="app">
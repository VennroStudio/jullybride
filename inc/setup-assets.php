<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', 'jullybride_setup');
function jullybride_setup(): void
{
    load_theme_textdomain('jullybride', JULLYBRIDE_THEME_DIR . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus([
        'primary' => __('Главное меню', 'jullybride'),
        'mobile' => __('Мобильное меню', 'jullybride'),
        'footer' => __('Меню в футере', 'jullybride'),
        'legal' => __('Юридические ссылки', 'jullybride'),
    ]);

    add_image_size('jullybride-card', 620, 860, true);
    add_image_size('jullybride-wide', 1440, 760, true);
    add_image_size('product_detail', 573, 860, true);
    add_image_size('blog_carousel', 456, 300, true);
    add_image_size('carousel-story', 350, 630, true);
    add_image_size('gallery-couture', 960, 1080, true);
}

add_action('wp_enqueue_scripts', 'jullybride_enqueue_assets');
function jullybride_enqueue_assets(): void
{
    $styles = [
        'jullybride-legacy-swiper' => '/assets/css/legacy/swiper-bundle.min.css',
        'jullybride-legacy-owl' => '/assets/css/legacy/owl.carousel.min.css',
        'jullybride-legacy-owl-theme' => '/assets/css/legacy/owl.theme.default.min.css',
        'jullybride-legacy-animate' => '/assets/css/legacy/animate.min.css',
        'jullybride-legacy-app' => '/assets/css/legacy/app.min.css',
        'jullybride-main' => '/assets/css/main.css',
    ];

    foreach ($styles as $handle => $relative_path) {
        $path = JULLYBRIDE_THEME_DIR . $relative_path;
        if (file_exists($path)) {
            wp_enqueue_style($handle, JULLYBRIDE_THEME_URI . $relative_path, [], filemtime($path));
        }
    }

    wp_enqueue_script('jquery');

    $scripts = [
        'jullybride-legacy-owl' => '/assets/js/legacy/owl.carousel.min.js',
        'jullybride-similar-products' => '/assets/js/legacy/similar-products.js',
        'jullybride-legacy-swiper' => '/assets/js/legacy/swiper-bundle.min.js',
        'jullybride-legacy-wow' => '/assets/js/legacy/wow.min.js',
        'jullybride-legacy-app' => '/assets/js/legacy/app.min.js',
        'jullybride-main' => '/assets/js/main.js',
    ];

    foreach ($scripts as $handle => $relative_path) {
        $path = JULLYBRIDE_THEME_DIR . $relative_path;
        if (file_exists($path)) {
            wp_enqueue_script($handle, JULLYBRIDE_THEME_URI . $relative_path, ['jquery'], filemtime($path), true);
        }
    }

    if (wp_script_is('jullybride-legacy-app', 'enqueued')) {
        wp_add_inline_script('jullybride-legacy-app', 'window.Fancybox=window.Fancybox||{bind:function(){}};', 'before');
    }

    wp_localize_script('jullybride-main', 'jullybrideTheme', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'homeUrl' => home_url('/'),
    ]);
}

add_filter('acf/settings/save_json', 'jullybride_acf_json_save_point');
function jullybride_acf_json_save_point(string $path): string
{
    return JULLYBRIDE_THEME_DIR . '/acf-json';
}

add_filter('acf/settings/load_json', 'jullybride_acf_json_load_point');
function jullybride_acf_json_load_point(array $paths): array
{
    $paths[] = JULLYBRIDE_THEME_DIR . '/acf-json';
    return $paths;
}

add_action('acf/init', 'jullybride_register_acf_options');
function jullybride_register_acf_options(): void
{
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => 'JullyBride: настройки сайта',
        'menu_title' => 'JullyBride',
        'menu_slug' => 'jullybride-options',
        'capability' => 'edit_posts',
        'redirect' => true,
        'position' => 58,
    ]);

    foreach ([
        'header' => 'Шапка',
        'footer' => 'Футер',
        'stories' => 'Истории',
    ] as $slug => $title) {
        acf_add_options_sub_page([
            'page_title' => 'JullyBride: ' . $title,
            'menu_title' => $title,
            'parent_slug' => 'jullybride-options',
            'menu_slug' => 'jullybride-options-' . $slug,
        ]);
    }
}

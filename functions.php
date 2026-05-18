<?php
/**
 * JullyBride theme bootstrap.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('JULLYBRIDE_THEME_VERSION', '0.1.0');
define('JULLYBRIDE_THEME_DIR', get_template_directory());
define('JULLYBRIDE_THEME_URI', get_template_directory_uri());

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
        'contacts' => 'Контакты',
        'socials' => 'Соцсети',
        'catalog' => 'Каталог',
    ] as $slug => $title) {
        acf_add_options_sub_page([
            'page_title' => 'JullyBride: ' . $title,
            'menu_title' => $title,
            'parent_slug' => 'jullybride-options',
            'menu_slug' => 'jullybride-options-' . $slug,
        ]);
    }
}

function jullybride_template_part(string $slug, array $args = []): void
{
    get_template_part('template-block/' . $slug, null, $args);
}

function jullybride_nav_menu(string $location, array $args = []): void
{
    $fallback_menus = [
        'primary' => 'glavnoe-menyu',
        'mobile' => 'glavnoe-menyu',
        'footer' => 'info-menyu',
        'legal' => 'info-menyu',
    ];

    $defaults = [
        'theme_location' => $location,
        'container' => false,
        'fallback_cb' => '__return_empty_string',
    ];

    if (!has_nav_menu($location) && isset($fallback_menus[$location])) {
        unset($defaults['theme_location']);
        $defaults['menu'] = $fallback_menus[$location];
    }

    wp_nav_menu(array_merge($defaults, $args));
}

function jullybride_option(string $field, mixed $fallback = ''): mixed
{
    if (function_exists('get_field')) {
        $value = get_field($field, 'option');
        if ($value !== null && $value !== false && $value !== '') {
            return $value;
        }
    }

    return $fallback;
}

function jullybride_asset_uri(string $path = ''): string
{
    return JULLYBRIDE_THEME_URI . '/assets/' . ltrim($path, '/');
}

function jullybride_render_flexible(string $field_name, string $block_group, int|string|null $post_id = null): bool
{
    if (!function_exists('have_rows') || !have_rows($field_name, $post_id)) {
        return false;
    }

    while (have_rows($field_name, $post_id)) {
        the_row();
        $layout = sanitize_title(get_row_layout());
        jullybride_template_part($block_group . '/' . $layout, [
            'layout' => $layout,
            'field_name' => $field_name,
            'post_id' => $post_id,
        ]);
    }

    return true;
}

function jullybride_breadcrumbs(): void
{
    jullybride_template_part('common/breadcrumbs');
}

function jullybride_logo_url(string $variant = 'dark'): string
{
    $file = $variant === 'light' ? 'jullybride_logo_white_clear.png' : 'jullybride_logo_clear.png';

    return jullybride_asset_uri('images/' . $file);
}

function jullybride_primary_nav_items(): array
{
    $items = require JULLYBRIDE_THEME_DIR . '/template-block/header/menu-data.php';

    return is_array($items) ? $items : [];
}

function jullybride_nav_item_groups(array $item): array
{
    if (!empty($item['mega']) && is_array($item['mega'])) {
        return $item['mega'];
    }

    if (!empty($item['children']) && is_array($item['children'])) {
        return [['title' => '', 'items' => $item['children']]];
    }

    return [];
}

function jullybride_footer_columns(): array
{
    return [
        [
            'title' => 'Свадебные платья',
            'items' => [
                ['label' => 'Пышные', 'url' => home_url('/c/wedding/lush/')],
                ['label' => 'Костюмы и комбинезоны', 'url' => home_url('/c/wedding/suits/')],
                ['label' => 'Длинные', 'url' => home_url('/c/wedding/long/')],
                ['label' => 'А-силуэт', 'url' => home_url('/c/wedding/a-line/')],
                ['label' => 'Короткие', 'url' => home_url('/c/wedding/mini/')],
                ['label' => 'В стиле бохо', 'url' => home_url('/c/wedding/boho/')],
                ['label' => 'Кружевные', 'url' => home_url('/c/wedding/lace/')],
                ['label' => 'Простые', 'url' => home_url('/c/wedding/simple/')],
                ['label' => 'Миди', 'url' => home_url('/c/wedding/midi/')],
                ['label' => 'С корсетом', 'url' => home_url('/c/wedding/corset/')],
                ['label' => 'Закрытые', 'url' => home_url('/c/wedding/shoulders-closed/')],
                ['label' => 'Трансформеры', 'url' => home_url('/c/wedding/transformers/')],
            ],
        ],
        [
            'title' => 'Вечерние платья',
            'items' => [
                ['label' => 'Коктейльные', 'url' => home_url('/c/evening/cocktail_/')],
                ['label' => 'Недорогие', 'url' => home_url('/c/evening/?_price%7Cbetween=0-39000&_f=1')],
                ['label' => 'Красные', 'url' => home_url('/c/evening/red_/')],
                ['label' => 'Черные', 'url' => home_url('/c/evening/black_/')],
                ['label' => 'Миди', 'url' => home_url('/c/evening/midi_/')],
                ['label' => 'В пол', 'url' => home_url('/c/evening/long_/')],
                ['label' => 'Мини', 'url' => home_url('/c/evening/mini_/')],
                ['label' => 'Пышные', 'url' => home_url('/c/evening/lush_/')],
            ],
        ],
        [
            'title' => 'О салоне',
            'items' => [
                ['label' => 'Контакты', 'url' => home_url('/contacts/')],
                ['label' => 'О компании', 'url' => home_url('/o-kompanii/')],
                ['label' => 'Секретная папка', 'url' => home_url('/blog/')],
                ['label' => 'Избранное', 'url' => home_url('/wishlist/')],
                ['label' => 'Акции и скидки', 'url' => home_url('/promo/')],
            ],
        ],
    ];
}

function jullybride_legal_links(): array
{
    return [
        ['label' => 'Политика конфиденциальности и документы', 'url' => home_url('/policy/')],
        ['label' => 'Политика обработки файлов cookie', 'url' => home_url('/cookie/')],
        ['label' => 'Публичная оферта', 'url' => home_url('/oferta/')],
        ['label' => 'Политика обработки данных', 'url' => home_url('/obrabotka/')],
        ['label' => 'Согласие на обработку персональных данных', 'url' => home_url('/soglasie/')],
        ['label' => 'Согласие на получение информационной и рекламной рассылки', 'url' => home_url('/rassylka/')],
    ];
}

function jullybride_social_links(): array
{
    $links = jullybride_option('social_links');

    if (is_array($links) && $links) {
        return $links;
    }

    return [
        ['label' => 'Telegram', 'url' => 'https://t.me/jullybridesalon', 'icon' => 'link-telegram.svg'],
        ['label' => 'WhatsApp', 'url' => 'https://wa.me/79119291699?text=Здравствуйте! Запишите меня на примерку', 'icon' => 'whatsapp-handdrawn-1.svg'],
        ['label' => 'VK', 'url' => 'https://vk.com/jullybride', 'icon' => 'link-vkontakte.svg'],
        ['label' => 'Instagram', 'url' => 'https://instagram.com/jullybride', 'icon' => 'link-instagram.svg'],
        ['label' => 'YouTube', 'url' => 'https://www.youtube.com/channel/UCo_Zo2x9fyN19uuxkWO_v-g', 'icon' => 'link-youtube.svg'],
    ];
}

function jullybride_catalog_page_id(): int
{
    $page = get_page_by_path('c');
    return $page instanceof WP_Post ? (int) $page->ID : 0;
}

function jullybride_stock_archive_url(): string
{
    $page = get_page_by_path('promo');
    return $page instanceof WP_Post ? get_permalink($page) : home_url('/promo/');
}

function jullybride_get_main_product_category(int $product_id): ?WP_Term
{
    $terms = get_the_terms($product_id, 'product_cat');

    if (!$terms || is_wp_error($terms)) {
        return null;
    }

    usort($terms, static fn (WP_Term $a, WP_Term $b): int => $a->parent <=> $b->parent ?: $a->name <=> $b->name);

    return $terms[0] ?? null;
}

function jullybride_product_image_ids(WC_Product $product): array
{
    $main_image_id = $product->get_image_id();
    $gallery_ids = $product->get_gallery_image_ids();

    return array_values(array_filter(array_merge(
        $main_image_id ? [$main_image_id] : [],
        $gallery_ids ?: []
    )));
}

function jullybride_format_price(int|float|string|null $price): string
{
    if ($price === null || $price === '') {
        return '';
    }

    return number_format((float) $price, 0, ',', ' ') . '₽';
}

function jullybride_product_type_label(int $product_id): string
{
    return function_exists('get_field') ? (string) get_field('tip_tovara', $product_id) : '';
}

function jullybride_clean_builder_content(string $content): string
{
    $content = preg_replace('/\[\/?(?:vc|us)_[a-z0-9_-]+[^\]]*\]/i', '', $content) ?? $content;
    $content = preg_replace('/\[\/?vc_[^\]]*\]/i', '', $content) ?? $content;

    return trim($content);
}

function jullybride_render_clean_post_content(int|string|null $post_id = null): string
{
    $post = get_post($post_id ?: get_the_ID());

    if (!$post instanceof WP_Post) {
        return '';
    }

    $content = jullybride_clean_builder_content((string) $post->post_content);

    return apply_filters('the_content', $content);
}

function jullybride_home_source_id(): int
{
    $front_page_id = (int) get_option('page_on_front');

    if ($front_page_id > 0 && get_post($front_page_id) instanceof WP_Post) {
        return $front_page_id;
    }

    $legacy_home_id = 59177;
    if (get_post($legacy_home_id) instanceof WP_Post) {
        return $legacy_home_id;
    }

    return 0;
}

function jullybride_home_story_context(): array
{
    return [
        'post_id' => jullybride_home_source_id(),
        'field' => 'carusel-added-owl',
    ];
}

function jullybride_available_variation_parent_ids(): array
{
    global $wpdb;

    $ids = $wpdb->get_col(
        "SELECT DISTINCT p.post_parent
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID AND pm.meta_key = '_stock_status'
        WHERE p.post_type = 'product_variation'
            AND p.post_status = 'publish'
            AND p.post_parent > 0
            AND pm.meta_value = 'instock'"
    );

    return array_map('absint', $ids ?: []);
}

function jullybride_attribute_taxonomy_table_exists(): bool
{
    global $wpdb;
    static $exists = null;

    if ($exists !== null) {
        return $exists;
    }

    $table = $wpdb->prefix . 'woocommerce_attribute_taxonomies';
    $exists = $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table)) === $table;

    return $exists;
}

function jullybride_catalog_query_args(): array
{
    $paged = max(1, absint(get_query_var('paged')), absint(get_query_var('page')));
    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => (int) apply_filters('jullybride_catalog_per_page', 24),
        'paged' => $paged,
        'tax_query' => [],
        'meta_query' => [],
    ];

    if (is_product_category()) {
        $term = get_queried_object();
        if ($term instanceof WP_Term) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => [$term->term_id],
            ];
        }
    }

    foreach ($_GET as $key => $value) {
        if (!str_starts_with((string) $key, 'filter_pa_')) {
            continue;
        }

        $attribute_name = sanitize_title(substr((string) $key, strlen('filter_')));
        $taxonomy = wc_attribute_taxonomy_name(str_replace('pa_', '', $attribute_name));
        $slugs = array_filter(array_map('sanitize_title', explode(',', (string) wp_unslash($value))));

        if (taxonomy_exists($taxonomy) && $slugs) {
            $args['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $slugs,
                'operator' => 'IN',
            ];
        }
    }

    if (!empty($_GET['jb_in_stock'])) {
        $variable_ids = jullybride_available_variation_parent_ids();
        $simple_ids = wc_get_products([
            'status' => 'publish',
            'stock_status' => 'instock',
            'type' => ['simple', 'external'],
            'limit' => -1,
            'return' => 'ids',
        ]);
        $in_stock_ids = array_values(array_unique(array_merge($variable_ids, array_map('absint', $simple_ids))));
        $args['post__in'] = $in_stock_ids ?: [0];
    }

    if (count($args['tax_query']) > 1) {
        $args['tax_query']['relation'] = 'AND';
    }

    $orderby = isset($_GET['orderby']) ? sanitize_key(wp_unslash($_GET['orderby'])) : '';
    if ($orderby === 'price') {
        $args['meta_key'] = '_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'ASC';
    } elseif ($orderby === 'price-desc') {
        $args['meta_key'] = '_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
    } elseif ($orderby === 'date') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } else {
        $args['orderby'] = ['menu_order' => 'ASC', 'date' => 'DESC'];
    }

    return $args;
}

function jullybride_product_available_sizes(int $product_id): array
{
    $product = wc_get_product($product_id);

    if (!$product) {
        return [];
    }

    if (!$product->is_type('variable')) {
        return $product->is_in_stock() ? ['В наличии'] : [];
    }

    $sizes = [];
    foreach ($product->get_children() as $variation_id) {
        $variation = wc_get_product($variation_id);
        if (!$variation || !$variation->is_in_stock()) {
            continue;
        }

        foreach ($variation->get_attributes() as $taxonomy => $slug) {
            if (!$slug) {
                continue;
            }

            $term = taxonomy_exists($taxonomy) ? get_term_by('slug', $slug, $taxonomy) : null;
            $sizes[] = $term instanceof WP_Term ? $term->name : (string) $slug;
        }
    }

    return array_values(array_unique(array_filter($sizes)));
}

add_action('template_redirect', 'jullybride_track_recently_viewed_products', 20);
function jullybride_track_recently_viewed_products(): void
{
    if (!function_exists('wc_setcookie') || !is_singular('product')) {
        return;
    }

    $product_id = get_queried_object_id();
    $viewed = empty($_COOKIE['woocommerce_recently_viewed'])
        ? []
        : wp_parse_id_list(explode('|', wp_unslash((string) $_COOKIE['woocommerce_recently_viewed'])));

    $viewed = array_values(array_diff($viewed, [$product_id]));
    $viewed[] = $product_id;

    if (count($viewed) > 15) {
        array_shift($viewed);
    }

    wc_setcookie('woocommerce_recently_viewed', implode('|', $viewed));
}

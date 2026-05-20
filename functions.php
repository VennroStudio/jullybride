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

require_once JULLYBRIDE_THEME_DIR . '/inc/post-types.php';

add_action('init', 'jullybride_register_catalog_rewrite_rules');
function jullybride_register_catalog_rewrite_rules(): void
{
    add_rewrite_rule(
        '^c/([^/]+)/([^/]+)/?$',
        'index.php?product_cat=$matches[1]&pa_silhouette=$matches[2]',
        'top'
    );
}

add_filter('query_vars', 'jullybride_register_catalog_filter_query_vars');
function jullybride_register_catalog_filter_query_vars(array $vars): array
{
    foreach (jullybride_catalog_filter_definitions() as $definition) {
        foreach (jullybride_catalog_definition_params($definition) as $param) {
            $vars[] = $param;
        }
    }

    return array_values(array_unique($vars));
}

add_action('wp', 'jullybride_sync_catalog_filter_query_vars_to_get');
function jullybride_sync_catalog_filter_query_vars_to_get(): void
{
    if (is_admin() || !jullybride_catalog_is_catalog_request_path()) {
        return;
    }

    foreach (jullybride_catalog_filter_param_names() as $param) {
        if (isset($_GET[$param]) && $_GET[$param] !== '') {
            continue;
        }

        $value = get_query_var($param);
        if ($value !== '') {
            $_GET[$param] = $value;
        }
    }
}

add_filter('wpseo_breadcrumb_links', 'jullybride_add_catalog_filters_to_yoast_breadcrumbs');
function jullybride_add_catalog_filters_to_yoast_breadcrumbs(array $links): array
{
    foreach (jullybride_catalog_active_filter_breadcrumb_items() as $item) {
        $links[] = [
            'text' => $item['label'],
        ];
    }

    return $links;
}

add_filter('woocommerce_get_breadcrumb', 'jullybride_add_catalog_filters_to_woocommerce_breadcrumbs');
function jullybride_add_catalog_filters_to_woocommerce_breadcrumbs(array $crumbs): array
{
    foreach (jullybride_catalog_active_filter_breadcrumb_items() as $item) {
        $crumbs[] = [$item['label'], ''];
    }

    return $crumbs;
}

add_filter('wpseo_title', 'jullybride_catalog_filter_yoast_title');
function jullybride_catalog_filter_yoast_title(string $title): string
{
    $term = jullybride_catalog_primary_active_filter_term();
    if (!$term instanceof WP_Term) {
        return $title;
    }

    $term_title = jullybride_catalog_filter_term_yoast_value($term, 'title');
    if ($term_title === '') {
        return $title;
    }

    return function_exists('wpseo_replace_vars') ? wpseo_replace_vars($term_title, $term) : $term_title;
}

add_filter('wpseo_metadesc', 'jullybride_catalog_filter_yoast_description');
function jullybride_catalog_filter_yoast_description(string $description): string
{
    $term = jullybride_catalog_primary_active_filter_term();
    if (!$term instanceof WP_Term) {
        return $description;
    }

    $term_description = jullybride_catalog_filter_term_yoast_value($term, 'desc');
    if ($term_description === '') {
        return $description;
    }

    return function_exists('wpseo_replace_vars') ? wpseo_replace_vars($term_description, $term) : $term_description;
}

add_filter('wpseo_opengraph_title', 'jullybride_catalog_filter_yoast_og_title');
function jullybride_catalog_filter_yoast_og_title(string $title): string
{
    $term = jullybride_catalog_primary_active_filter_term();
    if (!$term instanceof WP_Term) {
        return $title;
    }

    $term_title = jullybride_catalog_filter_term_yoast_value($term, 'opengraph-title');
    if ($term_title === '') {
        $term_title = jullybride_catalog_filter_term_yoast_value($term, 'title');
    }

    if ($term_title === '') {
        return $title;
    }

    return function_exists('wpseo_replace_vars') ? wpseo_replace_vars($term_title, $term) : $term_title;
}

add_filter('wpseo_opengraph_desc', 'jullybride_catalog_filter_yoast_og_description');
function jullybride_catalog_filter_yoast_og_description(string $description): string
{
    $term = jullybride_catalog_primary_active_filter_term();
    if (!$term instanceof WP_Term) {
        return $description;
    }

    $term_description = jullybride_catalog_filter_term_yoast_value($term, 'opengraph-description');
    if ($term_description === '') {
        $term_description = jullybride_catalog_filter_term_yoast_value($term, 'desc');
    }

    if ($term_description === '') {
        return $description;
    }

    return function_exists('wpseo_replace_vars') ? wpseo_replace_vars($term_description, $term) : $term_description;
}

add_filter('wpseo_opengraph_url', 'jullybride_catalog_filter_yoast_og_url');
function jullybride_catalog_filter_yoast_og_url(string $url): string
{
    if (!(jullybride_catalog_primary_active_filter_term() instanceof WP_Term)) {
        return $url;
    }

    return jullybride_catalog_current_url();
}

add_filter('wpseo_opengraph_image', 'jullybride_catalog_filter_yoast_og_image');
function jullybride_catalog_filter_yoast_og_image(string $image): string
{
    $term = jullybride_catalog_primary_active_filter_term();
    if (!$term instanceof WP_Term) {
        return $image;
    }

    $term_image = jullybride_catalog_filter_term_yoast_value($term, 'opengraph-image');

    return $term_image !== '' ? $term_image : $image;
}

add_filter('wpseo_canonical', 'jullybride_catalog_filter_yoast_canonical');
function jullybride_catalog_filter_yoast_canonical(string $canonical): string
{
    if (!(jullybride_catalog_primary_active_filter_term() instanceof WP_Term)) {
        return $canonical;
    }

    return jullybride_catalog_current_url();
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

function jullybride_url(string $url, string $fallback = ''): string
{
    $url = trim($url);

    if ($url === '') {
        return $fallback;
    }

    if (str_starts_with($url, '/')) {
        return home_url($url);
    }

    return $url;
}

function jullybride_header_logo(): array
{
    $logo = jullybride_option('header_logo');

    if (is_array($logo) && !empty($logo['url'])) {
        return [
            'url' => (string) $logo['url'],
            'alt' => (string) ($logo['alt'] ?? get_bloginfo('name')),
        ];
    }

    return [
        'url' => jullybride_logo_url('dark'),
        'alt' => get_bloginfo('name'),
    ];
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
    $columns = [];

    foreach (jullybride_footer_menu_definitions() as $definition) {
        $items = jullybride_footer_menu_items($definition['field']);

        if (!$items) {
            continue;
        }

        $columns[] = [
            'title' => $definition['title'],
            'field' => $definition['field'],
            'items' => $items,
        ];
    }

    return $columns;
}

function jullybride_footer_menu_definitions(): array
{
    return [
        ['title' => 'Свадебные тренды 2026', 'field' => 'footer_menu_trends'],
        ['title' => 'Материал', 'field' => 'footer_menu_material'],
        ['title' => 'Силуэт', 'field' => 'footer_menu_silhouette'],
        ['title' => 'Стиль', 'field' => 'footer_menu_style'],
        ['title' => 'Дизайнеры и бренды', 'field' => 'footer_menu_designers'],
        ['title' => '', 'field' => 'footer_menu_info'],
    ];
}

function jullybride_footer_menu_items(string $field): array
{
    return jullybride_nav_menu_items_from_value(jullybride_option($field));
}

function jullybride_nav_menu_items_from_value(mixed $menu_value): array
{
    $menu = jullybride_get_nav_menu_object($menu_value);

    if (!$menu) {
        return [];
    }

    $items = wp_get_nav_menu_items($menu->term_id, [
        'update_post_term_cache' => false,
    ]);

    if (!$items || is_wp_error($items)) {
        return [];
    }

    $children_by_parent = [];
    foreach ($items as $item) {
        $children_by_parent[(int) $item->menu_item_parent][] = $item;
    }

    $format_items = static function (array $menu_items) use (&$format_items, $children_by_parent): array {
        $formatted = [];

        foreach ($menu_items as $item) {
            $menu_item = jullybride_format_nav_menu_item($item);
            $children = $children_by_parent[(int) $item->ID] ?? [];

            if ($children) {
                $menu_item['children'] = $format_items($children);
            }

            $formatted[] = $menu_item;
        }

        return $formatted;
    };

    return $format_items($children_by_parent[0] ?? []);
}

function jullybride_get_nav_menu_object(mixed $menu_value): ?WP_Term
{
    if ($menu_value instanceof WP_Term) {
        return $menu_value;
    }

    if (is_array($menu_value)) {
        $menu_value = $menu_value['term_id'] ?? $menu_value['ID'] ?? $menu_value['slug'] ?? '';
    }

    if ($menu_value === '' || $menu_value === null) {
        return null;
    }

    $menu = wp_get_nav_menu_object($menu_value);

    return $menu instanceof WP_Term ? $menu : null;
}

function jullybride_format_nav_menu_item(WP_Post $item): array
{
    return [
        'label' => html_entity_decode($item->title, ENT_QUOTES, get_bloginfo('charset')),
        'url' => jullybride_url((string) $item->url, '#'),
    ];
}

function jullybride_footer_products(): array
{
    $selected_products = jullybride_option('footer_products', []);

    if (!$selected_products) {
        return [];
    }

    if (!is_array($selected_products)) {
        $selected_products = [$selected_products];
    }

    $products = [];

    foreach ($selected_products as $selected_product) {
        $product_id = $selected_product instanceof WP_Post ? (int) $selected_product->ID : (int) $selected_product;

        if (!$product_id || !function_exists('wc_get_product')) {
            continue;
        }

        $product = wc_get_product($product_id);

        if (!$product) {
            continue;
        }

        $image_id = (int) $product->get_image_id();
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium_large') : '';

        if (!$image_url && function_exists('wc_placeholder_img_src')) {
            $image_url = wc_placeholder_img_src('medium_large');
        }

        $products[] = [
            'id' => $product_id,
            'title' => $product->get_name(),
            'url' => get_permalink($product_id),
            'image' => $image_url,
            'price' => jullybride_format_price($product->get_price()),
            'type' => jullybride_product_type_label($product_id),
        ];

        if (count($products) === 3) {
            break;
        }
    }

    return $products;
}

function jullybride_legal_links(string $group = ''): array
{
    if ($group === 'left') {
        return jullybride_format_footer_legal_links(jullybride_option('footer_legal_links_left', []));
    }

    if ($group === 'right') {
        return jullybride_format_footer_legal_links(jullybride_option('footer_legal_links_right', []));
    }

    $left_links = jullybride_legal_links('left');
    $right_links = jullybride_legal_links('right');

    if ($left_links || $right_links) {
        return array_merge($left_links, $right_links);
    }

    return jullybride_format_footer_legal_links(jullybride_option('footer_legal_links', []));
}

function jullybride_format_footer_legal_links(mixed $links): array
{
    if (!is_array($links)) {
        return [];
    }

    return array_values(array_filter(array_map(static function (mixed $link): ?array {
        if (!is_array($link)) {
            return null;
        }

        $label = trim((string) ($link['label'] ?? ''));
        $url = trim((string) ($link['url'] ?? ''));

        if ($label === '' || $url === '') {
            return null;
        }

        return [
            'label' => $label,
            'url' => jullybride_url($url, '#'),
        ];
    }, $links)));
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

    $priority = [
        'wedding',
        'evening',
        'shoes',
        'veils',
        'jewelry',
        'outerwear',
        'morning',
        'pink-merch',
        'accessories',
        'cosmetics',
        'uncategorized',
        'sale',
        'tariffs',
    ];

    foreach ($priority as $slug) {
        foreach ($terms as $term) {
            if ($term instanceof WP_Term && $term->slug === $slug) {
                return $term;
            }
        }
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

function jullybride_catalog_current_product_category(): ?WP_Term
{
    $override_id = absint($GLOBALS['jullybride_catalog_filter_category_id'] ?? 0);

    if ($override_id > 0) {
        $term = get_term($override_id, 'product_cat');
        if ($term instanceof WP_Term && !is_wp_error($term)) {
            return $term;
        }
    }

    if (!is_product_category()) {
        return null;
    }

    $term = get_queried_object();

    return $term instanceof WP_Term ? $term : null;
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

function jullybride_catalog_filter_definitions(): array
{
    return [
        ['param' => 'pa_razmer', 'taxonomies' => ['pa_razmer'], 'label' => 'Размер', 'aliases' => ['filter_pa_razmer']],
        ['param' => 'pa_silhouette', 'taxonomies' => ['pa_silhouette', 'silhouette'], 'label' => 'Силуэт', 'aliases' => ['_silhouette', 'filter_pa_silhouette']],
        ['param' => 'pa_style', 'taxonomies' => ['pa_style', 'style'], 'label' => 'Стиль', 'aliases' => ['_style', 'filter_pa_style']],
        ['param' => 'pa_length', 'taxonomies' => ['pa_length', 'length'], 'label' => 'Длина', 'aliases' => ['_length', 'filter_pa_length']],
        ['param' => 'pa_designer', 'taxonomies' => ['pa_designer', 'designer'], 'label' => 'Дизайнер / бренд', 'aliases' => ['_designer', 'filter_pa_designer']],
        ['param' => 'pa_shoulders', 'taxonomies' => ['pa_shoulders', 'shoulders'], 'label' => 'Плечи', 'aliases' => ['_shoulders', 'filter_pa_shoulders']],
        ['param' => 'pa_sleeves', 'taxonomies' => ['pa_sleeves', 'sleeves'], 'label' => 'Рукава', 'aliases' => ['_sleeves', 'filter_pa_sleeves']],
        ['param' => 'pa_backdress', 'taxonomies' => ['pa_backdress', 'backdress'], 'label' => 'Спина', 'aliases' => ['_backdress', 'filter_pa_backdress']],
        ['param' => 'pa_decollete', 'taxonomies' => ['pa_decollete', 'decollete'], 'label' => 'Декольте', 'aliases' => ['_decollete', 'filter_pa_decollete']],
        ['param' => 'pa_material', 'taxonomies' => ['pa_material', 'material'], 'label' => 'Материал', 'aliases' => ['_material', 'filter_pa_material']],
        ['param' => 'pa_season', 'taxonomies' => ['pa_season', 'season'], 'label' => 'Сезон', 'aliases' => ['_season', 'filter_pa_season']],
        ['param' => 'pa_corset', 'taxonomies' => ['pa_corset', 'corset'], 'label' => 'Корсет', 'aliases' => ['_corset', 'filter_pa_corset']],
        ['param' => 'pa_collection', 'taxonomies' => ['pa_collection', 'collection'], 'label' => 'Коллекция', 'aliases' => ['_collection', 'filter_pa_collection']],
        ['param' => 'pa_slit', 'taxonomies' => ['pa_slit', 'slit'], 'label' => 'Разрез', 'aliases' => ['_slit', 'filter_pa_slit']],
        ['param' => 'pa_where', 'taxonomies' => ['pa_where', 'where'], 'label' => 'Куда', 'aliases' => ['_where', 'filter_pa_where']],
        ['param' => 'pa_color', 'taxonomies' => ['pa_color', 'pa_czvet', 'color'], 'label' => 'Цвет', 'aliases' => ['_color', 'filter_pa_color', 'filter_pa_czvet']],
        ['param' => 'pa_train', 'taxonomies' => ['pa_train', 'train'], 'label' => 'Шлейф', 'aliases' => ['_train', 'filter_pa_train']],
        ['param' => 'pa_straps', 'taxonomies' => ['pa_straps', 'straps'], 'label' => 'Бретельки', 'aliases' => ['_straps', 'filter_pa_straps']],
        ['param' => 'pa_details', 'taxonomies' => ['pa_details', 'details'], 'label' => 'Детали', 'aliases' => ['_details', 'filter_pa_details']],
        ['param' => 'pa_heel', 'taxonomies' => ['pa_heel', 'heel'], 'label' => 'Каблук', 'aliases' => ['_heel', 'filter_pa_heel']],
    ];
}

function jullybride_catalog_definition_params(array $definition): array
{
    $params = [(string) ($definition['param'] ?? '')];

    foreach ((array) ($definition['aliases'] ?? []) as $alias) {
        $params[] = (string) $alias;
    }

    return array_values(array_unique(array_filter($params)));
}

function jullybride_catalog_filter_param_names(): array
{
    static $params = null;

    if ($params !== null) {
        return $params;
    }

    $params = [
        'jb_in_stock',
        'filter_pa_razmer',
        '_price',
    ];

    foreach (jullybride_catalog_filter_definitions() as $definition) {
        $params = array_merge($params, jullybride_catalog_definition_params($definition));
    }

    $params = array_values(array_unique(array_filter($params)));

    return $params;
}

function jullybride_catalog_has_filter_request_params(): bool
{
    foreach (jullybride_catalog_filter_param_names() as $param) {
        if (isset($_GET[$param]) && $_GET[$param] !== '') {
            return true;
        }
    }

    return false;
}

function jullybride_catalog_is_catalog_request_path(): bool
{
    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = (string) wp_parse_url($request_uri, PHP_URL_PATH);
    $path = trim($path, '/');

    $home_path = trim((string) wp_parse_url(home_url('/'), PHP_URL_PATH), '/');
    if ($home_path !== '' && ($path === $home_path || str_starts_with($path, $home_path . '/'))) {
        $path = trim(substr($path, strlen($home_path)), '/');
    }

    return $path === 'c' || str_starts_with($path, 'c/');
}

add_filter('wpc_query_vars', 'jullybride_catalog_bypass_filter_everything_query_vars', 1);
function jullybride_catalog_bypass_filter_everything_query_vars(array $query_vars): array
{
    if (is_admin() || wp_doing_ajax()) {
        return $query_vars;
    }

    if (!jullybride_catalog_is_catalog_request_path() || !jullybride_catalog_has_filter_request_params()) {
        return $query_vars;
    }

    $query_vars['queried_values'] = [];
    $query_vars['segments_order'] = [];
    $query_vars['wpc_logic_separators'] = [];
    $query_vars['non_filter_segments'] = [];
    $query_vars['error'] = '';

    return $query_vars;
}

function jullybride_catalog_request_values(string $param): array
{
    if (!isset($_GET[$param])) {
        return [];
    }

    $value = wp_unslash($_GET[$param]);
    $values = is_array($value) ? $value : explode(',', (string) $value);
    $values = array_map('jullybride_catalog_sanitize_slug_value', $values);
    $values = array_filter($values);

    return array_values(array_unique($values));
}

function jullybride_catalog_sanitize_slug_value($value): string
{
    if (is_array($value)) {
        $value = reset($value);
    }

    $value = trim(wp_strip_all_tags((string) $value));
    if ($value === '') {
        return '';
    }

    return sanitize_title_with_dashes(rawurldecode($value), '', 'save');
}

function jullybride_catalog_request_values_for_definition(array $definition): array
{
    $values = [];

    foreach (jullybride_catalog_definition_params($definition) as $param) {
        $values = array_merge($values, jullybride_catalog_request_values($param));
    }

    return array_values(array_unique(array_filter($values)));
}

function jullybride_catalog_sanitize_filter_value(string $param, $value): string
{
    if ($param === 'orderby') {
        return sanitize_key(is_array($value) ? reset($value) : (string) $value);
    }

    if ($param === 'jb_in_stock') {
        return empty($value) ? '' : '1';
    }

    if ($param === '_price') {
        return sanitize_text_field(is_array($value) ? reset($value) : (string) $value);
    }

    $values = is_array($value) ? $value : explode(',', (string) $value);
    $values = array_map('jullybride_catalog_sanitize_slug_value', $values);
    $values = array_filter($values);

    return implode(',', array_values(array_unique($values)));
}

function jullybride_catalog_expanded_request_values_for_definition(array $definition): array
{
    $values = jullybride_catalog_request_values_for_definition($definition);
    $expanded = jullybride_catalog_expand_slugs_by_taxonomy((array) ($definition['taxonomies'] ?? []), $values);

    foreach ($expanded as $taxonomy_values) {
        $values = array_merge($values, (array) $taxonomy_values);
    }

    return array_values(array_unique(array_filter($values)));
}

function jullybride_catalog_active_filter_breadcrumb_items(): array
{
    if (is_admin() || !jullybride_catalog_is_catalog_request_path()) {
        return [];
    }

    $items = [];
    $seen = [];

    foreach (jullybride_catalog_filter_definitions() as $definition) {
        $selected = jullybride_catalog_request_values_for_definition($definition);

        if (!$selected) {
            continue;
        }

        $slugs_by_taxonomy = jullybride_catalog_expand_slugs_by_taxonomy((array) ($definition['taxonomies'] ?? []), $selected);

        foreach ($slugs_by_taxonomy as $taxonomy => $slugs) {
            if (!taxonomy_exists($taxonomy)) {
                continue;
            }

            foreach ($slugs as $slug) {
                $term = get_term_by('slug', $slug, $taxonomy);

                if (!$term instanceof WP_Term) {
                    continue;
                }

                $key = $taxonomy . ':' . $term->term_id;
                if (isset($seen[$key])) {
                    continue;
                }

                $seen[$key] = true;
                $items[] = [
                    'label' => $term->name,
                    'taxonomy' => $taxonomy,
                    'term_id' => (int) $term->term_id,
                    'slug' => $term->slug,
                ];
            }
        }
    }

    return $items;
}

function jullybride_catalog_primary_active_filter_term(): ?WP_Term
{
    if (is_admin() || !jullybride_catalog_is_catalog_request_path()) {
        return null;
    }

    foreach (jullybride_catalog_filter_definitions() as $definition) {
        $selected = jullybride_catalog_request_values_for_definition($definition);

        if (!$selected) {
            continue;
        }

        $slugs_by_taxonomy = jullybride_catalog_expand_slugs_by_taxonomy((array) ($definition['taxonomies'] ?? []), $selected);

        foreach ($slugs_by_taxonomy as $taxonomy => $slugs) {
            if (!taxonomy_exists($taxonomy)) {
                continue;
            }

            foreach ($slugs as $slug) {
                $term = get_term_by('slug', $slug, $taxonomy);

                if ($term instanceof WP_Term) {
                    return $term;
                }
            }
        }
    }

    return null;
}

function jullybride_catalog_filter_term_yoast_value(WP_Term $term, string $field): string
{
    $value = '';

    if (class_exists('WPSEO_Taxonomy_Meta')) {
        $value = WPSEO_Taxonomy_Meta::get_term_meta($term, $term->taxonomy, $field);
        $value = is_string($value) ? $value : '';
    }

    if ($value === '') {
        $meta_key = 'wpseo_' . $field;
        $value = (string) get_term_meta($term->term_id, $meta_key, true);
    }

    return $value;
}

function jullybride_catalog_current_url(): string
{
    $request_uri = (string) wp_unslash($_SERVER['REQUEST_URI'] ?? '/');
    $parts = wp_parse_url($request_uri);
    $path = (string) ($parts['path'] ?? '/');
    $query = !empty($parts['query']) ? '?' . $parts['query'] : '';

    return home_url($path . $query);
}

function jullybride_catalog_selected_size_values(string $excluded_param = ''): array
{
    if ($excluded_param === 'pa_razmer') {
        return [];
    }

    $selected = jullybride_catalog_request_values('pa_razmer');

    return $selected ?: jullybride_catalog_request_values('filter_pa_razmer');
}

function jullybride_catalog_stock_product_ids(array $size_slugs = []): array
{
    global $wpdb;

    $size_slugs = array_values(array_unique(array_filter(array_map('jullybride_catalog_sanitize_slug_value', $size_slugs))));
    $cache_key = implode(',', $size_slugs) ?: '__all__';
    static $cache = [];

    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $sql = "
        SELECT DISTINCT variation.post_parent
        FROM {$wpdb->posts} variation
        INNER JOIN {$wpdb->postmeta} stock
            ON stock.post_id = variation.ID
            AND stock.meta_key = '_stock_status'
            AND stock.meta_value = 'instock'
    ";
    $params = [];

    if ($size_slugs) {
        $placeholders = implode(',', array_fill(0, count($size_slugs), '%s'));
        $sql .= "
            INNER JOIN {$wpdb->postmeta} size_meta
                ON size_meta.post_id = variation.ID
                AND size_meta.meta_key = 'attribute_pa_razmer'
                AND size_meta.meta_value IN ({$placeholders})
        ";
        $params = array_merge($params, $size_slugs);
    }

    $sql .= "
        WHERE variation.post_type = 'product_variation'
            AND variation.post_status IN ('publish', 'private')
            AND variation.post_parent > 0
    ";

    $variable_ids = $wpdb->get_col($params ? $wpdb->prepare($sql, $params) : $sql);

    $simple_args = [
        'status' => 'publish',
        'stock_status' => 'instock',
        'type' => ['simple', 'external'],
        'limit' => -1,
        'return' => 'ids',
    ];

    if ($size_slugs) {
        if (!taxonomy_exists('pa_razmer')) {
            $simple_args['include'] = [0];
        } else {
            $simple_args['tax_query'] = [
                [
                    'taxonomy' => 'pa_razmer',
                    'field' => 'slug',
                    'terms' => $size_slugs,
                    'operator' => 'IN',
                ],
            ];
        }
    }

    $simple_ids = wc_get_products($simple_args);
    $ids = array_values(array_unique(array_merge(
        array_map('absint', $variable_ids ?: []),
        array_map('absint', $simple_ids ?: [])
    )));

    $cache[$cache_key] = $ids;

    return $ids;
}

function jullybride_catalog_restrict_to_ids(array &$args, array $ids): void
{
    $ids = array_values(array_unique(array_filter(array_map('absint', $ids))));

    if (isset($args['post__in']) && is_array($args['post__in'])) {
        $ids = array_values(array_intersect(array_map('absint', $args['post__in']), $ids));
    }

    $args['post__in'] = $ids ?: [0];
}

function jullybride_catalog_base_product_ids(): array
{
    static $cache = [];

    $term = jullybride_catalog_current_product_category();
    $cache_key = $term instanceof WP_Term ? 'cat_' . $term->term_id : 'catalog';
    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'fields' => 'ids',
        'posts_per_page' => -1,
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ];

    if ($term instanceof WP_Term) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => [$term->term_id],
            ],
        ];
    }

    $query = new WP_Query($args);
    $cache[$cache_key] = array_map('absint', $query->posts ?: []);

    wp_reset_postdata();

    return $cache[$cache_key];
}

function jullybride_catalog_product_ids_for_tax_filter(array $taxonomies, array $slugs): array
{
    global $wpdb;

    $slugs = array_values(array_unique(array_filter(array_map('jullybride_catalog_sanitize_slug_value', $slugs))));
    $taxonomies = array_values(array_unique(array_filter($taxonomies)));
    $cache_key = md5(wp_json_encode([$taxonomies, $slugs]));
    static $cache = [];

    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $slugs_by_taxonomy = jullybride_catalog_expand_slugs_by_taxonomy($taxonomies, $slugs);
    $term_taxonomy_ids = [];

    foreach ($slugs_by_taxonomy as $taxonomy => $taxonomy_slugs) {
        foreach ($taxonomy_slugs as $slug) {
            $term = get_term_by('slug', $slug, $taxonomy);
            if ($term instanceof WP_Term) {
                $term_taxonomy_ids[] = (int) $term->term_taxonomy_id;
            }
        }
    }

    $term_taxonomy_ids = array_values(array_unique(array_filter($term_taxonomy_ids)));
    if (!$term_taxonomy_ids) {
        $cache[$cache_key] = [];
        return [];
    }

    $tt_sql = implode(',', $term_taxonomy_ids);
    $ids = $wpdb->get_col(
        "SELECT DISTINCT object_id
        FROM {$wpdb->term_relationships}
        WHERE term_taxonomy_id IN ({$tt_sql})"
    );

    $cache[$cache_key] = array_map('absint', $ids ?: []);

    return $cache[$cache_key];
}

function jullybride_catalog_price_product_ids(): array
{
    global $wpdb;

    if (empty($_GET['_price'])) {
        return [];
    }

    preg_match_all('/\d+(?:[.,]\d+)?/', (string) wp_unslash($_GET['_price']), $matches);
    $numbers = array_map(static fn (string $value): float => (float) str_replace(',', '.', $value), $matches[0] ?? []);

    if (!$numbers) {
        return [];
    }

    $min = min($numbers);
    $max = count($numbers) > 1 ? max($numbers) : null;

    if ($max === null) {
        $sql = $wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_price' AND CAST(meta_value AS DECIMAL(12,2)) >= %f",
            $min
        );
    } else {
        $sql = $wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_price' AND CAST(meta_value AS DECIMAL(12,2)) BETWEEN %f AND %f",
            $min,
            $max
        );
    }

    return array_map('absint', $wpdb->get_col($sql) ?: []);
}

function jullybride_catalog_intersect_id_sets(array $base_ids, array $sets): array
{
    $current = array_fill_keys(array_map('absint', $base_ids), true);

    foreach ($sets as $set) {
        $set = array_fill_keys(array_map('absint', $set), true);
        $current = array_intersect_key($current, $set);

        if (!$current) {
            break;
        }
    }

    return array_map('absint', array_keys($current));
}

function jullybride_catalog_count_base_product_ids(string $excluded_param): array
{
    static $cache = [];

    $term = jullybride_catalog_current_product_category();
    $category_key = $term instanceof WP_Term ? (string) $term->term_id : 'catalog';
    $cache_key = md5($excluded_param . '|' . $category_key . '|' . wp_json_encode($_GET));
    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $sets = [];

    foreach (jullybride_catalog_filter_definitions() as $definition) {
        $param = (string) ($definition['param'] ?? '');
        if (in_array($excluded_param, jullybride_catalog_definition_params($definition), true)) {
            continue;
        }

        $selected = jullybride_catalog_request_values_for_definition($definition);

        if ($selected) {
            $sets[] = jullybride_catalog_product_ids_for_tax_filter((array) $definition['taxonomies'], $selected);
        }
    }

    foreach ($_GET as $key => $value) {
        if (!str_starts_with((string) $key, 'filter_pa_')) {
            continue;
        }

        if (in_array((string) $key, jullybride_catalog_filter_param_names(), true)) {
            continue;
        }

        $attribute_name = jullybride_catalog_sanitize_slug_value(substr((string) $key, strlen('filter_')));
        if ($attribute_name === 'pa_razmer' || $attribute_name === $excluded_param) {
            continue;
        }

        $taxonomy = wc_attribute_taxonomy_name(str_replace('pa_', '', $attribute_name));
        $slugs = array_filter(array_map('jullybride_catalog_sanitize_slug_value', explode(',', (string) wp_unslash($value))));

        if (taxonomy_exists($taxonomy) && $slugs) {
            $sets[] = jullybride_catalog_product_ids_for_tax_filter([$taxonomy], $slugs);
        }
    }

    if (!empty($_GET['_price'])) {
        $sets[] = jullybride_catalog_price_product_ids();
    }

    if (!empty($_GET['jb_in_stock']) && $excluded_param !== 'jb_in_stock') {
        $sets[] = jullybride_catalog_stock_product_ids(jullybride_catalog_selected_size_values($excluded_param));
    }

    $cache[$cache_key] = jullybride_catalog_intersect_id_sets(jullybride_catalog_base_product_ids(), $sets);

    return $cache[$cache_key];
}

function jullybride_catalog_apply_dynamic_term_counts(array &$terms_by_name, array $definition, array $product_ids): void
{
    global $wpdb;

    foreach ($terms_by_name as &$term_data) {
        $term_data['count'] = 0;
    }
    unset($term_data);

    $product_ids = array_values(array_unique(array_filter(array_map('absint', $product_ids))));
    if (!$product_ids) {
        return;
    }

    if (($definition['param'] ?? '') === 'pa_razmer' && !empty($_GET['jb_in_stock'])) {
        foreach ($terms_by_name as &$term_data) {
            $stock_ids = jullybride_catalog_stock_product_ids((array) ($term_data['slugs'] ?? [$term_data['slug']]));
            $term_data['count'] = count(array_intersect($product_ids, $stock_ids));
        }
        unset($term_data);

        return;
    }

    $tt_id_to_key = [];
    foreach ($terms_by_name as $key => $term_data) {
        foreach (($term_data['term_taxonomy_ids'] ?? []) as $tt_id) {
            $tt_id_to_key[(int) $tt_id] = $key;
        }
    }

    if (!$tt_id_to_key) {
        return;
    }

    $product_sql = implode(',', $product_ids);
    $tt_sql = implode(',', array_map('absint', array_keys($tt_id_to_key)));
    $rows = $wpdb->get_results(
        "SELECT object_id, term_taxonomy_id
        FROM {$wpdb->term_relationships}
        WHERE object_id IN ({$product_sql})
            AND term_taxonomy_id IN ({$tt_sql})",
        ARRAY_A
    );

    $objects_by_key = [];
    foreach ($rows ?: [] as $row) {
        $tt_id = (int) $row['term_taxonomy_id'];
        if (!isset($tt_id_to_key[$tt_id])) {
            continue;
        }

        $objects_by_key[$tt_id_to_key[$tt_id]][(int) $row['object_id']] = true;
    }

    foreach ($objects_by_key as $key => $objects) {
        if (isset($terms_by_name[$key])) {
            $terms_by_name[$key]['count'] = count($objects);
        }
    }
}

function jullybride_catalog_filter_terms(array $definition, ?array $base_product_ids = null): array
{
    $terms_by_name = [];

    foreach (($definition['taxonomies'] ?? []) as $taxonomy) {
        if (!taxonomy_exists($taxonomy)) {
            continue;
        }

        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
        ]);

        if (!$terms || is_wp_error($terms)) {
            continue;
        }

        foreach ($terms as $term) {
            $key = trim((string) $term->name);

            if ($key === '') {
                $key = $term->slug;
            }

            if (!isset($terms_by_name[$key])) {
                $terms_by_name[$key] = [
                    'name' => $term->name,
                    'slug' => $term->slug,
                    'slugs' => [],
                    'term_taxonomy_ids' => [],
                    'count' => 0,
                ];
            }

            $terms_by_name[$key]['slugs'][] = $term->slug;
            $terms_by_name[$key]['term_taxonomy_ids'][] = (int) $term->term_taxonomy_id;

            if ($base_product_ids === null) {
                $terms_by_name[$key]['count'] += (int) $term->count;
            }
        }
    }

    if (is_array($base_product_ids)) {
        jullybride_catalog_apply_dynamic_term_counts($terms_by_name, $definition, $base_product_ids);
    }

    foreach ($terms_by_name as &$term_data) {
        $term_data['slugs'] = array_values(array_unique($term_data['slugs']));
        $term_data['term_taxonomy_ids'] = array_values(array_unique($term_data['term_taxonomy_ids']));
    }
    unset($term_data);

    uasort($terms_by_name, static fn (array $a, array $b): int => strnatcasecmp($a['name'], $b['name']));

    return array_values($terms_by_name);
}

function jullybride_catalog_expand_slugs_by_taxonomy(array $taxonomies, array $slugs): array
{
    $expanded = [];
    $matched_names = [];

    foreach ($taxonomies as $taxonomy) {
        if (!taxonomy_exists($taxonomy)) {
            continue;
        }

        foreach ($slugs as $slug) {
            $term = get_term_by('slug', $slug, $taxonomy);

            if (!$term instanceof WP_Term) {
                continue;
            }

            $expanded[$taxonomy][] = $term->slug;
            $matched_names[] = $term->name;
        }
    }

    foreach (array_unique($matched_names) as $name) {
        foreach ($taxonomies as $taxonomy) {
            if (!taxonomy_exists($taxonomy)) {
                continue;
            }

            $term = get_term_by('name', $name, $taxonomy);

            if ($term instanceof WP_Term) {
                $expanded[$taxonomy][] = $term->slug;
            }
        }
    }

    foreach ($expanded as $taxonomy => $taxonomy_slugs) {
        $expanded[$taxonomy] = array_values(array_unique(array_filter($taxonomy_slugs)));
    }

    return $expanded;
}

function jullybride_catalog_add_tax_filter(array &$args, array $taxonomies, array $slugs): void
{
    $slugs_by_taxonomy = jullybride_catalog_expand_slugs_by_taxonomy($taxonomies, $slugs);
    $clauses = [];

    foreach ($slugs_by_taxonomy as $taxonomy => $taxonomy_slugs) {
        if (!$taxonomy_slugs) {
            continue;
        }

        $clauses[] = [
            'taxonomy' => $taxonomy,
            'field' => 'slug',
            'terms' => $taxonomy_slugs,
            'operator' => 'IN',
        ];
    }

    if (!$clauses) {
        return;
    }

    $args['tax_query'][] = count($clauses) === 1
        ? $clauses[0]
        : array_merge(['relation' => 'OR'], $clauses);
}

function jullybride_catalog_reset_url(): string
{
    if (is_product_category()) {
        $term_link = get_term_link(get_queried_object());
        return is_wp_error($term_link) ? home_url('/c/') : $term_link;
    }

    $catalog_page_id = jullybride_catalog_page_id();

    return $catalog_page_id ? get_permalink($catalog_page_id) : home_url('/c/');
}

function jullybride_catalog_apply_price_filter(array &$args): void
{
    if (empty($_GET['_price'])) {
        return;
    }

    preg_match_all('/\d+(?:[.,]\d+)?/', (string) wp_unslash($_GET['_price']), $matches);
    $numbers = array_map(static fn (string $value): float => (float) str_replace(',', '.', $value), $matches[0] ?? []);

    if (!$numbers) {
        return;
    }

    $min = min($numbers);
    $max = count($numbers) > 1 ? max($numbers) : null;

    $args['meta_query'][] = [
        'key' => '_price',
        'value' => $max === null ? $min : [$min, $max],
        'type' => 'NUMERIC',
        'compare' => $max === null ? '>=' : 'BETWEEN',
    ];
}

function jullybride_catalog_query_args(array $options = []): array
{
    $excluded_param = (string) ($options['exclude_param'] ?? '');
    $paged = max(1, absint(get_query_var('paged')), absint(get_query_var('page')));
    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => (int) apply_filters('jullybride_catalog_per_page', 23),
        'paged' => $paged,
        'tax_query' => [],
        'meta_query' => [],
    ];

    $term = jullybride_catalog_current_product_category();
    if ($term instanceof WP_Term) {
        $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => [$term->term_id],
        ];
    }

    foreach (jullybride_catalog_filter_definitions() as $definition) {
        if (in_array($excluded_param, jullybride_catalog_definition_params($definition), true)) {
            continue;
        }

        $selected = jullybride_catalog_request_values_for_definition($definition);

        if ($selected) {
            jullybride_catalog_add_tax_filter($args, (array) $definition['taxonomies'], $selected);
        }
    }

    foreach ($_GET as $key => $value) {
        if (!str_starts_with((string) $key, 'filter_pa_')) {
            continue;
        }

        if (in_array((string) $key, jullybride_catalog_filter_param_names(), true)) {
            continue;
        }

        $attribute_name = jullybride_catalog_sanitize_slug_value(substr((string) $key, strlen('filter_')));
        if ($attribute_name === 'pa_razmer' || $attribute_name === $excluded_param) {
            continue;
        }

        $taxonomy = wc_attribute_taxonomy_name(str_replace('pa_', '', $attribute_name));
        $slugs = array_filter(array_map('jullybride_catalog_sanitize_slug_value', explode(',', (string) wp_unslash($value))));

        if (taxonomy_exists($taxonomy) && $slugs) {
            $args['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $slugs,
                'operator' => 'IN',
            ];
        }
    }

    jullybride_catalog_apply_price_filter($args);

    if (!empty($_GET['jb_in_stock'])) {
        $in_stock_ids = jullybride_catalog_stock_product_ids(jullybride_catalog_selected_size_values($excluded_param));
        jullybride_catalog_restrict_to_ids($args, $in_stock_ids);
    }

    if (count($args['tax_query']) > 1) {
        $args['tax_query']['relation'] = 'AND';
    }

    if (count($args['meta_query']) > 1) {
        $args['meta_query']['relation'] = 'AND';
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

add_action('wp_ajax_jullybride_catalog_filter_counts', 'jullybride_ajax_catalog_filter_counts');
add_action('wp_ajax_nopriv_jullybride_catalog_filter_counts', 'jullybride_ajax_catalog_filter_counts');
function jullybride_ajax_catalog_filter_counts(): void
{
    if (!function_exists('wc_get_products')) {
        wp_send_json_error(['message' => 'WooCommerce недоступен.'], 400);
    }

    $allowed_params = [
        'jb_in_stock',
        'filter_pa_razmer',
        '_price',
        'orderby',
    ];

    foreach (jullybride_catalog_filter_definitions() as $definition) {
        $allowed_params = array_merge($allowed_params, jullybride_catalog_definition_params($definition));
    }

    $next_get = [];
    foreach (array_values(array_unique($allowed_params)) as $param) {
        if (!isset($_POST[$param])) {
            continue;
        }

        $value = wp_unslash($_POST[$param]);
        $value = jullybride_catalog_sanitize_filter_value((string) $param, $value);

        if ($value !== '') {
            $next_get[$param] = $value;
        }
    }

    $_GET = $next_get;
    $GLOBALS['jullybride_catalog_filter_category_id'] = isset($_POST['category_id'])
        ? absint($_POST['category_id'])
        : 0;

    $counts = [];

    foreach (jullybride_catalog_filter_definitions() as $definition) {
        $param = (string) $definition['param'];
        $terms = jullybride_catalog_filter_terms($definition, jullybride_catalog_count_base_product_ids($param));

        foreach ($terms as $term) {
            $slug = (string) $term['slug'];
            $counts[$param][$slug] = [
                'count' => (int) $term['count'],
                'slugs' => array_values(array_map('jullybride_catalog_sanitize_slug_value', (array) ($term['slugs'] ?? [$slug]))),
            ];
        }
    }

    $stock_base_ids = jullybride_catalog_count_base_product_ids('jb_in_stock');
    $stock_ids = jullybride_catalog_stock_product_ids(jullybride_catalog_selected_size_values());
    $counts['jb_in_stock']['1'] = [
        'count' => count(array_intersect($stock_base_ids, $stock_ids)),
        'slugs' => ['1'],
    ];

    wp_send_json_success([
        'counts' => $counts,
    ]);
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

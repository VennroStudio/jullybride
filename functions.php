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
        ['param' => '_silhouette', 'taxonomies' => ['silhouette'], 'label' => 'Силуэт'],
        ['param' => '_designer', 'taxonomies' => ['designer'], 'label' => 'Дизайнер / бренд'],
        ['param' => '_style', 'taxonomies' => ['style'], 'label' => 'Стиль'],
        ['param' => '_color', 'taxonomies' => ['pa_czvet', 'color'], 'label' => 'Цвет'],
        ['param' => '_material', 'taxonomies' => ['material'], 'label' => 'Материал'],
        ['param' => '_sleeves', 'taxonomies' => ['sleeves'], 'label' => 'Рукава'],
        ['param' => '_length', 'taxonomies' => ['length'], 'label' => 'Длина'],
        ['param' => '_shoulders', 'taxonomies' => ['shoulders'], 'label' => 'Плечи'],
        ['param' => '_decollete', 'taxonomies' => ['decollete'], 'label' => 'Декольте'],
        ['param' => '_backdress', 'taxonomies' => ['backdress'], 'label' => 'Спина'],
        ['param' => '_corset', 'taxonomies' => ['corset'], 'label' => 'Корсет'],
        ['param' => '_collection', 'taxonomies' => ['collection'], 'label' => 'Коллекция'],
        ['param' => '_season', 'taxonomies' => ['season'], 'label' => 'Сезон'],
        ['param' => '_slit', 'taxonomies' => ['slit'], 'label' => 'Разрез'],
        ['param' => '_where', 'taxonomies' => ['where'], 'label' => 'Предназначение'],
        ['param' => '_train', 'taxonomies' => ['train'], 'label' => 'Шлейф'],
        ['param' => '_straps', 'taxonomies' => ['straps'], 'label' => 'Бретельки'],
        ['param' => '_details', 'taxonomies' => ['details'], 'label' => 'Детали'],
        ['param' => '_heel', 'taxonomies' => ['heel'], 'label' => 'Каблук'],
        ['param' => 'pa_razmer', 'taxonomies' => ['pa_razmer'], 'label' => 'Размер'],
    ];
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
        $params[] = (string) $definition['param'];
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
    $values = array_map('sanitize_title', $values);
    $values = array_filter($values);

    return array_values(array_unique($values));
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

    $size_slugs = array_values(array_unique(array_filter(array_map('sanitize_title', $size_slugs))));
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

    $slugs = array_values(array_unique(array_filter(array_map('sanitize_title', $slugs))));
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
        if ($param === $excluded_param) {
            continue;
        }

        $selected = jullybride_catalog_request_values($param);
        if ($param === 'pa_razmer' && !$selected) {
            $selected = jullybride_catalog_request_values('filter_pa_razmer');
        }

        if ($selected) {
            $sets[] = jullybride_catalog_product_ids_for_tax_filter((array) $definition['taxonomies'], $selected);
        }
    }

    foreach ($_GET as $key => $value) {
        if (!str_starts_with((string) $key, 'filter_pa_')) {
            continue;
        }

        $attribute_name = sanitize_title(substr((string) $key, strlen('filter_')));
        if ($attribute_name === 'pa_razmer' || $attribute_name === $excluded_param) {
            continue;
        }

        $taxonomy = wc_attribute_taxonomy_name(str_replace('pa_', '', $attribute_name));
        $slugs = array_filter(array_map('sanitize_title', explode(',', (string) wp_unslash($value))));

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
        'posts_per_page' => (int) apply_filters('jullybride_catalog_per_page', 24),
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
        if (($definition['param'] ?? '') === $excluded_param) {
            continue;
        }

        $selected = jullybride_catalog_request_values((string) $definition['param']);

        if ($definition['param'] === 'pa_razmer' && !$selected) {
            $selected = jullybride_catalog_request_values('filter_pa_razmer');
        }

        if ($selected) {
            jullybride_catalog_add_tax_filter($args, (array) $definition['taxonomies'], $selected);
        }
    }

    foreach ($_GET as $key => $value) {
        if (!str_starts_with((string) $key, 'filter_pa_')) {
            continue;
        }

        $attribute_name = sanitize_title(substr((string) $key, strlen('filter_')));
        if ($attribute_name === 'pa_razmer' || $attribute_name === $excluded_param) {
            continue;
        }

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
        $allowed_params[] = (string) $definition['param'];
    }

    $next_get = [];
    foreach (array_values(array_unique($allowed_params)) as $param) {
        if (!isset($_POST[$param])) {
            continue;
        }

        $value = wp_unslash($_POST[$param]);
        if (is_array($value)) {
            $value = implode(',', array_map('sanitize_text_field', $value));
        } else {
            $value = sanitize_text_field((string) $value);
        }

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
                'slugs' => array_values(array_map('sanitize_title', (array) ($term['slugs'] ?? [$slug]))),
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

<?php
if (!defined('ABSPATH')) {
    exit;
}

add_filter('query_vars', 'jullybride_register_catalog_filter_query_vars');
function jullybride_register_catalog_filter_query_vars(array $vars): array
{
    foreach (jullybride_catalog_filter_param_names() as $param) {
        $vars[] = $param;
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

function jullybride_catalog_page_id(): int
{
    $page = get_page_by_path('c');
    return $page instanceof WP_Post ? (int) $page->ID : 0;
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

function jullybride_catalog_all_attribute_filter_definitions(): array
{
    static $definitions = null;

    if ($definitions !== null) {
        return $definitions;
    }

    $definitions = [];
    $taxonomies = get_object_taxonomies('product', 'objects');

    foreach ($taxonomies as $taxonomy => $taxonomy_object) {
        $taxonomy = is_string($taxonomy) ? $taxonomy : (string) ($taxonomy_object->name ?? '');

        if (!str_starts_with($taxonomy, 'pa_') || !taxonomy_exists($taxonomy)) {
            continue;
        }

        $label = function_exists('wc_attribute_label')
            ? wc_attribute_label($taxonomy)
            : (string) ($taxonomy_object->labels->singular_name ?? $taxonomy_object->label ?? $taxonomy);

        $definitions[] = [
            'param' => $taxonomy,
            'taxonomies' => [$taxonomy],
            'label' => $label !== '' ? $label : $taxonomy,
        ];
    }

    return jullybride_catalog_sort_filter_definitions($definitions);
}

function jullybride_catalog_sort_filter_definitions(array $definitions): array
{
    $priority = array_flip((array) JULLYBRIDE_CATALOG_FILTER_PRIORITY);

    usort($definitions, static function (array $a, array $b) use ($priority): int {
        $param_a = (string) ($a['param'] ?? '');
        $param_b = (string) ($b['param'] ?? '');
        $rank_a = $priority[$param_a] ?? PHP_INT_MAX;
        $rank_b = $priority[$param_b] ?? PHP_INT_MAX;

        if ($rank_a !== $rank_b) {
            return $rank_a <=> $rank_b;
        }

        return strnatcasecmp((string) ($a['label'] ?? $param_a), (string) ($b['label'] ?? $param_b));
    });

    return $definitions;
}

function jullybride_catalog_filter_definitions(): array
{
    static $cache = [];

    $term = jullybride_catalog_current_product_category();
    $cache_key = $term instanceof WP_Term ? 'cat_' . $term->term_id : 'catalog';

    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $product_ids = jullybride_catalog_base_product_ids();
    if (!$product_ids) {
        $cache[$cache_key] = [];
        return [];
    }

    $taxonomies_with_terms = jullybride_catalog_taxonomies_with_product_terms($product_ids);
    $definitions = array_values(array_filter(
        jullybride_catalog_all_attribute_filter_definitions(),
        static fn (array $definition): bool => isset($taxonomies_with_terms[(string) ($definition['param'] ?? '')])
    ));

    $cache[$cache_key] = jullybride_catalog_sort_filter_definitions($definitions);

    return $cache[$cache_key];
}

function jullybride_catalog_taxonomies_with_product_terms(array $product_ids): array
{
    global $wpdb;

    $product_ids = array_values(array_unique(array_filter(array_map('absint', $product_ids))));
    if (!$product_ids) {
        return [];
    }

    $cache_key = md5(implode(',', $product_ids));
    static $cache = [];

    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $product_sql = implode(',', $product_ids);
    $taxonomies = $wpdb->get_col(
        "SELECT DISTINCT tt.taxonomy
        FROM {$wpdb->term_relationships} tr
        INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
        WHERE tr.object_id IN ({$product_sql})
            AND tt.taxonomy LIKE 'pa\\_%'"
    );

    $cache[$cache_key] = array_fill_keys(array_map('strval', $taxonomies ?: []), true);

    return $cache[$cache_key];
}

function jullybride_catalog_taxonomy_has_product_terms(string $taxonomy, array $product_ids): bool
{
    if ($taxonomy === '' || !taxonomy_exists($taxonomy)) {
        return false;
    }

    return isset(jullybride_catalog_taxonomies_with_product_terms($product_ids)[$taxonomy]);
}

function jullybride_catalog_definition_params(array $definition): array
{
    return array_values(array_filter([(string) ($definition['param'] ?? '')]));
}

function jullybride_catalog_filter_param_names(): array
{
    static $params = null;

    if ($params !== null) {
        return $params;
    }

    $params = ['jb_in_stock', '_price', 'orderby'];

    foreach (jullybride_catalog_all_attribute_filter_definitions() as $definition) {
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

    return $selected;
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

function jullybride_catalog_price_bounds(array $product_ids): array
{
    global $wpdb;

    $product_ids = array_values(array_unique(array_filter(array_map('absint', $product_ids))));
    if (!$product_ids) {
        return [0, 100000];
    }

    $cache_ids = $product_ids;
    sort($cache_ids);
    $cache_key = md5(implode(',', $cache_ids));
    static $cache = [];

    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $product_sql = implode(',', $product_ids);
    $row = $wpdb->get_row(
        "SELECT
            MIN(CAST(meta_value AS DECIMAL(12,2))) AS min_price,
            MAX(CAST(meta_value AS DECIMAL(12,2))) AS max_price
        FROM {$wpdb->postmeta}
        WHERE meta_key = '_price'
            AND meta_value <> ''
            AND post_id IN ({$product_sql})",
        ARRAY_A
    );

    $min = isset($row['min_price']) ? (int) floor((float) $row['min_price']) : 0;
    $max = isset($row['max_price']) ? (int) ceil((float) $row['max_price']) : 100000;

    if ($max <= 0) {
        $max = 100000;
    }

    $cache[$cache_key] = [$min, $max];

    return $cache[$cache_key];
}

function jullybride_catalog_selected_price_values(): array
{
    if (empty($_GET['_price'])) {
        return ['', ''];
    }

    preg_match_all('/\d+(?:[.,]\d+)?/', (string) wp_unslash($_GET['_price']), $matches);
    $numbers = array_map(static fn (string $value): int => (int) round((float) str_replace(',', '.', $value)), $matches[0] ?? []);
    $numbers = array_values(array_filter($numbers, static fn (int $value): bool => $value >= 0));

    if (!$numbers) {
        return ['', ''];
    }

    return [
        (string) min($numbers),
        count($numbers) > 1 ? (string) max($numbers) : '',
    ];
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

    if (!empty($_GET['_price'])) {
        $sets[] = jullybride_catalog_price_product_ids();
    }

    if (!empty($_GET['jb_in_stock']) && $excluded_param !== 'jb_in_stock') {
        $sets[] = jullybride_catalog_stock_product_ids(jullybride_catalog_selected_size_values($excluded_param));
    }

    $cache[$cache_key] = jullybride_catalog_intersect_id_sets(jullybride_catalog_base_product_ids(), $sets);

    return $cache[$cache_key];
}

function jullybride_catalog_attribute_relationships_for_products(array $product_ids): array
{
    global $wpdb;

    $product_ids = array_values(array_unique(array_filter(array_map('absint', $product_ids))));
    if (!$product_ids) {
        return [];
    }

    $cache_ids = $product_ids;
    sort($cache_ids);
    $cache_key = md5(implode(',', $cache_ids));
    static $cache = [];

    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $product_sql = implode(',', $product_ids);
    $rows = $wpdb->get_results(
        "SELECT tr.object_id, tr.term_taxonomy_id
        FROM {$wpdb->term_relationships} tr
        INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
        WHERE tr.object_id IN ({$product_sql})
            AND tt.taxonomy LIKE 'pa\\_%'",
        ARRAY_A
    );

    $relationships = [];
    foreach ($rows ?: [] as $row) {
        $relationships[(int) $row['term_taxonomy_id']][(int) $row['object_id']] = true;
    }

    $cache[$cache_key] = $relationships;

    return $cache[$cache_key];
}

function jullybride_catalog_apply_dynamic_term_counts(array &$terms_by_name, array $definition, array $product_ids): void
{
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

    $objects_by_key = [];
    $relationships = jullybride_catalog_attribute_relationships_for_products($product_ids);

    foreach ($tt_id_to_key as $tt_id => $key) {
        if (empty($relationships[$tt_id])) {
            continue;
        }

        foreach ($relationships[$tt_id] as $object_id => $_) {
            $objects_by_key[$key][(int) $object_id] = true;
        }
    }

    foreach ($objects_by_key as $key => $objects) {
        if (isset($terms_by_name[$key])) {
            $terms_by_name[$key]['count'] = count($objects);
        }
    }
}

function jullybride_catalog_filter_terms_by_taxonomy(): array
{
    static $cache = null;

    if ($cache !== null) {
        return $cache;
    }

    $taxonomies = [];
    foreach (jullybride_catalog_filter_definitions() as $definition) {
        foreach ((array) ($definition['taxonomies'] ?? []) as $taxonomy) {
            if (is_string($taxonomy) && taxonomy_exists($taxonomy)) {
                $taxonomies[] = $taxonomy;
            }
        }
    }

    $taxonomies = array_values(array_unique($taxonomies));
    if (!$taxonomies) {
        $cache = [];
        return [];
    }

    $terms = get_terms([
        'taxonomy' => $taxonomies,
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC',
        'update_term_meta_cache' => false,
    ]);

    $cache = [];
    if (!$terms || is_wp_error($terms)) {
        return $cache;
    }

    foreach ($terms as $term) {
        if ($term instanceof WP_Term) {
            $cache[$term->taxonomy][] = $term;
        }
    }

    return $cache;
}

function jullybride_catalog_filter_terms(array $definition, ?array $base_product_ids = null): array
{
    static $cache = [];

    $base_key = 'global';
    if (is_array($base_product_ids)) {
        $base_ids = array_values(array_unique(array_filter(array_map('absint', $base_product_ids))));
        sort($base_ids);
        $base_key = implode(',', $base_ids);
    }

    $cache_key = md5(wp_json_encode([
        (string) ($definition['param'] ?? ''),
        array_values(array_map('strval', (array) ($definition['taxonomies'] ?? []))),
        $base_key,
        !empty($_GET['jb_in_stock']),
    ]));

    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $terms_by_name = [];
    $terms_by_taxonomy = jullybride_catalog_filter_terms_by_taxonomy();

    foreach (($definition['taxonomies'] ?? []) as $taxonomy) {
        if (!taxonomy_exists($taxonomy)) {
            continue;
        }

        $terms = $terms_by_taxonomy[$taxonomy] ?? [];
        if (!$terms) {
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

    $cache[$cache_key] = array_values($terms_by_name);

    return $cache[$cache_key];
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
        'posts_per_page' => (int) apply_filters('jullybride_catalog_per_page', JULLYBRIDE_CATALOG_PER_PAGE),
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

    $GLOBALS['jullybride_catalog_filter_category_id'] = isset($_POST['category_id'])
        ? absint($_POST['category_id'])
        : 0;

    $allowed_params = [
        'jb_in_stock',
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

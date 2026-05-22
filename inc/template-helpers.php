<?php
if (!defined('ABSPATH')) {
    exit;
}

function jullybride_template_part(string $slug, array $args = []): void
{
    get_template_part('template-block/' . $slug, null, $args);
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

function jullybride_acf_option_rows(string $field): array
{
    global $wpdb;

    static $rows_by_field = [];

    $field = trim($field);
    if ($field === '') {
        return [];
    }

    if (isset($rows_by_field[$field])) {
        return $rows_by_field[$field];
    }

    $option_prefix = 'options_' . $field;
    $field_key_prefix = '_options_' . $field;
    $like_option = $wpdb->esc_like($option_prefix . '_') . '%';
    $like_field_key = $wpdb->esc_like($field_key_prefix . '_') . '%';

    $rows = $wpdb->get_results($wpdb->prepare(
        "SELECT option_name, option_value
        FROM {$wpdb->options}
        WHERE option_name IN (%s, %s)
            OR option_name LIKE %s
            OR option_name LIKE %s",
        $option_prefix,
        $field_key_prefix,
        $like_option,
        $like_field_key
    ));

    $rows_by_field[$field] = [];

    foreach ($rows ?: [] as $row) {
        $option_name = (string) $row->option_name;
        $rows_by_field[$field][$option_name] = $row->option_value;
        wp_cache_add($option_name, $row->option_value, 'options');
    }

    return $rows_by_field[$field];
}

function jullybride_prime_acf_option_field(string $field): void
{
    static $primed = [];

    $field = trim($field);
    if ($field === '' || isset($primed[$field])) {
        return;
    }

    jullybride_acf_option_rows($field);

    $primed[$field] = true;
}

function jullybride_prime_acf_option_group(string $prefix): void
{
    global $wpdb;

    static $primed = [];

    $prefix = trim($prefix, "_ \t\n\r\0\x0B");
    if ($prefix === '' || isset($primed[$prefix])) {
        return;
    }

    $option_like = $wpdb->esc_like('options_' . $prefix . '_') . '%';
    $field_key_like = $wpdb->esc_like('_options_' . $prefix . '_') . '%';
    $rows = $wpdb->get_results($wpdb->prepare(
        "SELECT option_name, option_value
        FROM {$wpdb->options}
        WHERE option_name LIKE %s
            OR option_name LIKE %s",
        $option_like,
        $field_key_like
    ));

    foreach ($rows ?: [] as $row) {
        wp_cache_add((string) $row->option_name, $row->option_value, 'options');
    }

    $primed[$prefix] = true;
}

function jullybride_prime_acf_option_media(string $field, array $subfields = ['img', 'foto', 'video']): void
{
    static $primed = [];

    $field = trim($field);
    if ($field === '' || isset($primed[$field])) {
        return;
    }

    $subfields = array_values(array_unique(array_filter(array_map('strval', $subfields))));
    $subfield_pattern = $subfields ? '/_(' . implode('|', array_map('preg_quote', $subfields)) . ')$/' : null;
    $ids = [];

    foreach (jullybride_acf_option_rows($field) as $option_name => $option_value) {
        if ($subfield_pattern && !preg_match($subfield_pattern, (string) $option_name)) {
            continue;
        }

        if (is_numeric($option_value) && (int) $option_value > 0) {
            $ids[] = (int) $option_value;
        }
    }

    $ids = array_values(array_unique($ids));
    if ($ids) {
        if (function_exists('_prime_post_caches')) {
            _prime_post_caches($ids, false, true);
        } else {
            update_meta_cache('post', $ids);
        }
    }

    $primed[$field] = true;
}

function jullybride_prime_acf_option_missing_subfields(string $field, array $subfields): void
{
    $rows = jullybride_acf_option_rows($field);
    $count = isset($rows['options_' . $field]) ? (int) $rows['options_' . $field] : 0;

    if ($count <= 0) {
        return;
    }

    $notoptions = wp_cache_get('notoptions', 'options');
    if (!is_array($notoptions)) {
        $notoptions = [];
    }

    foreach (array_filter(array_map('strval', $subfields)) as $subfield) {
        for ($index = 0; $index < $count; $index++) {
            $option_name = 'options_' . $field . '_' . $index . '_' . $subfield;

            if (!array_key_exists($option_name, $rows)) {
                $notoptions[$option_name] = true;
            }
        }
    }

    wp_cache_set('notoptions', $notoptions, 'options');
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

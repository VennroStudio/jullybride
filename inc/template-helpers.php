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

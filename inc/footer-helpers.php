<?php
if (!defined('ABSPATH')) {
    exit;
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

        if (count($products) === JULLYBRIDE_FOOTER_PRODUCTS_LIMIT) {
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

    return is_array($links) ? $links : [];
}

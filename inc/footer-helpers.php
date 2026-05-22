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

    $product_ids = [];
    foreach ($selected_products as $selected_product) {
        $product_id = $selected_product instanceof WP_Post ? (int) $selected_product->ID : (int) $selected_product;

        if ($product_id > 0) {
            $product_ids[] = $product_id;
        }
    }

    $product_ids = array_values(array_unique($product_ids));
    if (!$product_ids) {
        return [];
    }

    if (function_exists('_prime_post_caches')) {
        _prime_post_caches($product_ids, false, true);
    } else {
        update_meta_cache('post', $product_ids);
    }

    $image_ids = [];
    foreach ($product_ids as $product_id) {
        $image_id = (int) get_post_thumbnail_id($product_id);

        if ($image_id > 0) {
            $image_ids[] = $image_id;
        }
    }

    if (function_exists('jullybride_prime_attachment_caches')) {
        jullybride_prime_attachment_caches($image_ids);
    }

    $products = [];

    foreach ($product_ids as $product_id) {
        $post = get_post($product_id);
        if (!$post instanceof WP_Post || $post->post_type !== 'product') {
            continue;
        }

        $image_id = (int) get_post_thumbnail_id($product_id);
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium_large') : '';

        if (!$image_url && function_exists('wc_placeholder_img_src')) {
            $image_url = wc_placeholder_img_src('medium_large');
        }

        $price = get_post_meta($product_id, '_price', true);

        $products[] = [
            'id' => $product_id,
            'title' => get_the_title($product_id),
            'url' => get_permalink($product_id),
            'image' => $image_url,
            'price' => jullybride_format_price($price),
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

<?php
if (!defined('ABSPATH')) {
    exit;
}

$menu = wp_get_nav_menu_object('glavnoe-menyu');

if (!$menu) {
    return [];
}

$items = wp_get_nav_menu_items($menu->term_id);

if (!$items) {
    return [];
}

$format_item = static function (WP_Post $item): array {
    return [
        'label' => html_entity_decode($item->title, ENT_QUOTES, get_bloginfo('charset')),
        'url' => (string) $item->url,
    ];
};

$children_by_parent = [];
foreach ($items as $item) {
    $children_by_parent[(int) $item->menu_item_parent][] = $item;
}

$menu_items = [];

foreach ($children_by_parent[0] ?? [] as $top_item) {
    $top = $format_item($top_item);
    $top['mega'] = [];

    foreach ($children_by_parent[(int) $top_item->ID] ?? [] as $group_item) {
        $group_children = $children_by_parent[(int) $group_item->ID] ?? [];
        $group = $format_item($group_item);

        $top['mega'][] = [
            'title' => $group['label'],
            'url' => $group['url'],
            'items' => array_map($format_item, $group_children),
        ];
    }

    if (!$top['mega']) {
        unset($top['mega']);
    }

    $menu_items[] = $top;
}

return $menu_items;

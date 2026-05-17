<?php
if (!defined('ABSPATH')) {
    exit;
}

$menu = wp_get_nav_menu_object('glavnoe-menyu');

if (!$menu) {
    return [
        ['label' => 'Свадебные платья', 'url' => home_url('/c/wedding/')],
        ['label' => 'Вечерние платья', 'url' => home_url('/c/evening/')],
        ['label' => 'От фаты до каблуков', 'url' => home_url('/c/accessories/')],
        ['label' => 'Акции', 'url' => home_url('/promo/')],
        ['label' => 'Секретная папка', 'url' => home_url('/blog/')],
        ['label' => 'Франшиза', 'url' => home_url('/franshiza/')],
        ['label' => 'Кэмп', 'url' => home_url('/pinkcamp/')],
    ];
}

$items = wp_get_nav_menu_items($menu->term_id);

if (!$items) {
    return [];
}

$normalize_url = static function (string $url): string {
    if ($url === '' || $url === '#') {
        return '#';
    }

    if (str_starts_with($url, '/')) {
        return home_url($url);
    }

    $parts = wp_parse_url($url);
    $host = $parts['host'] ?? '';
    $local_hosts = ['jullybride.ru', 'www.jullybride.ru', 'wordpress.local'];

    if ($host && in_array($host, $local_hosts, true)) {
        $path = $parts['path'] ?? '/';
        $query = !empty($parts['query']) ? '?' . $parts['query'] : '';
        $fragment = !empty($parts['fragment']) ? '#' . $parts['fragment'] : '';

        return home_url($path . $query . $fragment);
    }

    return $url;
};

$format_item = static function (WP_Post $item) use ($normalize_url): array {
    return [
        'label' => html_entity_decode($item->title, ENT_QUOTES, get_bloginfo('charset')),
        'url' => $normalize_url((string) $item->url),
    ];
};

$children_by_parent = [];
foreach ($items as $item) {
    $children_by_parent[(int) $item->menu_item_parent][] = $item;
}

$menu_items = [];

foreach ($children_by_parent[0] ?? [] as $top_item) {
    $top = $format_item($top_item);
    $groups = [];
    $loose_items = [];

    foreach ($children_by_parent[(int) $top_item->ID] ?? [] as $group_item) {
        $group_children = $children_by_parent[(int) $group_item->ID] ?? [];

        if (!$group_children) {
            $loose_items[] = $format_item($group_item);
            continue;
        }

        $group = $format_item($group_item);
        $groups[] = [
            'title' => $group['label'],
            'url' => $group['url'],
            'items' => array_map($format_item, $group_children),
        ];
    }

    if ($loose_items) {
        $groups[] = [
            'title' => 'Категории',
            'url' => $top['url'],
            'items' => $loose_items,
        ];
    }

    if ($groups) {
        $top['mega'] = $groups;
    }

    $menu_items[] = $top;
}

return $menu_items;

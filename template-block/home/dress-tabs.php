<?php
if (!defined('ABSPATH')) {
    exit;
}

$taxonomy_filter = static function (string $taxonomy, string $name, ?string $slug = null): array {
    $attribute_taxonomy = str_starts_with($taxonomy, 'pa_') ? $taxonomy : 'pa_' . $taxonomy;

    return [
        'taxonomy' => $attribute_taxonomy,
        'name' => $name,
        'slug' => $slug ?: sanitize_title($name),
    ];
};

$groups = [
    [
        'label' => 'Силуэт',
        'main_category' => 'wedding',
        'items' => [
            ['id' => 1, 'label' => 'Рыбка', 'category' => 'mermaid', 'filter' => $taxonomy_filter('silhouette', 'Рыбка', 'mermaid')],
            ['id' => 2, 'label' => 'А-силуэт', 'category' => 'a-line', 'filter' => $taxonomy_filter('silhouette', 'А-силуэт', 'a-line')],
            ['id' => 3, 'label' => 'Пышные', 'category' => 'lush', 'filter' => $taxonomy_filter('silhouette', 'Пышное', 'lush')],
            ['id' => 4, 'label' => 'Прямые', 'category' => 'straight', 'filter' => $taxonomy_filter('silhouette', 'Прямое', 'straight')],
            ['id' => 5, 'label' => 'Трансформер', 'category' => 'transformers', 'filter' => $taxonomy_filter('silhouette', 'Трансформер', 'transformer')],
            ['id' => 6, 'label' => 'Костюм', 'category' => 'transformers', 'filter' => $taxonomy_filter('silhouette', 'Комбинезон/костюм', 'suit')],
            ['id' => 7, 'label' => 'Ампир', 'category' => 'empire', 'filter' => $taxonomy_filter('silhouette', 'Ампир', 'empire')],
            ['id' => 9, 'label' => 'Футляр', 'category' => 'sheath', 'filter' => $taxonomy_filter('silhouette', 'Футляр', 'sheath')],
        ],
    ],
    [
        'label' => 'Длина',
        'main_category' => 'wedding',
        'items' => [
            ['id' => 10, 'label' => 'Длинные', 'category' => 'long', 'filter' => $taxonomy_filter('length', 'Длинное', 'dlinnoe')],
            ['id' => 11, 'label' => 'Миди', 'category' => 'midi', 'filter' => $taxonomy_filter('length', 'Миди', 'midi')],
            ['id' => 12, 'label' => 'Мини', 'category' => 'mini', 'filter' => $taxonomy_filter('length', 'Мини', 'mini')],
        ],
    ],
    [
        'label' => 'Стиль',
        'main_category' => 'wedding',
        'items' => [
            ['id' => 13, 'label' => 'Бохо', 'category' => 'boho', 'filter' => $taxonomy_filter('style', 'Бохо', 'boho')],
            ['id' => 17, 'label' => 'Минимализм', 'category' => 'minimalism', 'filter' => $taxonomy_filter('style', 'Минимализм', 'minimalism')],
            ['id' => 14, 'label' => 'Простые', 'category' => 'simple', 'filter' => $taxonomy_filter('style', 'Простое', 'simple')],
            ['id' => 15, 'label' => 'Кружевные', 'category' => 'lace', 'filter' => $taxonomy_filter('style', 'Кружевное', 'lace')],
            ['id' => 16, 'label' => 'Блестящие', 'category' => 'sparkle', 'filter' => $taxonomy_filter('style', 'Мерцающее', 'sparkle')],
            ['id' => 18, 'label' => 'Винтажные', 'category' => 'vintage', 'filter' => $taxonomy_filter('style', 'Винтажное', 'vintage')],
        ],
    ],
    [
        'label' => 'Особенности',
        'main_category' => 'wedding',
        'items' => [
            ['id' => 19, 'label' => 'С открытой спиной', 'category' => 'open-back', 'filter' => $taxonomy_filter('backdress', 'С открытой спиной', 'open')],
            ['id' => 20, 'label' => 'С закрытой спиной', 'category' => 'back-closed', 'filter' => $taxonomy_filter('backdress', 'Закрытая', 'closed')],
            ['id' => 21, 'label' => 'С декольте', 'category' => 'neckline', 'filter' => $taxonomy_filter('decollete', 'С декольте', 'low-necked')],
            ['id' => 22, 'label' => 'С V-вырезом', 'category' => 'v-cut', 'filter' => $taxonomy_filter('decollete', 'С V-вырезом', 's-v-vyrezom')],
            ['id' => 23, 'label' => 'С разрезом', 'category' => 'slit', 'filter' => $taxonomy_filter('slit', 'С разрезом', 'slit')],
            ['id' => 24, 'label' => 'С корсетом', 'category' => 'corset', 'filter' => $taxonomy_filter('corset', 'С корсетом', 'corset')],
        ],
    ],
    [
        'label' => 'Вечерние',
        'main_category' => 'evening',
        'sidebar_class' => 'col-12 col-md-2',
        'items' => [
            ['id' => 25, 'label' => 'Ампир', 'category' => 'empire_', 'filter' => $taxonomy_filter('silhouette', 'Ампир', 'empire')],
            ['id' => 26, 'label' => 'Комбинезон/костюм', 'category' => 'suit_', 'filter' => $taxonomy_filter('silhouette', 'Комбинезон/костюм', 'suit')],
            ['id' => 27, 'label' => 'Рыбка', 'category' => 'mermaid_', 'filter' => $taxonomy_filter('silhouette', 'Рыбка', 'mermaid')],
            ['id' => 28, 'label' => 'Пышные', 'category' => 'lush_', 'filter' => $taxonomy_filter('silhouette', 'Пышное', 'lush')],
            ['id' => 29, 'label' => 'Прямые', 'category' => 'straight_', 'filter' => $taxonomy_filter('silhouette', 'Прямое', 'straight')],
        ],
    ],
];

$resolve_taxonomy = static function (string $taxonomy): string {
    if (taxonomy_exists($taxonomy)) {
        return $taxonomy;
    }

    $attribute_taxonomy = str_starts_with($taxonomy, 'pa_') ? $taxonomy : 'pa_' . $taxonomy;

    return taxonomy_exists($attribute_taxonomy) ? $attribute_taxonomy : '';
};

$resolve_filter_term = static function (array $filter) use ($resolve_taxonomy): ?WP_Term {
    $taxonomy = $resolve_taxonomy((string) ($filter['taxonomy'] ?? ''));

    if (!$taxonomy) {
        return null;
    }

    $term = null;

    if (!empty($filter['slug'])) {
        $term = get_term_by('slug', (string) $filter['slug'], $taxonomy);
    }

    if (!$term && !empty($filter['name'])) {
        $term = get_term_by('name', (string) $filter['name'], $taxonomy);
    }

    return $term instanceof WP_Term ? $term : null;
};

$group_catalog_url = static function (array $group) use ($resolve_filter_term): string {
    $base = home_url('/c/' . trim((string) ($group['main_category'] ?? 'wedding'), '/') . '/');
    $params = ['_f' => 1];

    foreach ((array) ($group['items'] ?? []) as $item) {
        if (empty($item['filter']) || !is_array($item['filter'])) {
            continue;
        }

        $term = $resolve_filter_term($item['filter']);

        if (!$term) {
            continue;
        }

        $params[$term->taxonomy][] = rawurldecode($term->slug);
    }

    foreach ($params as $key => $value) {
        if (is_array($value)) {
            $params[$key] = implode(',', array_values(array_unique($value)));
        }
    }

    return add_query_arg($params, $base);
};

$query_args = static function (array $item, string $main_category) use ($resolve_filter_term): array {
    $args = [
        'post_type' => 'product',
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
    ];

    $tax_query = ['relation' => 'AND'];

    if ($main_category && get_term_by('slug', $main_category, 'product_cat')) {
        $tax_query[] = [
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => [$main_category],
        ];
    }

    if (!empty($item['filter'])) {
        $term = $resolve_filter_term($item['filter']);

        if ($term) {
            $tax_query[] = [
                'taxonomy' => $term->taxonomy,
                'field' => 'term_id',
                'terms' => [$term->term_id],
            ];
        } else {
            $args['post__in'] = [0];
        }
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    return $args;
};

$tabs = [];

foreach ($groups as $group_index => $group) {
    $tabs[] = [
        'id' => 'dress-group-' . $group_index,
        'label' => $group['label'],
        'template' => 'home/dress-tabs-panel',
        'args' => [
            'group' => $group,
            'catalog_url' => $group_catalog_url($group),
            'query_args' => $query_args,
        ],
    ];
}

jullybride_template_part('components/tabs-section', [
    'subtitle' => 'Выбери свое идеальное',
    'title' => 'свадебное платье',
    'tabs' => $tabs,
    'before_html' => sprintf(
        '<a href="#" class="tabs-box-svg1"><img src="%s" alt="Как выбрать то самое?"></a><img class="tabs-box-svg2 d-none d-md-block" src="%s" alt="">',
        esc_url(jullybride_asset_uri('images/kak-vybratь-to-samoe.svg')),
        esc_url(jullybride_asset_uri('images/nashey-atmosfere-zaviduyut.svg'))
    ),
    'after_html' => sprintf(
        '<a href="#" class="tabs-box-svg3 d-none d-md-block"><img src="%s" alt=""></a>',
        esc_url(jullybride_asset_uri('images/branchi-1.svg'))
    ),
]);

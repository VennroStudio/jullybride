<?php
if (!defined('ABSPATH')) {
    exit;
}

if (function_exists('yoast_breadcrumb')) {
    $yoast_breadcrumbs = yoast_breadcrumb('<nav class="jb-breadcrumbs">', '</nav>', false);
    if ($yoast_breadcrumbs) {
        echo $yoast_breadcrumbs;
        return;
    }
}

if (
    function_exists('woocommerce_breadcrumb')
    && (is_woocommerce() || is_product_category() || is_cart() || is_checkout() || is_account_page())
) {
    woocommerce_breadcrumb(['wrap_before' => '<nav class="jb-breadcrumbs">', 'wrap_after' => '</nav>']);
    return;
}

if (is_front_page()) {
    return;
}

$items = [
    [
        'label' => __('Главная', 'jullybride'),
        'url' => home_url('/'),
    ],
];

if (is_page()) {
    $page_id = get_queried_object_id();
    $ancestors = array_reverse(get_post_ancestors($page_id));

    foreach ($ancestors as $ancestor_id) {
        $items[] = [
            'label' => get_the_title($ancestor_id),
            'url' => get_permalink($ancestor_id),
        ];
    }

    $items[] = [
        'label' => get_the_title($page_id),
        'url' => '',
    ];
} elseif (is_singular()) {
    $post_type = get_post_type();

    if ($post_type && $post_type !== 'post') {
        $post_type_object = get_post_type_object($post_type);

        if ($post_type_object && !empty($post_type_object->labels->name)) {
            $items[] = [
                'label' => $post_type_object->labels->name,
                'url' => get_post_type_archive_link($post_type) ?: '',
            ];
        }
    }

    $items[] = [
        'label' => get_the_title(),
        'url' => '',
    ];
} elseif (is_category() || is_tag() || is_tax()) {
    $term = get_queried_object();

    if ($term instanceof WP_Term) {
        $items[] = [
            'label' => $term->name,
            'url' => '',
        ];
    }
} elseif (is_archive()) {
    $items[] = [
        'label' => get_the_archive_title(),
        'url' => '',
    ];
} elseif (is_search()) {
    $items[] = [
        'label' => sprintf(__('Поиск: %s', 'jullybride'), get_search_query()),
        'url' => '',
    ];
} else {
    return;
}

if (count($items) < 2) {
    return;
}

$last_index = count($items) - 1;
?>
<nav class="jb-breadcrumbs" aria-label="<?php echo esc_attr__('Хлебные крошки', 'jullybride'); ?>">
    <?php foreach ($items as $index => $item) : ?>
        <?php if ($index > 0) : ?>
            <span class="jb-breadcrumbs__separator">/</span>
        <?php endif; ?>

        <?php if (!empty($item['url']) && $index !== $last_index) : ?>
            <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
        <?php else : ?>
            <span><?php echo esc_html($item['label']); ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>

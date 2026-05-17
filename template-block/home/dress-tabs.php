<?php
if (!defined('ABSPATH')) {
    exit;
}

$taxonomy_filter = static function (string $taxonomy, string $name, ?string $slug = null): array {
    return [
        'taxonomy' => $taxonomy,
        'name' => $name,
        'slug' => $slug ?: sanitize_title($name),
    ];
};

$groups = [
    [
        'label' => 'Силуэт',
        'catalog_url' => '/c/wedding/?_f=1&_silhouette=a-line%2Cempire%2Csuit%2Cprincess%2Cstraight%2Clush%2Cmermaid%2Ctransformer%2Csheath',
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
        'catalog_url' => '/c/wedding/?_length=dlinnoe%2Cmidi%2Cmini&_f=1',
        'main_category' => 'wedding',
        'items' => [
            ['id' => 10, 'label' => 'Длинные', 'category' => 'long', 'filter' => $taxonomy_filter('length', 'Длинное', 'dlinnoe')],
            ['id' => 11, 'label' => 'Миди', 'category' => 'midi', 'filter' => $taxonomy_filter('length', 'Миди', 'midi')],
            ['id' => 12, 'label' => 'Мини', 'category' => 'mini', 'filter' => $taxonomy_filter('length', 'Мини', 'mini')],
        ],
    ],
    [
        'label' => 'Стиль',
        'catalog_url' => '/c/wedding/?_style=boho%2Cvintage%2Clace%2Csparkle%2Cminimalism%2Csimple&_f=1',
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
        'catalog_url' => '/c/wedding/open-back/?_backdress=closed%2Copen&_f=1&_decollete=s-v-vyrezom%2Clow-necked&_corset=corset&_slit=slit',
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
        'catalog_url' => '/c/evening/?_silhouette=a-line%2Cempire%2Csuit%2Cstraight%2Clush%2Cmermaid&_f=1',
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
    $attribute_taxonomy = 'pa_' . $taxonomy;

    if (taxonomy_exists($attribute_taxonomy)) {
        return $attribute_taxonomy;
    }

    return taxonomy_exists($taxonomy) ? $taxonomy : '';
};

$query_args = static function (array $item, string $main_category) use ($resolve_taxonomy): array {
    $args = [
        'post_type' => 'product',
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
    ];

    $legacy_category = $item['category'] ?? '';
    if ($legacy_category && get_term_by('slug', $legacy_category, 'product_cat')) {
        $args['product_cat'] = $legacy_category;
        return $args;
    }

    $tax_query = ['relation' => 'AND'];

    if ($main_category && get_term_by('slug', $main_category, 'product_cat')) {
        $tax_query[] = [
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => [$main_category],
        ];
    }

    if (!empty($item['filter'])) {
        $taxonomy = $resolve_taxonomy($item['filter']['taxonomy']);

        if ($taxonomy) {
            $tax_query[] = [
                'taxonomy' => $taxonomy,
                'field' => 'name',
                'terms' => [$item['filter']['name']],
            ];
        }
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    return $args;
};
?>
<section class="tabs-box">
    <a href="#" class="tabs-box-svg1">
        <img src="<?php echo esc_url(jullybride_asset_uri('images/kak-vybratь-to-samoe.svg')); ?>" alt="Как выбрать то самое?">
    </a>
    <img class="tabs-box-svg2 d-none d-md-block" src="<?php echo esc_url(jullybride_asset_uri('images/nashey-atmosfere-zaviduyut.svg')); ?>" alt="">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="section-subtitle d-block text-center">Выбери свое идеальное</span>
                <h2 class="section-title text-center font-title">свадебное платье</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <ul class="tabs-list d-md-flex d-none align-items-center">
            <?php foreach ($groups as $group_index => $group) : ?>
                <li class="<?php echo $group_index === 0 ? 'active' : ''; ?>"><?php echo esc_html($group['label']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="slides-tabs">
        <?php foreach ($groups as $group_index => $group) : ?>
            <span class="d-md-none d-block mobile-tab-wrap<?php echo $group_index === 0 ? ' active' : ''; ?>">
                <span class="mobile-tab"><?php echo esc_html($group['label']); ?></span>
            </span>
            <div class="container taab">
                <div class="row mobile-direction">
                    <div class="col-md-10">
                        <div class="tabs-content">
                            <div class="tabs-carusel">
                                <?php foreach ($group['items'] as $item_index => $item) : ?>
                                    <?php $carousel_id = (int) $item['id']; ?>
                                    <div class="tab-content<?php echo $item_index === 0 ? ' active' : ''; ?>">
                                        <div class="mobile-dots d-flex d-md-none justify-content-between">
                                            <a href="javascript:void(0)" id="mobile-dots-prev<?php echo esc_attr($carousel_id); ?>"></a>
                                            <a href="javascript:void(0)" id="mobile-dots-next<?php echo esc_attr($carousel_id); ?>"></a>
                                        </div>
                                        <ul class="owl-carousel owl-theme tabs-carusel_list" id="tabs-carusel_<?php echo esc_attr($carousel_id); ?>">
                                            <?php
                                            $products = new WP_Query($query_args($item, $group['main_category'] ?? 'wedding'));
                                            if ($products->have_posts()) :
                                                while ($products->have_posts()) :
                                                    $products->the_post();
                                                    $product = wc_get_product(get_the_ID());
                                                    jullybride_template_part('home/dress-tab-product-card', ['product' => $product]);
                                                endwhile;
                                                wp_reset_postdata();
                                            endif;
                                            ?>
                                        </ul>
                                        <div class="tabs-carusel_dot d-none d-md-table">
                                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev" id="tabs-carusel_prev_<?php echo esc_attr($carousel_id); ?>"></a>
                                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_next" id="tabs-carusel_next_<?php echo esc_attr($carousel_id); ?>"></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="<?php echo esc_attr($group['sidebar_class'] ?? 'col-12 col-md-2 position-relative'); ?>">
                        <ul class="categories-list">
                            <?php foreach ($group['items'] as $item_index => $item) : ?>
                                <li class="<?php echo $item_index === 0 ? 'active ' : ''; ?>tab-trigger"><a href="javascript:void(0)"><?php echo esc_html($item['label']); ?></a></li>
                            <?php endforeach; ?>
                            <li class="d-md-none d-block"><a href="<?php echo esc_url($group['catalog_url']); ?>">Смотреть все</a></li>
                        </ul>
                        <a href="<?php echo esc_url($group['catalog_url']); ?>" class="button-main-main-bg theme-button d-md-block d-none text-center custom-btn">Перейти в каталог</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="#" class="tabs-box-svg3 d-none d-md-block">
        <img src="<?php echo esc_url(jullybride_asset_uri('images/branchi-1.svg')); ?>" alt="">
    </a>
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$context_product = $args['product'] ?? null;

if (!$context_product instanceof WC_Product) {
    return;
}

$current_product_id = $context_product->get_id();
$type = function_exists('get_field') ? (string) get_field('tip_tovara', $current_product_id) : '';
$type = trim((string) preg_replace('/\s+/u', ' ', $type));

$type_to_category = [
    'свадебное платье' => 'wedding',
    'свадебный костюм' => 'wedding',
    'свадебный комбинезон' => 'wedding',
    'свадебный комплект' => 'wedding',
    'свадебные шорты' => 'wedding',
    'юбка' => 'wedding',
    'топ' => 'wedding',
    'вечернее платье' => 'evening',
    'комбинезон' => 'evening',
    'туфли' => 'shoes',
    'фата' => 'veils',
    'фаты' => 'veils',
    'украшения' => 'jewelry',
    'серьги' => 'jewelry',
    'подвеска' => 'jewelry',
    'колье' => 'jewelry',
    'чокер' => 'jewelry',
    'диадема' => 'jewelry',
    'цветок на шею' => 'jewelry',
    'верхняя одежда' => 'outerwear',
    'жакет' => 'outerwear',
    'болеро' => 'outerwear',
    'кейп' => 'outerwear',
    'косуха' => 'outerwear',
    'шубка' => 'outerwear',
    'накидка' => 'outerwear',
    'нижнее белье' => 'morning',
    'нижнее белье с пеньюаром' => 'morning',
    'пеньюар' => 'morning',
    'комплект' => 'morning',
    'боди' => 'morning',
    'сорочка' => 'morning',
    'рубашка' => 'morning',
    'корсет' => 'morning',
    'блуза' => 'morning',
    'pink мерч' => 'pink-merch',
    'косметика' => 'cosmetics',
    'крем' => 'cosmetics',
    'патчи' => 'cosmetics',
    'бьюти бокс' => 'cosmetics',
    'перчатки' => 'accessories',
    'перчатки свадебные' => 'accessories',
    'сумка' => 'accessories',
    'шлейф' => 'accessories',
    'аксессуары' => 'accessories',
    'тариф лагерь' => 'tariffs',
];

$category = null;
$type_key = function_exists('mb_strtolower') ? mb_strtolower($type) : strtolower($type);
$category_slug = $type_to_category[$type_key] ?? '';

if ($category_slug) {
    $resolved_category = get_term_by('slug', $category_slug, 'product_cat');
    if ($resolved_category instanceof WP_Term) {
        $category = $resolved_category;
    }
}

if (!$category instanceof WP_Term && function_exists('jullybride_get_main_product_category')) {
    $category = jullybride_get_main_product_category($current_product_id);
}

$products = [];

$collect_products = static function (array $query_args) use ($current_product_id): array {
    $query = new WP_Query(array_merge([
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'post__not_in' => [$current_product_id],
        'orderby' => 'rand',
        'fields' => 'ids',
    ], $query_args));

    $items = [];
    foreach ($query->posts as $product_id) {
        $similar_product = wc_get_product($product_id);
        if ($similar_product instanceof WC_Product && $similar_product->is_visible()) {
            $items[] = $similar_product;
        }
    }
    wp_reset_postdata();

    return $items;
};

if ($type) {
    $query_args = [
        'meta_query' => [
            [
                'key' => 'tip_tovara',
                'value' => $type,
                'compare' => 'LIKE',
            ],
        ],
    ];

    if ($category instanceof WP_Term) {
        $query_args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => [$category->term_id],
            ],
        ];
    }

    $products = $collect_products($query_args);
}

if (!$products && $category instanceof WP_Term) {
    $products = $collect_products([
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => [$category->term_id],
            ],
        ],
    ]);
}

if (!$products) {
    return;
}
?>
<section class="new-in-salon new-in-salon2 new-in-salon3 position-relative product-new-in-salon">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="section-subtitle d-block text-center">рекомендуем</span>
                <h2 class="section-title text-center font-title">Похожие товары</h2>
            </div>
        </div>
        <div class="row margin-bottom-80">
            <div class="col-12">
                <div class="new-in-salon-carusel">
                    <ul class="owl-carousel owl-theme owl-list" id="similar-products-carusel">
                        <?php foreach ($products as $similar_product) : ?>
                            <?php jullybride_template_part('common/product-carousel-card-legacy', ['product' => $similar_product]); ?>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tabs-carusel_dot new-in-salon-carusel_dot d-md-table d-none">
                        <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev custom_btn" id="similar-products_prev"></a>
                        <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_next custom_btn" id="similar-products_next"></a>
                    </div>
                </div>
            </div>
            <div class="mobile-dots d-flex d-md-none justify-content-between">
                <a href="javascript:void(0)" id="similar-products-carusel_prev1"></a>
                <a href="javascript:void(0)" id="similar-products-carusel_next1"></a>
            </div>
        </div>
    </div>
</section>

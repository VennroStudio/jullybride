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
$category = function_exists('jullybride_product_primary_category') ? jullybride_product_primary_category($current_product_id) : null;

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
                            <?php jullybride_template_part('components/product-carousel-card', ['product' => $similar_product]); ?>
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

<?php
if (!defined('ABSPATH')) {
    exit;
}

$sale_ids = function_exists('wc_get_product_ids_on_sale') ? array_map('absint', wc_get_product_ids_on_sale()) : [];
$query_args = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 18,
    'orderby' => 'post__in',
    'post__in' => $sale_ids ?: [0],
    'no_found_rows' => true,
];

if (!$sale_ids) {
    $query_args['orderby'] = ['date' => 'DESC'];
    unset($query_args['post__in']);
}

$products = new WP_Query($query_args);

if (!$products->have_posts()) {
    wp_reset_postdata();
    return;
}

$product_ids = wp_list_pluck($products->posts, 'ID');

if (function_exists('jullybride_prime_product_caches')) {
    jullybride_prime_product_caches($product_ids);
}

$products_by_id = [];
foreach ($product_ids as $product_id) {
    $product = wc_get_product((int) $product_id);

    if ($product instanceof WC_Product) {
        $products_by_id[(int) $product_id] = $product;
    }
}

if (function_exists('jullybride_prime_product_image_caches')) {
    jullybride_prime_product_image_caches(array_values($products_by_id));
}
?>
<section class="jb-stock-products">
    <h2 class="jb-display-title font-title">Товары со скидками</h2>
    <div class="row products-list">
        <?php $index = 0; ?>
        <?php while ($products->have_posts()) : $products->the_post(); ?>
            <?php
            $product = $products_by_id[get_the_ID()] ?? null;
            if ($product) {
                jullybride_template_part('components/product-card', ['product' => $product, 'index' => $index]);
                $index++;
            }
            ?>
        <?php endwhile; ?>
    </div>
</section>
<?php wp_reset_postdata(); ?>

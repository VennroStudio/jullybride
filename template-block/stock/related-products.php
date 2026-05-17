<?php
if (!defined('ABSPATH')) {
    exit;
}

$sale_ids = function_exists('wc_get_product_ids_on_sale') ? array_map('absint', wc_get_product_ids_on_sale()) : [];

if (!$sale_ids) {
    return;
}

$products = new WP_Query([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'post__in' => $sale_ids,
    'orderby' => 'post__in',
]);

if (!$products->have_posts()) {
    wp_reset_postdata();
    return;
}
?>
<section class="jb-stock-products jb-stock-products--related">
    <h2>Товары по акции</h2>
    <div class="row products-list">
        <?php $index = 0; ?>
        <?php while ($products->have_posts()) : $products->the_post(); ?>
            <?php
            $product = wc_get_product(get_the_ID());
            if ($product) {
                jullybride_template_part('common/product-card-legacy', ['product' => $product, 'index' => $index]);
                $index++;
            }
            ?>
        <?php endwhile; ?>
    </div>
</section>
<?php wp_reset_postdata(); ?>

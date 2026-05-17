<?php
if (!defined('ABSPATH')) {
    exit;
}

$sale_ids = function_exists('wc_get_product_ids_on_sale') ? array_map('absint', wc_get_product_ids_on_sale()) : [];
$query_args = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 9,
    'orderby' => ['date' => 'DESC'],
];

if ($sale_ids) {
    $query_args['post__in'] = $sale_ids;
    $query_args['orderby'] = 'post__in';
}

$products = new WP_Query($query_args);

if (!$products->have_posts()) {
    wp_reset_postdata();
    return;
}
?>
<section class="jb-404-products">
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

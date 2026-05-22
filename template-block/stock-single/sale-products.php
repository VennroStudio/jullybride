<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once JULLYBRIDE_THEME_DIR . '/template-block/stock-single/helpers.php';

$sale_ids = function_exists('wc_get_product_ids_on_sale') ? array_map('absint', wc_get_product_ids_on_sale()) : [];
$title = (string) jullybride_stock_single_field('sale_products_title', get_the_ID(), 'Те самые платья');

if (!$sale_ids) {
    return;
}

$products = new WP_Query([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'post__in' => $sale_ids,
    'orderby' => 'post__in',
    'tax_query' => [
        [
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => ['wedding', 'evening'],
            'operator' => 'IN',
        ],
    ],
]);

if (!$products->have_posts()) {
    wp_reset_postdata();
    return;
}
?>
<section class="jb-stock-products jb-promo-sale-products">
    <h2 class="jb-display-title font-title"><?php echo esc_html($title); ?></h2>
    <div class="row products-list">
        <?php $index = 0; ?>
        <?php while ($products->have_posts()) : $products->the_post(); ?>
            <?php
            $product = wc_get_product(get_the_ID());
            if ($product) {
                jullybride_template_part('components/product-card', ['product' => $product, 'index' => $index]);
                $index++;
            }
            ?>
        <?php endwhile; ?>
    </div>
    <a href="<?php echo esc_url(home_url('/c/wedding/')); ?>" class="jb-promo-button jb-promo-sale-products__button">Все свадебные платья</a>
</section>
<?php wp_reset_postdata(); ?>

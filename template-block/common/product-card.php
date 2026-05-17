<?php
if (!defined('ABSPATH')) {
    exit;
}

$product = $args['product'] ?? wc_get_product(get_the_ID());
if (!$product instanceof WC_Product) {
    return;
}

$product_id = $product->get_id();
$sizes = jullybride_product_available_sizes($product_id);
?>
<article class="jb-product-card">
    <a class="jb-product-card__image" href="<?php echo esc_url(get_permalink($product_id)); ?>">
        <?php echo $product->get_image('jullybride-card'); ?>
    </a>
    <div class="jb-product-card__body">
        <a class="jb-product-card__title" href="<?php echo esc_url(get_permalink($product_id)); ?>"><?php echo esc_html($product->get_name()); ?></a>
        <div class="jb-product-card__price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
        <?php if ($sizes) : ?>
            <div class="jb-product-card__sizes"><?php echo esc_html(implode(', ', array_slice($sizes, 0, 8))); ?></div>
        <?php endif; ?>
    </div>
</article>


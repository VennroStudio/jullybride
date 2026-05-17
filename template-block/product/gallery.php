<?php
if (!defined('ABSPATH')) {
    exit;
}

$product = $args['product'] ?? wc_get_product(get_the_ID());
if (!$product instanceof WC_Product) {
    return;
}

$attachment_ids = jullybride_product_image_ids($product);
if (!$attachment_ids) {
    return;
}
?>
<div class="product-header-left_column">
    <ul class="owl-list owl-carousel owl-theme product-header_img" id="product-header_img">
        <?php foreach ($attachment_ids as $index => $attachment_id) : ?>
            <li class="<?php echo $index === 0 ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(wp_get_attachment_image_url($attachment_id, [1920, 1080])); ?>" class="product-header-main_foto fancybox" data-fancybox="product-gallery">
                    <?php
                    echo wp_get_attachment_image($attachment_id, 'product_detail', false, [
                        'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
                        'loading' => 'lazy',
                    ]);
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <ul class="owl-list product-header_prev-img">
        <?php foreach ($attachment_ids as $index => $attachment_id) : ?>
            <li class="<?php echo $index === 0 ? 'active' : ''; ?>">
                <a href="javascript:void(0)" data-index="<?php echo esc_attr($index); ?>">
                    <?php
                    echo wp_get_attachment_image($attachment_id, [150, 150], false, [
                        'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
                        'loading' => 'lazy',
                    ]);
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

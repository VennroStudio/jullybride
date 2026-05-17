<?php
if (!defined('ABSPATH')) {
    exit;
}

$product = $args['product'] ?? null;

if (!$product instanceof WC_Product) {
    return;
}

$product_id = $product->get_id();
?>
<li>
    <div class="tabs-carusel_image-wrap">
        <div class="tabs-carusel_image">
            <?php if ($product->get_regular_price() && (float) $product->get_regular_price() > (float) $product->get_price()) : ?>
                <div class="nameplate-sale"></div>
            <?php endif; ?>
            <?php
            echo wp_get_attachment_image(
                $product->get_image_id(),
                [300, 450],
                false,
                ['loading' => 'lazy']
            );
            ?>
            <div class="tabs-carusel_image-btn justify-content-around">
                <a href="javascript:void(0)" class="add-favorite woosw-btn" data-id="<?php echo esc_attr($product_id); ?>" data-product_name="<?php echo esc_attr($product->get_name()); ?>" aria-label=" "></a>
                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="theme-button button-main">Хочу примерить</a>
            </div>
            <?php if ($product->is_in_stock()) : ?>
                <span class="in-sklad">в наличии</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="tabs-carusel_data">
        <span class="tabs-carusel_data-cat d-block"><?php echo esc_html(jullybride_product_type_label($product_id)); ?></span>
        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="tabs-carusel_data-name d-block"><?php echo esc_html($product->get_name()); ?></a>
    </div>
    <div class="tabs-carusel_price text-center">
        <?php if ($product->get_regular_price() && (float) $product->get_regular_price() > (float) $product->get_price()) : ?>
            <span class="tabs-carusel_data-old-price"><?php echo esc_html(jullybride_format_price($product->get_regular_price())); ?></span>
        <?php endif; ?>
        <?php if ($product->get_price() !== '') : ?>
            <span class="tabs-carusel_data-price"><?php echo esc_html(jullybride_format_price($product->get_price())); ?></span>
        <?php endif; ?>
        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="link-item"></a>
    </div>
</li>

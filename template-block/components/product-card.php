<?php
if (!defined('ABSPATH')) {
    exit;
}

$product = $args['product'] ?? wc_get_product(get_the_ID());
$index = (int) ($args['index'] ?? 0);
$card_class = (string) ($args['class'] ?? 'col-md-4 col-6 products-list-item');

if (!$product instanceof WC_Product) {
    return;
}

$product_id = $product->get_id();
$attachment_ids = jullybride_product_image_ids($product);
$created = $product->get_date_created();
$days_ago = $created ? (time() - $created->getTimestamp()) / DAY_IN_SECONDS : 999;
?>
<div class="<?php echo esc_attr($card_class); ?>">
    <div class="position-relative product-carousel-wrapper">
        <?php if ($days_ago <= 30) : ?>
            <div class="products-list-item_shild products-list-item_shild-two"></div>
        <?php endif; ?>

        <?php if ($product->get_regular_price() && (float) $product->get_regular_price() > (float) $product->get_price()) : ?>
            <div class="products-list-item_shild products-list-item_shild-three"></div>
        <?php endif; ?>

        <a href="<?php echo esc_url($product->get_permalink()); ?>">
            <ul class="owl-list products-list-carusel owl-carousel owl-theme">
                <?php foreach ($attachment_ids as $attachment_id) : ?>
                    <?php $image = wp_get_attachment_image_src($attachment_id, [400, 600]); ?>
                    <?php if ($image) : ?>
                        <li>
                            <div class="products-list_img-row">
                                <img
                                    src="<?php echo esc_url($image[0]); ?>"
                                    alt="<?php echo esc_attr($product->get_name()); ?>"
                                    <?php echo $index <= 3 ? 'data-critical="true" rel="preload"' : 'loading="lazy"'; ?>
                                >
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </a>

        <?php if (count($attachment_ids) > 1) : ?>
            <a href="javascript:void(0)" class="products-nav products-nav-prev"></a>
            <a href="javascript:void(0)" class="products-nav products-nav-next"></a>
        <?php endif; ?>

        <?php if ($product->is_in_stock()) : ?>
            <span class="products-list-item_istock">в наличии</span>
        <?php endif; ?>

        <div class="products-list-item_btn">
            <a href="javascript:void(0)" class="products-list_favorite woosw-btn" data-id="<?php echo esc_attr($product_id); ?>" data-product_name="<?php echo esc_attr($product->get_name()); ?>" aria-label=" "></a>
            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="products-list_btn">Хочу примерить</a>
        </div>
        <div class="products-list_overlay"></div>
    </div>
    <div class="text-center products-list_data">
        <span class="d-block products-list_name"><?php echo esc_html(jullybride_product_type_label($product_id)); ?></span>
        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="d-table products-list_cat"><?php echo esc_html($product->get_name()); ?></a>
    </div>
    <div class="products-list_price position-relative">
        <?php if ($product->get_regular_price() && (float) $product->get_regular_price() > (float) $product->get_price()) : ?>
            <span class="products-list_price-old"><?php echo esc_html(jullybride_format_price($product->get_regular_price())); ?></span>
        <?php endif; ?>
        <?php if ($product->get_price() !== '') : ?>
            <span class="products-list_price-new">&nbsp;<?php echo esc_html(jullybride_format_price($product->get_price())); ?></span>
        <?php endif; ?>
        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="products-list_link"></a>
    </div>
</div>

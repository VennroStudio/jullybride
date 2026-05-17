<?php
if (!defined('ABSPATH')) {
    exit;
}

$product = $args['product'] ?? wc_get_product(get_the_ID());
if (!$product instanceof WC_Product) {
    return;
}
?>
<section class="product-header position-relative">
    <img src="<?php echo esc_url(jullybride_asset_uri('images/nashey-atmosfere-zaviduyut-1.svg')); ?>" class="product-header_svg1" alt="">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php jullybride_template_part('product/gallery', ['product' => $product]); ?>
            </div>
            <div class="col-md-6 product-header_right">
                <?php jullybride_template_part('product/summary', ['product' => $product]); ?>
            </div>
        </div>
    </div>
    <?php jullybride_template_part('product/fast-categories', ['product' => $product]); ?>
</section>


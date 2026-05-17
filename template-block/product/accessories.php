<?php
if (!defined('ABSPATH')) {
    exit;
}

$context_product = $args['product'] ?? null;
$current_id = $context_product instanceof WC_Product ? $context_product->get_id() : 0;
$categories = [
    'accessories' => 'Аксессуары',
    'outerwear' => 'Верхняя одежда',
    'veils' => 'Фаты',
    'cosmetics' => 'Косметика',
];
$products = [];
$seen_ids = [];

foreach ($categories as $slug => $label) {
    $category_products = wc_get_products([
        'category' => [$slug],
        'limit' => 3,
        'status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    foreach ($category_products as $category_product) {
        if (!$category_product instanceof WC_Product) {
            continue;
        }

        $product_id = $category_product->get_id();
        if ($product_id === $current_id || isset($seen_ids[$product_id])) {
            continue;
        }

        $seen_ids[$product_id] = true;
        $products[] = $category_product;
    }
}

if (!$products) {
    return;
}

$text_stroke = function_exists('get_field') ? (string) get_field('text_stroke', jullybride_home_source_id()) : '';
?>
<section class="only-have position-relative bg-main">
    <a href="<?php echo esc_url(home_url('/c/accessories/')); ?>">
        <img src="<?php echo esc_url(jullybride_asset_uri('images/rozovyy-merch.svg')); ?>" class="custom-rozovyy-merch" alt="">
    </a>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="section-subtitle d-block text-center">подойдет к этому товару</span>
                <h2 class="section-title text-center font-title">аксессуары</h2>
            </div>
        </div>
        <div class="row margin-bottom-80">
            <div class="col-12">
                <div class="new-in-salon-carusel">
                    <ul class="owl-carousel owl-theme owl-list" id="only-have-carusel">
                        <?php foreach ($products as $accessory_product) : ?>
                            <?php jullybride_template_part('common/product-carousel-card-legacy', ['product' => $accessory_product]); ?>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tabs-carusel_dot new-in-salon-carusel_dot d-md-table d-none">
                        <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev custom_btn" id="only-have_prev"></a>
                        <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_next custom_btn" id="only-have_next"></a>
                    </div>
                </div>
            </div>
            <div class="mobile-dots d-flex d-md-none justify-content-between">
                <a href="javascript:void(0)" id="only-have-carusel_prev1"></a>
                <a href="javascript:void(0)" id="only-have-carusel_next1"></a>
            </div>
        </div>
    </div>
    <div class="lenta-stroke2 z-index-0">
        <svg width="100%" height="180" viewBox="0 0 1920 180" preserveAspectRatio="none">
            <path d="M0,40 C250,-20 500,100 750,40 C1000,-20 1250,100 1500,40 C1700,-20 1850,100 1920,40 L1920,80 C1850,140 1700,20 1500,80 C1250,140 1000,20 750,80 C500,140 250,20 0,80 Z" fill="rgba(24, 24, 24, 1)" />
            <path id="text-path-accessories" d="M0,60 C250,0 500,120 750,60 C1000,0 1250,120 1500,60 C1700,0 1850,120 1920,60" stroke="none" fill="none" />
            <text font-size="14" fill="#fde5ec" text-anchor="middle" letter-spacing="1" id="svg_text_accessories" dy="5">
                <textPath href="#text-path-accessories" startOffset="50%"><?php echo esc_html($text_stroke); ?><animate attributeName="startOffset" from="100%" to="-100%" dur="120s" repeatCount="indefinite" /></textPath>
            </text>
        </svg>
    </div>
</section>

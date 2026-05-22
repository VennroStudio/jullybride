<?php
if (!defined('ABSPATH')) {
    exit;
}

$field = (string) ($args['field'] ?? '');

$rows = $field && function_exists('get_field') ? get_field($field) : [];

if (!$field || !$rows || !is_array($rows)) {
    return;
}

$carousel_id = (string) ($args['carousel_id'] ?? $field);
$desktop_prev_id = (string) ($args['desktop_prev_id'] ?? $carousel_id . '_prev');
$desktop_next_id = (string) ($args['desktop_next_id'] ?? $carousel_id . '_next');
$mobile_prev_id = (string) ($args['mobile_prev_id'] ?? $carousel_id . '_prev1');
$mobile_next_id = (string) ($args['mobile_next_id'] ?? $carousel_id . '_next1');
$desktop_prev_class = (string) ($args['desktop_prev_class'] ?? 'tabs-carusel_nav tabs-carusel_prev custom_btn');
$desktop_next_class = (string) ($args['desktop_next_class'] ?? 'tabs-carusel_nav tabs-carusel_next custom_btn');
$before_carousel = (string) ($args['before_carousel'] ?? '');
$button_url = (string) ($args['button_url'] ?? '');
$button_text = (string) ($args['button_text'] ?? 'перейти в каталог');
$card_args = [
    'badge_class' => (string) ($args['badge_class'] ?? 'nameplate-sale2'),
    'name_color' => (string) ($args['name_color'] ?? '#181818'),
];

$product_ids = [];
foreach ($rows as $row) {
    $product_value = is_array($row) ? ($row['id'] ?? 0) : 0;

    if ($product_value instanceof WC_Product) {
        $product_ids[] = $product_value->get_id();
    } elseif ($product_value instanceof WP_Post) {
        $product_ids[] = (int) $product_value->ID;
    } else {
        $product_ids[] = (int) $product_value;
    }
}

if (function_exists('jullybride_prime_product_caches')) {
    jullybride_prime_product_caches($product_ids);
}

$products_by_id = [];
foreach (array_values(array_unique(array_filter(array_map('absint', $product_ids)))) as $product_id) {
    $product = wc_get_product($product_id);

    if ($product instanceof WC_Product) {
        $products_by_id[$product_id] = $product;
    }
}

if (function_exists('jullybride_prime_product_image_caches')) {
    jullybride_prime_product_image_caches(array_values($products_by_id));
}
?>
<div class="row margin-bottom-80">
    <div class="col-12">
        <?php echo wp_kses_post($before_carousel); ?>
        <div class="new-in-salon-carusel">
            <ul class="owl-carousel owl-theme owl-list" id="<?php echo esc_attr($carousel_id); ?>">
                <?php foreach ($rows as $row) : ?>
                    <?php
                    if (!is_array($row)) {
                        continue;
                    }

                    $product_value = $row['id'] ?? 0;
                    if ($product_value instanceof WC_Product) {
                        $product = $product_value;
                    } else {
                        $product_id = $product_value instanceof WP_Post ? (int) $product_value->ID : (int) $product_value;
                        $product = $products_by_id[$product_id] ?? null;
                    }

                    if (!$product instanceof WC_Product) {
                        continue;
                    }

                    jullybride_template_part('components/product-carousel-card', array_merge($card_args, [
                        'product' => $product,
                        'show_badge' => !empty($row['shildik']),
                    ]));
                    ?>
                <?php endforeach; ?>
            </ul>
            <div class="tabs-carusel_dot new-in-salon-carusel_dot d-none d-md-table">
                <a href="javascript:void(0)" class="<?php echo esc_attr($desktop_prev_class); ?>" id="<?php echo esc_attr($desktop_prev_id); ?>"></a>
                <a href="javascript:void(0)" class="<?php echo esc_attr($desktop_next_class); ?>" id="<?php echo esc_attr($desktop_next_id); ?>"></a>
            </div>
        </div>
    </div>
    <div class="mobile-dots d-flex d-md-none justify-content-between">
        <a href="javascript:void(0)" id="<?php echo esc_attr($mobile_prev_id); ?>"></a>
        <a href="javascript:void(0)" id="<?php echo esc_attr($mobile_next_id); ?>"></a>
    </div>
</div>
<?php if ($button_url) : ?>
    <div class="row">
        <div class="col-12 d-flex justify-content-center position-relative">
            <a href="<?php echo esc_url($button_url); ?>" class="theme-button button-main custom_main_btn"><?php echo esc_html($button_text); ?></a>
        </div>
    </div>
<?php endif; ?>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$field = (string) ($args['field'] ?? '');

if (!$field || !function_exists('have_rows') || !have_rows($field)) {
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
?>
<div class="row margin-bottom-80">
    <div class="col-12">
        <?php echo wp_kses_post($before_carousel); ?>
        <div class="new-in-salon-carusel">
            <ul class="owl-carousel owl-theme owl-list" id="<?php echo esc_attr($carousel_id); ?>">
                <?php while (have_rows($field)) : ?>
                    <?php
                    the_row();
                    $product_id = (int) get_sub_field('id');
                    $product = $product_id ? wc_get_product($product_id) : null;

                    if (!$product instanceof WC_Product) {
                        continue;
                    }

                    jullybride_template_part('home/product-carousel-card', array_merge($card_args, [
                        'product' => $product,
                        'show_badge' => (bool) get_sub_field('shildik'),
                    ]));
                    ?>
                <?php endwhile; ?>
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

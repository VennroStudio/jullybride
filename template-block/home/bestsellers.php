<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('have_rows') || !have_rows('bestsellers')) {
    return;
}
?>
<section class="new-in-salon position-relative new-in-salon-custom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="section-subtitle d-block text-center">выбор невест</span>
                <h2 class="section-title text-center font-title">бестселлеры</h2>
            </div>
        </div>
        <?php
        jullybride_template_part('home/product-carousel', [
            'field' => 'bestsellers',
            'carousel_id' => 'bestsellers',
            'desktop_prev_id' => 'bestsellers_prev',
            'desktop_next_id' => 'bestsellers_next',
            'mobile_prev_id' => 'bestsellers_prev1',
            'mobile_next_id' => 'bestsellers_next1',
            'badge_class' => 'nameplate-sale2 nameplate-sale3',
            'button_url' => '/c/wedding/',
        ]);
        ?>
    </div>
    <img class="new-in-salon1 d-block d-md-none" src="<?php echo esc_url(jullybride_asset_uri('images/schastliva.svg')); ?>" alt="">
</section>

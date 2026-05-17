<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('have_rows') || !have_rows('new')) {
    return;
}
?>
<section class="new-in-salon new-in-salon2 new-in-salon3 position-relative">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="section-subtitle d-block text-center">самые ожидаемые и трендовые</span>
                <h2 class="section-title text-center font-title">новинки в салоне</h2>
            </div>
        </div>
        <?php
        jullybride_template_part('home/product-carousel', [
            'field' => 'new',
            'carousel_id' => 'new-in-salon-carusel',
            'desktop_prev_id' => 'new-in-salon-carusel_prev_1',
            'desktop_next_id' => 'new-in-salon-carusel_next_1',
            'mobile_prev_id' => 'new-in-salon-carusel-prev1',
            'mobile_next_id' => 'new-in-salon-carusel-next1',
            'badge_class' => 'nameplate-sale2',
            'button_url' => '/c/wedding/',
        ]);
        ?>
    </div>
    <a href="" class="new-in-salon-svg1">
        <img src="<?php echo esc_url(jullybride_asset_uri('images/branchi-i-platьya.svg')); ?>" alt="">
    </a>
</section>

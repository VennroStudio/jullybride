<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('have_rows') || !have_rows('new_in_salon_two')) {
    return;
}
?>
<section class="new-in-salon new-in-salon-two position-relative">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="section-subtitle d-block text-center">самый большой выбор</span>
                <h2 class="section-title text-center font-title">вечерних платьев</h2>
            </div>
        </div>
        <?php
        jullybride_template_part('components/product-carousel', [
            'field' => 'new_in_salon_two',
            'carousel_id' => 'new-in-salon-two',
            'desktop_prev_id' => 'new-in-salon-two-prev',
            'desktop_next_id' => 'new-in-salon-two-next',
            'desktop_prev_class' => 'tabs-carusel_nav tabs-carusel_prev',
            'desktop_next_class' => 'tabs-carusel_nav tabs-carusel_next',
            'mobile_prev_id' => 'new-in-salon-two_prev1',
            'mobile_next_id' => 'new-in-salon-two_next1',
            'badge_class' => 'nameplate-sale2',
            'button_url' => '/c/evening/',
        ]);
        ?>
    </div>
</section>

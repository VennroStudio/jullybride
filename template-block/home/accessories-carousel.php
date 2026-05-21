<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('have_rows') || !have_rows('only_have')) {
    return;
}
?>
<section class="only-have position-relative couture-only-have">
    <div class="container">
        <?php
        jullybride_template_part('components/product-carousel', [
            'field' => 'only_have',
            'carousel_id' => 'only-have-carusel',
            'desktop_prev_id' => 'only-have_prev',
            'desktop_next_id' => 'only-have_next',
            'mobile_prev_id' => 'only-have-carusel_prev1',
            'mobile_next_id' => 'only-have-carusel_next1',
            'badge_class' => 'nameplate-sale2 nameplate-sale3',
            'name_color' => '#f5cdcb',
            'button_url' => '/c/wedding/',
            'before_carousel' => '<img class="d-md-none d-block couture-only-have-img" src="' . esc_url(jullybride_asset_uri('images/group-1233.svg')) . '" alt="">',
        ]);
        ?>
    </div>
    <?php
    jullybride_template_part('components/floating-strip', [
        'class' => 'lenta-stroke2 z-index-0',
        'text' => (string) get_field('text_stroke'),
    ]);
    ?>
</section>

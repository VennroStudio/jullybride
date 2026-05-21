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
    <div class="lenta-stroke2 z-index-0">
        <svg width="100%" height="180" viewBox="0 0 1920 180" preserveAspectRatio="none">
            <path d="M0,40 C250,-20 500,100 750,40 C1000,-20 1250,100 1500,40 C1700,-20 1850,100 1920,40 L1920,80 C1850,140 1700,20 1500,80 C1250,140 1000,20 750,80 C500,140 250,20 0,80 Z" fill="rgba(24, 24, 24, 1)" />
            <path id="text-path-accessories-home" d="M0,60 C250,0 500,120 750,60 C1000,0 1250,120 1500,60 C1700,0 1850,120 1920,60" stroke="none" fill="none" />
            <text font-size="14" fill="#fde5ec" text-anchor="middle" letter-spacing="1" id="svg_text_3" dy="5">
                <textPath href="#text-path-accessories-home" startOffset="50%"><?php echo esc_html(get_field('text_stroke')); ?><animate attributeName="startOffset" from="100%" to="-100%" dur="120s" repeatCount="indefinite" /></textPath>
            </text>
        </svg>
    </div>
</section>

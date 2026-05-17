<?php
if (!defined('ABSPATH')) {
    exit;
}

$home_source_id = jullybride_home_source_id();
$box_important = function_exists('get_field') ? get_field('box_important', $home_source_id) : [];
$video_important = function_exists('get_field') ? get_field('video_important', $home_source_id) : '';
$text_stroke = function_exists('get_field') ? get_field('text_stroke', $home_source_id) : '';
?>
<section class="box-important position-relative">
    <div class="container position-relative z-index-1">
        <div class="row align-items-end">
            <div class="col-md-4">
                <?php if ($box_important) : ?>
                    <?php foreach ($box_important as $item) : ?>
                        <div class="box-important_item1 text-center">
                            <span class="box-important_item1-title font-cursive d-block text-center"><?php echo esc_html($item['title'] ?? ''); ?></span>
                            <span class="box-important_item1-desc"><?php echo esc_html($item['text'] ?? ''); ?></span>
                            <div><img src="<?php echo esc_url(jullybride_asset_uri('images/vector-11.svg')); ?>" alt=""></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <div class="box-important_item2">
                    <?php if ($video_important) : ?>
                        <video data-src="<?php echo esc_url($video_important); ?>" poster="<?php echo esc_url(jullybride_asset_uri('images/galereya1.webp')); ?>" autoplay muted playsinline loop class="bg-video lazy-video">
                            Ваш браузер не поддерживает видео.
                        </video>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box-important_item3 d-flex justify-content-center align-items-center">
                    <div class="position-relative">
                        <span class="box-important_item3-cursive font-cursive d-block">“то самое”</span>
                        <span class="box-important_item3-title font-title d-block">совсем близко</span>
                    </div>
                    <span class="box-important_item3-desc">Ты находишься в одном шаге<br> от знакомства с платьем мечты!</span>
                    <a href="javascript:void(0)" class="button-main-main-bg theme-button d-table ms_booking">Записаться на примерку</a>
                </div>
            </div>
        </div>
    </div>
    <div class="lenta-stroke2 z-index-0">
        <svg width="100%" height="180" viewBox="0 0 1920 180" preserveAspectRatio="none">
            <path d="M0,40 C250,-20 500,100 750,40 C1000,-20 1250,100 1500,40 C1700,-20 1850,100 1920,40 L1920,80 C1850,140 1700,20 1500,80 C1250,140 1000,20 750,80 C500,140 250,20 0,80 Z" fill="rgba(24, 24, 24, 1)" />
            <path id="text-path-important" d="M0,60 C250,0 500,120 750,60 C1000,0 1250,120 1500,60 C1700,0 1850,120 1920,60" stroke="none" fill="none" />
            <text font-size="14" fill="#fde5ec" text-anchor="middle" letter-spacing="1" id="svg_text_4" dy="5">
                <textPath href="#text-path-important" startOffset="50%"><?php echo esc_html($text_stroke); ?><animate attributeName="startOffset" from="100%" to="-100%" dur="120s" repeatCount="indefinite" /></textPath>
            </text>
        </svg>
    </div>
    <img class="box-important-svg1 d-none d-md-block" src="<?php echo esc_url(jullybride_asset_uri('images/2000.svg')); ?>" alt="">
</section>

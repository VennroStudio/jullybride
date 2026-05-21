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
    <?php
    jullybride_template_part('components/floating-strip', [
        'class' => 'lenta-stroke2 z-index-0',
        'text' => (string) $text_stroke,
    ]);
    ?>
    <img class="box-important-svg1 d-none d-md-block" src="<?php echo esc_url(jullybride_asset_uri('images/2000.svg')); ?>" alt="">
</section>

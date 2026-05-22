<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once JULLYBRIDE_THEME_DIR . '/template-block/stock-single/helpers.php';

$post_id = get_the_ID();
$title = (string) jullybride_stock_single_field('sale_video_title', $post_id, 'Оh, girls! Смотрите, как это весело!');
$videos = jullybride_stock_single_video_urls($post_id);
$decor = content_url('uploads/2023/09/jully_video_cover-1.svg');
?>
<section class="jb-promo-videos">
    <div class="jb-promo-section__inner">
        <h2><?php echo esc_html($title); ?></h2>

        <div class="jb-promo-videos__carousel" data-jb-promo-video-carousel>
            <div class="jb-promo-videos__track" data-jb-promo-video-track>
                <?php foreach ($videos as $index => $video) : ?>
                    <div class="jb-promo-video-card">
                        <video controls preload="metadata" playsinline>
                            <source src="<?php echo esc_url($video); ?>" type="video/mp4">
                        </video>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="jb-promo-carousel-arrow jb-promo-carousel-arrow--next" type="button" data-jb-promo-video-next aria-label="Следующее видео">›</button>
        </div>

        <img class="jb-promo-videos__decor" src="<?php echo esc_url($decor); ?>" alt="" loading="lazy" aria-hidden="true">
    </div>
</section>

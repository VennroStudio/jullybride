<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = [
    ['image' => 59018, 'video' => 60695, 'count' => '214 тыс.'],
    ['image' => 59011, 'video' => 60702, 'count' => '29,4 тыс.'],
    ['image' => 59012, 'video' => 60704, 'count' => '1,9 млн'],
    ['image' => 59013, 'video' => 60705, 'count' => '2,8 млн'],
    ['image' => 59014, 'video' => 60706, 'count' => '654 тыс.'],
    ['image' => 59015, 'video' => 60707, 'count' => '1,1 млн'],
    ['image' => 59010, 'video' => 60711, 'count' => '302 тыс.'],
    ['image' => 59017, 'video' => 60710, 'count' => '875 тыс.'],
];
?>
<section class="franchise-social franchise-section">
    <div class="franchise-social__rail" aria-label="Примеры контента Jully Bride">
        <?php foreach ($items as $item) : ?>
            <button class="franchise-social__item" type="button" data-jb-franchise-video="<?php echo esc_url(jullybride_franchise_video_url((int) $item['video'])); ?>" aria-label="<?php echo esc_attr('Открыть видео Jully Bride, ' . $item['count']); ?>">
                <?php jullybride_franchise_image($item['image'], '', 'Контент Jully Bride'); ?>
                <span class="franchise-social__play" aria-hidden="true"></span>
                <span class="franchise-social__caption"><?php echo esc_html($item['count']); ?></span>
            </button>
        <?php endforeach; ?>
    </div>
</section>

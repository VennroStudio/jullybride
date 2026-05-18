<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = [
    ['image' => 59018, 'count' => '214 тыс.'],
    ['image' => 59011, 'count' => '29,4 тыс.'],
    ['image' => 59012, 'count' => '1,9 млн'],
    ['image' => 59013, 'count' => '2,8 млн'],
    ['image' => 59014, 'count' => '654 тыс.'],
    ['image' => 59015, 'count' => '1,1 млн'],
];
?>
<section class="franchise-social franchise-section">
    <div class="franchise-social__rail" aria-label="Примеры контента Jully Bride">
        <?php foreach ($items as $item) : ?>
            <figure class="franchise-social__item">
                <?php jullybride_franchise_image($item['image'], '', 'Контент Jully Bride'); ?>
                <span class="franchise-social__play" aria-hidden="true"></span>
                <figcaption><?php echo esc_html($item['count']); ?></figcaption>
            </figure>
        <?php endforeach; ?>
    </div>
</section>

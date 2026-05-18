<?php
if (!defined('ABSPATH')) {
    exit;
}

$stats = [
    ['value' => '80+ тыс.', 'label' => 'Подписчиков в социальных сетях'],
    ['value' => '10+', 'label' => 'Коллабораций с блогерами и другими брендами ежемесячно'],
    ['value' => '30 000+', 'label' => 'Охват пользовательского контента, отметки и обзоры Jully Bride'],
    ['value' => '1+ млн.', 'label' => 'Охватов в социальных сетях'],
];
?>
<section class="franchise-visibility franchise-section">
    <div class="franchise-container franchise-visibility__grid">
        <div class="franchise-visibility__content">
            <p class="franchise-eyebrow">Вас заметят</p>
            <h2>Благодаря узнаваемости бренда в соцсетях</h2>
            <p class="franchise-visibility__wow">Wow!</p>
            <div class="franchise-visibility__stats">
                <?php foreach ($stats as $stat) : ?>
                    <div class="franchise-stat">
                        <strong><?php echo esc_html($stat['value']); ?></strong>
                        <span><?php echo esc_html($stat['label']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="franchise-phone">
            <?php jullybride_franchise_image(53226, 'franchise-phone__image', 'Контент Jully Bride'); ?>
        </div>
    </div>
</section>

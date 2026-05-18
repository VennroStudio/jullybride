<?php
if (!defined('ABSPATH')) {
    exit;
}

$steps = [
    ['title' => 'Заявка', 'text' => 'Вы оставляете заявку, а мы знакомимся с вашим городом и задачами.'],
    ['title' => 'Созвон', 'text' => 'Разбираем модель, инвестиции, сроки запуска и формат поддержки.'],
    ['title' => 'Договор', 'text' => 'Фиксируем эксклюзив на город и готовим дорожную карту открытия.'],
    ['title' => 'Открытие', 'text' => 'Подключаем команду запуска, маркетинг, обучение и стандарты сервиса.'],
];
?>
<section id="franchise-steps" class="franchise-steps franchise-section">
    <div class="franchise-container">
        <div class="franchise-section-heading">
            <p class="franchise-eyebrow">Путь к запуску</p>
            <h2>4 шага к открытию салона Jully Bride</h2>
        </div>
        <div class="franchise-steps__grid">
            <?php foreach ($steps as $index => $step) : ?>
                <article class="franchise-step">
                    <span><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                    <h3><?php echo esc_html($step['title']); ?></h3>
                    <p><?php echo esc_html($step['text']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="franchise-steps__media">
            <?php jullybride_franchise_image(53298, 'franchise-steps__scheme franchise-steps__scheme--desktop', '4 шага к открытию'); ?>
            <?php jullybride_franchise_image(53299, 'franchise-steps__scheme franchise-steps__scheme--mobile', '4 шага к открытию'); ?>
        </div>
    </div>
</section>

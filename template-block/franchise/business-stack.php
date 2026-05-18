<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = [
    'Наличие стандартов сервиса',
    'Автоматизированные бизнес процессы через CRM',
    'Эффективный отдел маркетинга',
    'Разработанная база знаний для обучения сотрудников',
];
?>
<section class="franchise-stack franchise-section">
    <div class="franchise-container">
        <div class="franchise-section-heading">
            <p class="franchise-eyebrow">У нас есть все, чтобы</p>
            <h2>твой бизнес стал сильнее</h2>
        </div>
        <div class="franchise-stack__items">
            <?php foreach ($items as $item) : ?>
                <div class="franchise-pill-card"><?php echo esc_html($item); ?></div>
            <?php endforeach; ?>
        </div>
        <div class="franchise-video-card">
            <img src="<?php echo esc_url(jullybride_franchise_image_url(51772)); ?>" alt="Видео Юлии Заборской" loading="lazy">
            <span class="franchise-video-card__play" aria-hidden="true"></span>
        </div>
    </div>
</section>

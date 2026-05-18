<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = [
    ['title' => 'Узнаваемость', 'text' => 'Красивый мерч помогает франчайзи выделяться на фоне конкурентов.'],
    ['title' => 'Делает бренд ближе', 'text' => 'Стикерпак, бутылка или шоппер остаются с невестой после свадьбы.'],
    ['title' => 'Эмоции после покупки', 'text' => 'Мерч продлевает вау-эффект и делает бренд частью личной истории.'],
    ['title' => 'Вовлечение', 'text' => 'Больше фото в соцсетях — больше живого охвата для салона.'],
    ['title' => 'Дополнительный доход', 'text' => 'Шопперы, термосы и косметички можно продавать как отдельные продукты.'],
];
?>
<section class="franchise-merch franchise-section">
    <div class="franchise-container franchise-merch__card">
        <div class="franchise-section-heading franchise-section-heading--left">
            <p class="franchise-eyebrow">Бонус</p>
            <h2>у нас есть фирменный мерч</h2>
        </div>
        <h3>Почему мерч это круто для вас?</h3>
        <div class="franchise-merch__grid">
            <?php foreach ($items as $item) : ?>
                <article>
                    <h4><?php echo esc_html($item['title']); ?></h4>
                    <p><?php echo esc_html($item['text']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

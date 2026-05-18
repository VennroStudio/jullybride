<?php
if (!defined('ABSPATH')) {
    exit;
}

$metrics = [
    ['value' => '800 000₽', 'label' => 'базовый пакет франшизы'],
    ['value' => '4%', 'label' => 'от оборота ежемесячный роялти'],
    ['value' => 'до 24', 'label' => 'месяцев окупаемость'],
    ['value' => 'от 16 млн ₽', 'label' => 'инвестиции'],
    ['value' => 'от 25%', 'label' => 'средняя рентабельность'],
    ['value' => 'от 1 млн ₽', 'label' => 'прибыль в месяц'],
];

$fee_items = [
    'Создание сайта',
    'Доступ к базе знаний из более 300 инструкций и регламентов',
    'Создание профилей на интернет-сервисах',
    'Фирменный стиль',
    'Полное сопровождение на этапе запуска',
    'План активностей перед открытием',
];

$royalty_items = [
    'Формирование и адаптация команды',
    'Маркетинговая поддержка',
    'Техническая поддержка',
];
?>
<section id="conditions" class="franchise-conditions franchise-section">
    <div class="franchise-container">
        <div class="franchise-section-heading">
            <p class="franchise-eyebrow">Финансовая модель</p>
            <h2>Условия франшизы</h2>
        </div>
        <div class="franchise-condition-metrics">
            <?php foreach ($metrics as $metric) : ?>
                <article>
                    <strong><?php echo esc_html($metric['value']); ?></strong>
                    <span><?php echo esc_html($metric['label']); ?></span>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="franchise-condition-lists">
            <div>
                <h3>В паушальный взнос входит:</h3>
                <ul>
                    <?php foreach ($fee_items as $item) : ?>
                        <li><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h3>В роялти входит:</h3>
                <ul>
                    <?php foreach ($royalty_items as $item) : ?>
                        <li><?php echo esc_html($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="franchise-condition-visuals" aria-hidden="true">
            <?php jullybride_franchise_image(53292, 'franchise-condition-visuals__girl', ''); ?>
            <?php jullybride_franchise_image(53293, 'franchise-condition-visuals__girl', ''); ?>
        </div>
    </div>
</section>

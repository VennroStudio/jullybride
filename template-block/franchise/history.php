<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = [
    [
        'title' => 'Мечта',
        'text' => 'Jully Bride начался с истории нашей основательницы и идейной вдохновительницы Юлии Заборской, которая 10 лет мечтала о свадебном салоне.',
    ],
    [
        'title' => 'Первые вложения',
        'text' => 'Она приехала из маленького города Воркуты и решила осуществить мечту, вложив при этом всего 3000 рублей.',
    ],
    [
        'title' => 'Старт',
        'text' => 'Сначала это была продажа свадебных платьев во ВКонтакте, примерки в квартире и постепенное накопление на первый салон.',
    ],
    [
        'title' => 'Успех',
        'text' => 'Сегодня Jully Bride — сеть свадебных салонов в разных городах России, а каждый месяц более 1000 невест выбирают наш бренд.',
    ],
];
?>
<section id="franchise-history" class="franchise-history franchise-section">
    <div class="franchise-container">
        <div class="franchise-section-heading">
            <p class="franchise-eyebrow">История</p>
            <h2>история Jully Bride</h2>
        </div>
        <div class="franchise-history__timeline">
            <?php foreach ($items as $item) : ?>
                <article>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['text']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="franchise-history__image">
            <?php jullybride_franchise_image(54152, '', 'История Jully Bride'); ?>
        </div>
    </div>
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$stages = [
    [
        'title' => 'Первые вложения',
        'text' => 'Она приехала из маленького города Воркуты и, когда муж сделал ей предложение, решила осуществить мечту, вложив при этом всего 3000 рублей.',
        'image' => 48159,
        'image_side' => 'right',
    ],
    [
        'title' => 'Старт',
        'text' => 'Стартом была продажа свадебных платьев в группе «ВКонтакте». Юлия днем работала главным бухгалтером, а вечером проводила примерки в своей квартире. За 2 года она накопила небольшую сумму денег и сняла свое первое подвальное помещение',
        'image' => 48158,
        'image_side' => 'left',
    ],
    [
        'title' => 'Успех',
        'text' => 'Сегодня Jully Bride — это сеть свадебных салонов в разных городах России. В Петербурге наш салон самый большой в городе с первым в мире Wedding кафе. Каждый месяц более 1000 невест выбирают Jully Bride, а в свадебный сезон у нас постоянный sold out.',
        'image' => 48157,
        'image_side' => 'right',
    ],
];
?>
<section id="franchise-history" class="franchise-history-original franchise-section">
    <div class="franchise-container franchise-history-original__intro">
        <div>
            <h2>История<br>Jully Bride</h2>
            <a class="franchise-history-original__instagram" href="https://www.instagram.com/jullyzaborskaya/" target="_blank" rel="noopener">
                <?php jullybride_franchise_image(48161, '', 'Instagram'); ?>
                <span>Юлия Заборская</span>
            </a>
        </div>
        <p>Jully Bride начался с истории нашей основательницы и идейной вдохновительницы — Юлии Заборской, которая 10 лет мечтала о свадебном салоне.</p>
    </div>

    <div class="franchise-history-original__stages">
        <?php foreach ($stages as $stage) : ?>
            <article class="franchise-history-stage franchise-history-stage--image-<?php echo esc_attr($stage['image_side']); ?>">
                <div class="franchise-history-stage__media">
                    <?php jullybride_franchise_image($stage['image'], '', ''); ?>
                </div>
                <div class="franchise-container franchise-history-stage__inner">
                    <div class="franchise-history-stage__text">
                        <h3><?php echo esc_html($stage['title']); ?></h3>
                        <p><?php echo esc_html($stage['text']); ?></p>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

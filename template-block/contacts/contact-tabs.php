<?php
if (!defined('ABSPATH')) {
    exit;
}

$cities = [
    [
        'slug' => 'spb',
        'title' => 'Санкт-Петербург',
        'address' => 'м. Горьковская, Петроградская набережная, 18',
        'phone' => '+7 (812) 929-16-99',
        'worktime' => 'Пн-вс, с 11:00 до 22:00',
        'email' => 'info@jullybride.ru',
        'reply' => 'рассматриваем письма в течение 48 часов',
        'details' => 'ИП Заборский О.В.,<br>ИНН 470202995499,<br>ОГРНИП 317784700059041',
        'gallery_ids' => [17998, 40683],
        'map' => 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A18b0b2ea15131615774649ad61807040840f0ddf4cae9248a03255dde19209af&amp;width=100%25&amp;height=600&amp;lang=ru_RU&amp;scroll=true',
        'map_link' => 'https://yandex.ru/maps/?text=' . rawurlencode('Санкт-Петербург Петроградская набережная 18'),
    ],
    [
        'slug' => 'moscow',
        'title' => 'Москва',
        'address' => 'г. Москва, м. Таганская, Гончарная набережная д.3 с.5',
        'phone' => '+7 (985) 226-98-88',
        'worktime' => 'Пн-вс, с 11:00 до 22:00',
        'email' => 'jully.bride@yandex.ru',
        'reply' => 'рассматриваем письма в течение 48 часов',
        'details' => 'ИП Заборский О.В.,<br>ИНН 470202995499,<br>ОГРНИП 317784700059041',
        'gallery_ids' => [17925],
        'map' => 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A79c15fcf1fc121d601944c5d0bdcb4a293ee500ac697d85201d3e2032718573b&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=true',
        'map_link' => 'https://yandex.ru/maps/?text=' . rawurlencode('Москва Гончарная набережная д.3 с.5'),
    ],
    [
        'slug' => 'rostov',
        'title' => 'Ростов-на-Дону',
        'address' => 'Университетский пер., д. 137, корп.1',
        'phone' => '+7 928 279-32-32',
        'worktime' => 'Пн-вс, с 11:00 до 22:00',
        'email' => 'jullybride.rostov@yandex.ru',
        'reply' => 'рассматриваем письма в течение 48 часов',
        'details' => 'ИП Хлестунова Нина Викторовна<br>ИНН 616107452444<br>ОГРНИП 306616105900011',
        'gallery_ids' => [31423, 31424, 31425, 31426],
        'map' => 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Afe7b59d373eaab3018987822bb67129aae81347b2520a280fb5f6bc6465103df&amp;width=100%25&amp;height=600&amp;lang=ru_RU&amp;scroll=true',
        'map_link' => 'https://yandex.ru/maps/?text=' . rawurlencode('Ростов-на-Дону Университетский пер., д. 137, корп.1'),
    ],
    [
        'slug' => 'nn',
        'title' => 'Нижний Новгород',
        'address' => 'ул. Белинского, д. 64',
        'phone' => '+7 (910) 007-37-00',
        'worktime' => 'Пн-вс, с 10:00 до 20:00',
        'email' => 'office@nn.jullybride.ru',
        'reply' => 'рассматриваем письма в течение 48 часов',
        'details' => 'ИП Серякова Анастасия Олеговна<br>ИНН 526106234038<br>ОГРНИП 324527500114773',
        'gallery_ids' => [46577, 46578, 46579, 46581, 46582, 46583],
        'map' => 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A2d36c4205e865e733e00cf7cf7fc3fce71477701552f0076a0107093d825eb2d&amp;width=100%25&amp;height=600&amp;lang=ru_RU&amp;scroll=true',
        'map_link' => 'https://yandex.ru/maps/-/CPAsBUz0',
    ],
];
?>
<section class="jb-contact-tabs" data-jb-contact-tabs>
    <div class="jb-contact-tabs__nav" role="tablist" aria-label="Города">
        <?php foreach ($cities as $index => $city) : ?>
            <input
                class="jb-contact-tabs__radio"
                type="radio"
                name="jb-contact-city"
                id="jb-contact-city-<?php echo esc_attr($city['slug']); ?>"
                <?php checked($index, 0); ?>
            >
            <label
                class="jb-contact-tabs__label<?php echo $index === 0 ? ' is-active' : ''; ?>"
                for="jb-contact-city-<?php echo esc_attr($city['slug']); ?>"
                role="tab"
                aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
            >
                <?php echo esc_html($city['title']); ?>
            </label>
        <?php endforeach; ?>
    </div>
    <div class="jb-contact-tabs__panels">
        <?php foreach ($cities as $index => $city) : ?>
            <?php jullybride_template_part('contacts/contact-panel', ['city' => $city, 'active' => $index === 0]); ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="jb-contact-accordion" data-jb-contact-accordion aria-label="Контакты по городам">
    <?php foreach ($cities as $index => $city) : ?>
        <details class="jb-contact-accordion__item" <?php echo $index === 0 ? 'open' : ''; ?>>
            <summary class="jb-contact-accordion__summary">
                <span><?php echo esc_html($city['title']); ?></span>
                <span class="jb-contact-accordion__chevron" aria-hidden="true"></span>
            </summary>
            <div class="jb-contact-accordion__body">
                <?php jullybride_template_part('contacts/contact-panel', ['city' => $city, 'active' => true, 'mode' => 'accordion']); ?>
            </div>
        </details>
    <?php endforeach; ?>
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$current_city = 'Санкт-Петербург';
$city_links = [
    ['label' => 'Нижний Новгород', 'url' => '#'],
    ['label' => 'Ростов', 'url' => '#'],
    ['label' => 'Москва', 'url' => '#'],
];
$address = jullybride_option('header_address', 'Горьковская, Петроградская набережная, 18, ПН-ВС — с 11:00 до 21:00');
$phone = jullybride_option('header_phone', '+7 (812) 929-16-99');
?>
<div class="jb-site-header__top">
    <div class="container jb-site-header__top-inner">
        <div class="jb-header-city">
            <button class="jb-city-switcher" type="button" aria-haspopup="true" aria-expanded="false" data-jb-city-switcher>
                <span><?php echo esc_html($current_city); ?></span>
                <span class="jb-city-switcher__arrow" aria-hidden="true"></span>
            </button>
            <ul class="jb-header-city__dropdown" aria-label="Выбор города">
                <?php foreach ($city_links as $city) : ?>
                    <li><a href="<?php echo esc_url($city['url']); ?>"><?php echo esc_html($city['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="jb-header-address">
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M5 4h14v10h-2.5a3.5 3.5 0 0 1-7 0H7a3.5 3.5 0 0 1-7 0H0V8a4 4 0 0 1 4-4h1Zm2 10a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Zm12.5 1.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM7 6v6h1.1a3.5 3.5 0 0 1 6.8 0H17V6H7Zm-2 6V6H4a2 2 0 0 0-2 2v4.3A3.5 3.5 0 0 1 5 12Z"/></svg>
            <span><?php echo esc_html($address); ?></span>
        </div>

        <a class="jb-header-phone" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M6.6 10.8a15.6 15.6 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.24c1.1.36 2.3.55 3.6.55a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.55 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2Z"/></svg>
            <span><?php echo esc_html($phone); ?></span>
        </a>
    </div>
</div>

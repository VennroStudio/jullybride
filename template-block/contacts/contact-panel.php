<?php
if (!defined('ABSPATH')) {
    exit;
}

$city = $args['city'] ?? [];

if (!$city) {
    return;
}

$city_socials = isset($city['socials']) && is_array($city['socials']) ? $city['socials'] : [];
$city_social_urls = [
    'Telegram' => trim((string) ($city_socials['telegram'] ?? '')),
    'VK' => trim((string) ($city_socials['vk'] ?? '')),
    'Instagram' => trim((string) ($city_socials['instagram'] ?? '')),
    'YouTube' => trim((string) ($city_socials['youtube'] ?? '')),
];
$social_links = [];

foreach ($city_social_urls as $label => $url) {
    if ($url === '' || $url === '#') {
        continue;
    }

    $social_links[] = [
        'label' => $label,
        'url' => $url,
    ];
}
?>
<section class="jb-contact-panel jb-contact-panel--<?php echo esc_attr($city['slug']); ?>">
    <div class="jb-contact-panel__layout">
        <div class="jb-contact-panel__column jb-contact-panel__column--left">
            <div class="jb-contact-info">
                <h2>Позвонить и записаться</h2>
                <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $city['phone'])); ?>"><?php echo esc_html($city['phone']); ?></a></p>
            </div>
            <div class="jb-contact-info">
                <h2>Прийти на примерку</h2>
                <p><?php echo wp_kses_post($city['address']); ?></p>
            </div>
            <div class="jb-contact-info">
                <h2>Режим работы</h2>
                <p><?php echo esc_html($city['worktime']); ?></p>
            </div>
            <img class="jb-contact-panel__choose" src="<?php echo esc_url(jullybride_asset_uri('images/kak-vybratь-to-samoe.svg')); ?>" alt="Как выбрать то самое?">
        </div>

        <div class="jb-contact-panel__column jb-contact-panel__column--middle">
            <div class="jb-contact-info">
                <h2>Сотрудничество</h2>
                <p><a href="mailto:<?php echo esc_attr($city['email']); ?>"><?php echo esc_html($city['email']); ?></a></p>
                <p><?php echo wp_kses_post($city['reply']); ?></p>
            </div>
            <div class="jb-contact-info">
                <h2>Реквизиты</h2>
                <?php echo wp_kses_post(str_contains((string) $city['details'], '<p') ? $city['details'] : wpautop((string) $city['details'])); ?>
            </div>
        </div>

        <div class="jb-contact-panel__column jb-contact-panel__column--map">
            <div class="jb-contact-map">
                <?php if (!empty($city['map'])) : ?>
                    <script type="text/javascript" charset="utf-8" async src="<?php echo esc_url($city['map']); ?>"></script>
                <?php elseif (!empty($city['map_link'])) : ?>
                    <a href="<?php echo esc_url($city['map_link']); ?>" target="_blank" rel="noopener">
                        Открыть в Яндекс Картах
                    </a>
                <?php endif; ?>
            </div>
            <div class="jb-contact-panel__social">
                <?php if ($social_links) : ?>
                    <img class="jb-contact-panel__social-title" src="<?php echo esc_url(jullybride_asset_uri('images/contact-social-title.svg')); ?>" alt="Хочешь посекретничать? Ищи нас здесь:">
                    <?php jullybride_template_part('common/social-links', ['context' => 'contacts', 'links' => $social_links]); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

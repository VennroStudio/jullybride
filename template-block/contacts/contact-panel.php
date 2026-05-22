<?php
if (!defined('ABSPATH')) {
    exit;
}

$city = $args['city'] ?? [];

if (!$city) {
    return;
}

$social_fallbacks = [
    'Telegram' => 'https://t.me/jullybridesalon',
    'VK' => 'https://vk.com/jullybride',
    'Instagram' => 'https://instagram.com/jullybride',
    'YouTube' => 'https://www.youtube.com/channel/UCo_Zo2x9fyN19uuxkWO_v-g',
];
$social_aliases = [
    'Telegram' => 'Telegram',
    'telegram' => 'Telegram',
    'Телеграм' => 'Telegram',
    'телеграм' => 'Telegram',
    'VK' => 'VK',
    'vk' => 'VK',
    'ВКонтакте' => 'VK',
    'вконтакте' => 'VK',
    'Instagram' => 'Instagram',
    'instagram' => 'Instagram',
    'Инстаграм' => 'Instagram',
    'инстаграм' => 'Instagram',
    'YouTube' => 'YouTube',
    'youtube' => 'YouTube',
    'Ютуб' => 'YouTube',
    'ютуб' => 'YouTube',
];
$social_urls = [];

foreach (jullybride_social_links() as $link) {
    if (!is_array($link)) {
        continue;
    }

    $label = trim((string) ($link['label'] ?? ''));
    $url = trim((string) ($link['url'] ?? ''));
    $normalized_label = function_exists('mb_strtolower') ? mb_strtolower($label) : strtolower($label);
    $key = $social_aliases[$label] ?? $social_aliases[$normalized_label] ?? '';

    if ($key !== '' && $url !== '' && $url !== '#') {
        $social_urls[$key] = $url;
    }
}

$social_links = [];

foreach ($social_fallbacks as $label => $fallback_url) {
    $social_links[] = [
        'label' => $label,
        'url' => $social_urls[$label] ?? $fallback_url,
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
                <p><?php echo esc_html($city['reply']); ?></p>
            </div>
            <div class="jb-contact-info">
                <h2>Реквизиты</h2>
                <p><?php echo wp_kses_post($city['details']); ?></p>
            </div>
        </div>

        <div class="jb-contact-panel__column jb-contact-panel__column--map">
            <div class="jb-contact-map">
                <?php if (!empty($city['map'])) : ?>
                    <script type="text/javascript" charset="utf-8" async src="<?php echo esc_url($city['map']); ?>"></script>
                <?php else : ?>
                    <a href="<?php echo esc_url($city['map_link'] ?? '#'); ?>" target="_blank" rel="noopener">
                        Открыть в Яндекс Картах
                    </a>
                <?php endif; ?>
            </div>
            <div class="jb-contact-panel__social">
                <img class="jb-contact-panel__social-title" src="<?php echo esc_url(jullybride_asset_uri('images/contact-social-title.svg')); ?>" alt="Хочешь посекретничать? Ищи нас здесь:">
                <?php jullybride_template_part('common/social-links', ['context' => 'contacts', 'links' => $social_links]); ?>
            </div>
        </div>
    </div>
</section>

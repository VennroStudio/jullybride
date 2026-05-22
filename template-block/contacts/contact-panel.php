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
$city_social_icons = [
    'Telegram' => '<svg viewBox="18 18 24 24" aria-hidden="true"><path fill="currentColor" d="M30.17 18.375c6.421 0 11.624 5.203 11.624 11.625S36.592 41.625 30.17 41.625 18.544 36.422 18.544 30s5.204-11.625 11.625-11.625m5.671 7.969c.188-.75-.28-1.078-.797-.89L23.84 29.766c-.75.28-.75.75-.14.937l2.86.89 6.655-4.218c.328-.187.61-.047.375.14l-5.39 4.876-.188 2.953c.281 0 .422-.14.563-.282l1.406-1.359 2.906 2.156c.563.282.938.141 1.078-.515z"/></svg>',
    'VK' => '<svg viewBox="17 22 26 16" aria-hidden="true"><path fill="currentColor" d="M42.228 23.531c-.375 1.594-3.75 6.375-3.75 6.375-.281.469-.422.703 0 1.219.188.234 3.703 3.61 4.219 5.203.234.797-.14 1.172-.938 1.172h-2.765c-1.032 0-1.36-.797-3.235-2.672C34.12 33.234 33.416 33 32.994 33c-.844 0-.703.328-.703 3.469 0 .656-.235 1.031-1.97 1.031-2.905 0-6.14-1.734-8.437-5.016-3.422-4.828-4.359-8.437-4.359-9.187 0-.422.188-.797.938-.797h2.765c.703 0 .984.328 1.266 1.078 1.36 3.938 3.61 7.406 4.547 7.406.375 0 .515-.187.515-1.078v-4.078c-.094-1.875-1.078-2.015-1.078-2.672 0-.328.234-.656.703-.656h4.313c.61 0 .797.328.797 1.031v5.485c0 .562.28.797.422.797.374 0 .656-.235 1.312-.844 1.969-2.25 3.375-5.672 3.375-5.672.188-.422.516-.797 1.219-.797h2.765c.844 0 .985.469.844 1.031"/></svg>',
    'Instagram' => '<svg viewBox="18 18 24 24" aria-hidden="true"><path fill="currentColor" d="M30.167 24.17c3.249 0 5.93 2.682 5.93 5.93a5.93 5.93 0 0 1-5.93 5.93c-3.3 0-5.93-2.63-5.93-5.93a5.93 5.93 0 0 1 5.93-5.93m0 9.797c2.114 0 3.816-1.701 3.816-3.867a3.807 3.807 0 0 0-3.816-3.816c-2.166 0-3.867 1.702-3.867 3.816a3.86 3.86 0 0 0 3.867 3.867m7.528-10.003c0 .774-.618 1.392-1.392 1.392a1.386 1.386 0 0 1-1.392-1.392c0-.773.619-1.392 1.392-1.392.774 0 1.392.619 1.392 1.392m3.919 1.392c.103 1.908.103 7.631 0 9.54-.103 1.856-.516 3.454-1.856 4.846-1.34 1.34-2.99 1.753-4.847 1.856-1.908.104-7.631.104-9.54 0-1.855-.103-3.454-.515-4.846-1.856-1.34-1.392-1.753-2.99-1.856-4.847-.103-1.908-.103-7.63 0-9.539.103-1.856.515-3.506 1.856-4.847 1.392-1.34 2.99-1.753 4.847-1.856 1.908-.103 7.631-.103 9.539 0 1.856.103 3.506.516 4.847 1.856 1.34 1.341 1.753 2.991 1.856 4.847m-2.475 11.55c.619-1.495.464-5.104.464-6.806 0-1.65.155-5.26-.464-6.806-.413-.98-1.186-1.805-2.166-2.166-1.547-.619-5.156-.464-6.806-.464-1.701 0-5.31-.155-6.806.464a3.98 3.98 0 0 0-2.217 2.166c-.619 1.547-.464 5.156-.464 6.806 0 1.702-.155 5.31.464 6.806a3.9 3.9 0 0 0 2.217 2.217c1.495.62 5.105.465 6.806.465 1.65 0 5.26.154 6.806-.465.98-.412 1.805-1.185 2.166-2.217"/></svg>',
    'YouTube' => '<svg viewBox="17 21 26 18" aria-hidden="true"><path fill="currentColor" d="M42.416 23.86c.562 1.968.562 6.187.562 6.187s0 4.172-.562 6.187a3.13 3.13 0 0 1-2.25 2.25C38.15 39 30.18 39 30.18 39s-8.015 0-10.031-.516a3.13 3.13 0 0 1-2.25-2.25c-.562-2.015-.562-6.187-.562-6.187s0-4.219.562-6.188c.281-1.125 1.172-2.015 2.25-2.297C22.166 21 30.181 21 30.181 21s7.969 0 9.985.563c1.078.28 1.968 1.171 2.25 2.296m-14.86 9.984 6.656-3.797-6.656-3.797z"/></svg>',
];
$has_social_links = (bool) array_filter($city_social_urls, static fn (string $url): bool => $url !== '' && $url !== '#');
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
                <?php if ($has_social_links) : ?>
                    <img class="jb-contact-panel__social-title" src="<?php echo esc_url(jullybride_asset_uri('images/contact-social-title.svg')); ?>" alt="Хочешь посекретничать? Ищи нас здесь:">
                    <div class="jb-social-links jb-social-links--contacts">
                        <?php foreach ($city_social_urls as $label => $url) : ?>
                            <?php if ($url === '' || $url === '#') : ?>
                                <?php continue; ?>
                            <?php endif; ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($label); ?>">
                                <?php echo $city_social_icons[$label]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

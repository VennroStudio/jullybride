<?php
if (!defined('ABSPATH')) {
    exit;
}

$city = $args['city'] ?? [];

if (!$city) {
    return;
}
?>
<section class="jb-contact-panel jb-contact-panel--<?php echo esc_attr($city['slug']); ?>">
    <div class="jb-contact-panel__grid">
        <div class="jb-contact-info">
            <h2>Адрес</h2>
            <p><?php echo wp_kses_post($city['address']); ?></p>
            <h2>Телефон</h2>
            <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $city['phone'])); ?>"><?php echo esc_html($city['phone']); ?></a></p>
        </div>
        <div class="jb-contact-info">
            <h2>Режим работы</h2>
            <p><?php echo esc_html($city['worktime']); ?></p>
            <h2>Наши соцсети</h2>
            <?php jullybride_template_part('common/social-links', ['context' => 'contacts']); ?>
        </div>
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

    <div class="jb-contact-map">
        <?php if (!empty($city['map'])) : ?>
            <script type="text/javascript" charset="utf-8" async src="<?php echo esc_url($city['map']); ?>"></script>
        <?php else : ?>
            <a href="<?php echo esc_url($city['map_link'] ?? '#'); ?>" target="_blank" rel="noopener">
                Открыть в Яндекс Картах
            </a>
        <?php endif; ?>
    </div>
</section>

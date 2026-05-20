<?php
if (!defined('ABSPATH')) {
    exit;
}

$city = $args['city'] ?? [];
$active = !empty($args['active']);
$mode = $args['mode'] ?? 'tabs';
$is_tabs_mode = $mode === 'tabs';

if (!$city) {
    return;
}
?>
<section
    class="jb-contact-panel jb-contact-panel--<?php echo esc_attr($city['slug']); ?> jb-contact-panel--<?php echo esc_attr($mode); ?>"
    <?php echo $is_tabs_mode ? 'data-jb-contact-panel="' . esc_attr($city['slug']) . '"' : ''; ?>
    <?php echo ($is_tabs_mode && !$active) ? 'hidden' : ''; ?>
>
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

    <?php if (!empty($city['gallery_ids'])) : ?>
        <?php $gallery_count = count($city['gallery_ids']); ?>
        <div class="jb-contact-gallery-wrap jb-contact-gallery-wrap--count-<?php echo esc_attr(min($gallery_count, 3)); ?>" data-jb-contact-gallery aria-label="Фотографии салона <?php echo esc_attr($city['title']); ?>">
            <?php if ($gallery_count > 1) : ?>
                <button class="jb-contact-gallery__arrow jb-contact-gallery__arrow--prev" type="button" data-jb-contact-gallery-prev aria-label="Предыдущая фотография">‹</button>
            <?php endif; ?>
            <div class="jb-contact-gallery">
                <div class="jb-contact-gallery__track" data-jb-contact-gallery-track>
                    <?php foreach ($city['gallery_ids'] as $image_id) : ?>
                        <figure class="jb-contact-gallery__item">
                            <?php echo wp_get_attachment_image((int) $image_id, 'large', false, ['loading' => 'lazy']); ?>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if ($gallery_count > 1) : ?>
                <button class="jb-contact-gallery__arrow jb-contact-gallery__arrow--next" type="button" data-jb-contact-gallery-next aria-label="Следующая фотография">›</button>
            <?php endif; ?>
        </div>
    <?php endif; ?>

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

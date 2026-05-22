<?php
if (!defined('ABSPATH')) {
    exit;
}

$image_ids = [57345, 57346, 57347, 57348];
?>
<section class="jb-about-gallery" aria-label="Фотографии Jully Bride">
    <button class="jb-about-gallery__arrow jb-about-gallery__arrow--prev" type="button" data-jb-about-gallery-prev aria-label="Предыдущая фотография">‹</button>
    <div class="jb-about-gallery__viewport" data-jb-about-gallery>
        <div class="jb-about-gallery__track">
            <?php foreach ($image_ids as $image_id) : ?>
                <figure class="jb-about-gallery__slide">
                    <?php echo wp_get_attachment_image($image_id, 'large', false, ['loading' => 'lazy']); ?>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
    <button class="jb-about-gallery__arrow jb-about-gallery__arrow--next" type="button" data-jb-about-gallery-next aria-label="Следующая фотография">›</button>
</section>

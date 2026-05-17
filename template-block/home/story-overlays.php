<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
        <a href="javascript:void(0)" class="app-overlay-close"></a>
        <div class="app-overlay-overlay"></div>

        <?php if (have_rows('carusel-added-owl')): ?>

            <?php while (have_rows('carusel-added-owl')): the_row(); ?>

                <div class="carusel-added-story" data-active="open-carusel-added-story_<?= esc_attr(get_row_index())?>">
                    <ul class="owl-carusel-added-story owl-carousel owl-theme" id="owl-carusel-added-story_<?= esc_attr(get_row_index()) ?>">
                        <?php if (have_rows('karusel')): ?>
                            <?php while (have_rows('karusel')): the_row(); 
                                // Проверяем, есть ли фото
                                $foto = get_sub_field('foto');
                                // Проверяем, есть ли видео
                                $video = get_sub_field('video');
                            ?>
                                <li>
                                    <?php if ($video): ?>
                                        <video data-src="<?= esc_url($video) ?>" poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/galereya1.webp" autoplay muted playsinline class="lazy-video">
                                            Ваш браузер не поддерживает видео.
                                        </video>
                                    <?php elseif ($foto && !empty($foto['id'])): 
                                        $image = wp_get_attachment_image_src($foto['id'], 'carousel-story');
                                        $img_url = $image[0] ?? $foto['url'];
                                    ?>
                                        <img 
                                             src="<?= esc_url($img_url) ?>" 
                                            alt="<?= esc_attr($foto['alt'] ?? '') ?>"
                                        />
                                    <?php endif; ?>
                                </li>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </ul>
                </div>

            <?php endwhile; ?>

        <?php endif; ?>

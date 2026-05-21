<?php
if (!defined('ABSPATH')) {
    exit;
}

$source_id = function_exists('jullybride_home_source_id') ? jullybride_home_source_id() : (int) get_option('page_on_front');

$catalog_story_media_url = static function (mixed $media, string $size = 'full'): string {
    if (is_array($media)) {
        if (!empty($media['id'])) {
            $url = $size === 'full'
                ? wp_get_attachment_url((int) $media['id'])
                : wp_get_attachment_image_url((int) $media['id'], $size);

            return (string) ($url ?: ($media['url'] ?? ''));
        }

        return (string) ($media['url'] ?? '');
    }

    if (is_numeric($media)) {
        $url = $size === 'full'
            ? wp_get_attachment_url((int) $media)
            : wp_get_attachment_image_url((int) $media, $size);

        return (string) $url;
    }

    return is_string($media) ? $media : '';
};
?>
<a href="javascript:void(0)" class="app-overlay-close"></a>
<div class="app-overlay-overlay"></div>

<?php if (function_exists('have_rows') && have_rows('carusel-added-owl', $source_id)) : ?>
    <?php
    while (have_rows('carusel-added-owl', $source_id)) :
        the_row();
        $story_index = (string) get_row_index();
        ?>
        <div class="carusel-added-story" data-active="open-carusel-added-story_<?php echo esc_attr($story_index); ?>">
            <ul class="owl-carusel-added-story owl-carousel owl-theme" id="owl-carusel-added-story_<?php echo esc_attr($story_index); ?>">
                <?php if (have_rows('karusel')) : ?>
                    <?php
                    while (have_rows('karusel')) :
                        the_row();
                        $photo = get_sub_field('foto');
                        $video = get_sub_field('video');
                        $photo_url = $catalog_story_media_url($photo, 'carousel-story');
                        $photo_alt = is_array($photo) ? (string) ($photo['alt'] ?? '') : '';
                        $video_url = $catalog_story_media_url($video);
                        ?>
                        <li>
                            <?php if ($video_url) : ?>
                                <video data-src="<?php echo esc_url($video_url); ?>" autoplay muted playsinline class="lazy-video">
                                    Ваш браузер не поддерживает видео.
                                </video>
                            <?php elseif ($photo_url) : ?>
                                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_alt); ?>">
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
    <?php endwhile; ?>
<?php endif; ?>

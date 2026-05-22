<?php
if (!defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], [
    'source' => function_exists('jullybride_stories_source') ? jullybride_stories_source() : 'option',
    'field_name' => function_exists('jullybride_stories_field_name') ? jullybride_stories_field_name() : 'carusel-added-owl',
    'include_controls' => true,
    'poster' => function_exists('jullybride_asset_uri') ? jullybride_asset_uri('images/galereya1.webp') : '',
]);

$source = $args['source'];
$field_name = (string) $args['field_name'];

if (!function_exists('have_rows') || !have_rows($field_name, $source)) {
    return;
}
?>
<?php if ((bool) $args['include_controls']) : ?>
    <a href="javascript:void(0)" class="app-overlay-close"></a>
    <div class="app-overlay-overlay"></div>
<?php endif; ?>

<?php
while (have_rows($field_name, $source)) :
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
                    $photo_url = function_exists('jullybride_media_url') ? jullybride_media_url($photo, 'carousel-story') : '';
                    $photo_alt = is_array($photo) ? (string) ($photo['alt'] ?? '') : '';
                    $video_url = function_exists('jullybride_media_url') ? jullybride_media_url($video) : '';
                    ?>
                    <li>
                        <?php if ($video_url) : ?>
                            <video
                                data-src="<?php echo esc_url($video_url); ?>"
                                <?php if ($args['poster']) : ?>
                                    poster="<?php echo esc_url((string) $args['poster']); ?>"
                                <?php endif; ?>
                                autoplay
                                muted
                                playsinline
                                class="lazy-video">
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

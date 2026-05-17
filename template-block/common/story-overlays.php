<?php
if (!defined('ABSPATH') || !function_exists('have_rows')) {
    return;
}

$context = jullybride_home_story_context();
$post_id = $args['post_id'] ?? $context['post_id'];
$field = $args['field'] ?? $context['field'];

if (!have_rows($field, $post_id)) {
    return;
}
?>
<a href="javascript:void(0)" class="app-overlay-close"></a>
<div class="app-overlay-overlay"></div>

<?php while (have_rows($field, $post_id)) : the_row(); ?>
    <div class="carusel-added-story" data-active="open-carusel-added-story_<?php echo esc_attr(get_row_index()); ?>">
        <ul class="owl-carusel-added-story owl-carousel owl-theme" id="owl-carusel-added-story_<?php echo esc_attr(get_row_index()); ?>">
            <?php if (have_rows('karusel')) : ?>
                <?php while (have_rows('karusel')) : the_row(); ?>
                    <?php
                    $foto = get_sub_field('foto');
                    $video = get_sub_field('video');
                    ?>
                    <li>
                        <?php if ($video) : ?>
                            <video data-src="<?php echo esc_url($video); ?>" autoplay muted playsinline class="lazy-video">
                                Ваш браузер не поддерживает видео.
                            </video>
                        <?php elseif ($foto && !empty($foto['id'])) : ?>
                            <?php
                            $image = wp_get_attachment_image_src($foto['id'], 'carousel-story');
                            $img_url = $image[0] ?? $foto['url'];
                            ?>
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($foto['alt'] ?? ''); ?>">
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
    </div>
<?php endwhile; ?>


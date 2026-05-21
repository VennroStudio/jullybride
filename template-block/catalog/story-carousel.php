<?php
if (!defined('ABSPATH')) {
    exit;
}

$source_id = function_exists('jullybride_home_source_id') ? jullybride_home_source_id() : (int) get_option('page_on_front');

if (!function_exists('have_rows') || !have_rows('carusel-added-owl', $source_id)) {
    return;
}

$catalog_story_thumb_url = static function (mixed $media): string {
    if (is_array($media)) {
        if (!empty($media['id'])) {
            $url = wp_get_attachment_image_url((int) $media['id'], 'thumbnail');

            return (string) ($url ?: ($media['url'] ?? ''));
        }

        return (string) ($media['url'] ?? '');
    }

    if (is_numeric($media)) {
        return (string) wp_get_attachment_image_url((int) $media, 'thumbnail');
    }

    return is_string($media) ? $media : '';
};
?>
<section class="product-top">
    <div class="carusel-added container">
        <div class="row">
            <div class="col-1 d-md-flex d-none align-items-center">
                <a href="javascript:void(0)" class="arrow-prev carusel-nav disabled" id="carusel-added-prev"></a>
            </div>
            <div class="col-12 col-md-10">
                <ul class="carusel-added-owl owl-carousel owl-theme" id="carusel-added-owl">
                    <?php
                    while (have_rows('carusel-added-owl', $source_id)) :
                        the_row();
                        $story_id = 'open-carusel-added-story_' . get_row_index();
                        $image = get_sub_field('img');
                        $image_url = $catalog_story_thumb_url($image);
                        $title = (string) get_sub_field('title');
                        ?>
                        <li id="<?php echo esc_attr($story_id); ?>">
                            <a href="javascript:void(0)">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                <?php endif; ?>
                                <span><?php echo esc_html($title); ?></span>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="col-1 d-md-flex d-none justify-content-end align-items-center">
                <a href="javascript:void(0)" class="arrow-next carusel-nav disabled" id="carusel-added-next"></a>
            </div>
        </div>
    </div>
</section>

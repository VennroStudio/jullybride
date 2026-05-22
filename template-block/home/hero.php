<?php
if (!defined('ABSPATH')) {
    exit;
}

$home_media_url = static function (mixed $media, string $size = 'full'): string {
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

$banners = [];
$banner_image_ids = [];

if (function_exists('have_rows') && have_rows('banners')) {
    while (have_rows('banners')) {
        the_row();

        $image = get_sub_field('image', false);
        $image_id = is_numeric($image) ? (int) $image : 0;

        if ($image_id > 0) {
            $banner_image_ids[] = $image_id;
        }

        $banners[] = [
            'image' => $image,
            'image_id' => $image_id,
            'title' => (string) get_sub_field('title'),
            'subtitle' => (string) get_sub_field('subtitle'),
            'text_left' => (string) get_sub_field('text_left'),
            'text_right' => (string) get_sub_field('text_right'),
            'link' => jullybride_url((string) get_sub_field('link'), '#'),
            'button_text' => (string) get_sub_field('button_text'),
        ];
    }
}

if (function_exists('jullybride_prime_attachment_caches')) {
    jullybride_prime_attachment_caches($banner_image_ids);
}
?>
<section class="padding-bottom-80">
    <div class="main-slide">
        <div class="slide-duration">
            <div class="slide-duration_indicator"></div>
        </div>

        <?php if ($banners) : ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul class="main-slide_list owl-carousel owl-theme" id="main-slide-carusel">
                            <?php
                            foreach ($banners as $index => $banner) :
                                $image = $banner['image'];
                                $image_url = $home_media_url($image);
                                $image_alt = $banner['image_id'] > 0 ? (string) get_post_meta($banner['image_id'], '_wp_attachment_image_alt', true) : '';
                                $title = $banner['title'];
                                $subtitle = $banner['subtitle'];
                                $text_left = $banner['text_left'];
                                $text_right = $banner['text_right'];
                                $link = $banner['link'];
                                $button_text = $banner['button_text'];
                                ?>
                                <li class="row align-items-center">
                                    <div class="main-slide_top col-12">
                                        <span class="font-title d-block main-slide_title text-center"><?php echo esc_html($title); ?></span>
                                        <span class="font-cursive d-block main-slide_cursive text-center"><?php echo esc_html($subtitle); ?></span>
                                    </div>
                                    <div class="col d-none d-md-block">
                                        <span class="font-arsenica-regular main-slide_left d-block"><?php echo wp_kses_post($text_left); ?></span>
                                        <a href="<?php echo esc_url($link); ?>" class="theme-button button-main d-table"><?php echo esc_html($button_text); ?></a>
                                    </div>
                                    <div class="col main-slide_img">
                                        <div class="main-slide_img-wrap">
                                            <span class="main-slide_img-text d-block d-md-none"><?php echo wp_kses_post($text_left); ?></span>
                                            <a href="<?php echo esc_url($link); ?>" class="main-slide_img-btn d-block d-md-none">Вау! Можно к вам?</a>

                                            <?php if ($image_url && $index === 0) : ?>
                                                <img
                                                    src="<?php echo esc_url($image_url); ?>"
                                                    alt="<?php echo esc_attr($image_alt ?: $title); ?>"
                                                    fetchpriority="high"
                                                    width="295"
                                                    height="439"
                                                    data-critical="true"
                                                    decoding="async">
                                            <?php elseif ($image_url) : ?>
                                                <img data-src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt ?: $title); ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col d-none d-md-block">
                                        <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="secret-link d-block"></a>
                                        <span class="main-slide_right d-block text-end"><?php echo wp_kses_post($text_right); ?></span>
                                    </div>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        jullybride_template_part('components/floating-strip', [
            'class' => 'lenta-stroke',
            'text' => (string) get_field('text_stroke'),
            'background_rect' => true,
            'repeat' => false,
        ]);
        ?>
    </div>

    <?php
    jullybride_template_part('components/story-carousel', [
        'thumb_size' => 'full',
    ]);
    ?>
</section>

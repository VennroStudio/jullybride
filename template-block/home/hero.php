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
?>
<section class="padding-bottom-80">
    <div class="main-slide">
        <div class="slide-duration">
            <div class="slide-duration_indicator"></div>
        </div>

        <?php if (function_exists('have_rows') && have_rows('banners')) : ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul class="main-slide_list owl-carousel owl-theme" id="main-slide-carusel">
                            <?php
                            $index = 0;
                            while (have_rows('banners')) :
                                the_row();
                                $image = get_sub_field('image');
                                $image_url = $home_media_url($image);
                                $image_alt = is_array($image) ? (string) ($image['alt'] ?? '') : '';
                                $title = (string) get_sub_field('title');
                                $subtitle = (string) get_sub_field('subtitle');
                                $text_left = (string) get_sub_field('text_left');
                                $text_right = (string) get_sub_field('text_right');
                                $link = jullybride_url((string) get_sub_field('link'), '#');
                                $button_text = (string) get_sub_field('button_text');
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
                                $index++;
                            endwhile;
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

    <?php if (function_exists('have_rows') && have_rows('carusel-added-owl')) : ?>
        <div class="carusel-added container">
            <div class="row">
                <div class="col-1 d-md-flex d-none align-items-center">
                    <a href="javascript:void(0)" class="arrow-prev carusel-nav" id="carusel-added-prev"></a>
                </div>
                <div class="col-12 col-md-10">
                    <ul class="carusel-added-owl owl-carousel owl-theme" id="carusel-added-owl">
                        <?php
                        while (have_rows('carusel-added-owl')) :
                            the_row();
                            $story_id = 'open-carusel-added-story_' . get_row_index();
                            $image = get_sub_field('img');
                            $image_url = $home_media_url($image);
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
                    <a href="javascript:void(0)" class="arrow-next carusel-nav" id="carusel-added-next"></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

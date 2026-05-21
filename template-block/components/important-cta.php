<?php
if (!defined('ABSPATH')) {
    exit;
}

$args = is_array($args ?? null) ? $args : [];

$section_class = trim((string) ($args['section_class'] ?? 'box-important position-relative'));
$container_class = trim((string) ($args['container_class'] ?? 'container position-relative z-index-1'));
$left_items = is_array($args['left_items'] ?? null) ? $args['left_items'] : [];
$media = is_array($args['media'] ?? null) ? $args['media'] : [];
$right_cursive = (string) ($args['right_cursive'] ?? '');
$right_title = (string) ($args['right_title'] ?? '');
$right_text = (string) ($args['right_text'] ?? '');
$button_text = (string) ($args['button_text'] ?? '');
$button_url = (string) ($args['button_url'] ?? '#');
$button_href = stripos($button_url, 'javascript:') === 0 ? $button_url : esc_url($button_url);
$button_class = trim((string) ($args['button_class'] ?? 'button-main-main-bg theme-button d-table ms_booking'));
$marquee_text = (string) ($args['marquee_text'] ?? '');
$marquee_class = trim((string) ($args['marquee_class'] ?? 'lenta-stroke2 z-index-0'));
$show_marquee = array_key_exists('show_marquee', $args) ? (bool) $args['show_marquee'] : true;
$decor_image = (string) ($args['decor_image'] ?? '');
$decor_class = trim((string) ($args['decor_class'] ?? 'box-important-svg1 d-none d-md-block'));

$media_type = (string) ($media['type'] ?? 'image');
$media_url = (string) ($media['url'] ?? '');
$media_poster = (string) ($media['poster'] ?? '');
$media_alt = (string) ($media['alt'] ?? '');
$media_class = trim((string) ($media['class'] ?? ''));
?>
<section class="<?php echo esc_attr($section_class); ?>">
    <div class="<?php echo esc_attr($container_class); ?>">
        <div class="row align-items-end">
            <div class="col-md-4">
                <?php foreach ($left_items as $item) : ?>
                    <?php
                    if (!is_array($item)) {
                        continue;
                    }

                    $item_title = (string) ($item['title'] ?? '');
                    $item_text = (string) ($item['text'] ?? '');
                    $item_icon = (string) ($item['icon'] ?? '');
                    ?>
                    <div class="box-important_item1 text-center">
                        <?php if ($item_title !== '') : ?>
                            <span class="box-important_item1-title font-cursive d-block text-center"><?php echo wp_kses_post($item_title); ?></span>
                        <?php endif; ?>
                        <?php if ($item_text !== '') : ?>
                            <span class="box-important_item1-desc"><?php echo wp_kses_post($item_text); ?></span>
                        <?php endif; ?>
                        <?php if ($item_icon !== '') : ?>
                            <div><img src="<?php echo esc_url($item_icon); ?>" alt=""></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4">
                <div class="box-important_item2">
                    <?php if ($media_url !== '' && $media_type === 'video') : ?>
                        <video data-src="<?php echo esc_url($media_url); ?>"<?php echo $media_poster !== '' ? ' poster="' . esc_url($media_poster) . '"' : ''; ?> autoplay muted playsinline loop class="<?php echo esc_attr(trim('bg-video lazy-video ' . $media_class)); ?>">
                            Ваш браузер не поддерживает видео.
                        </video>
                    <?php elseif ($media_url !== '') : ?>
                        <img src="<?php echo esc_url($media_url); ?>" alt="<?php echo esc_attr($media_alt); ?>" loading="lazy"<?php echo $media_class !== '' ? ' class="' . esc_attr($media_class) . '"' : ''; ?>>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box-important_item3 d-flex justify-content-center align-items-center">
                    <div class="position-relative">
                        <?php if ($right_cursive !== '') : ?>
                            <span class="box-important_item3-cursive font-cursive d-block"><?php echo wp_kses_post($right_cursive); ?></span>
                        <?php endif; ?>
                        <?php if ($right_title !== '') : ?>
                            <span class="box-important_item3-title font-title d-block"><?php echo wp_kses_post($right_title); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($right_text !== '') : ?>
                        <span class="box-important_item3-desc"><?php echo wp_kses_post($right_text); ?></span>
                    <?php endif; ?>
                    <?php if ($button_text !== '') : ?>
                        <a href="<?php echo esc_attr($button_href); ?>" class="<?php echo esc_attr($button_class); ?>"><?php echo esc_html($button_text); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($show_marquee) {
        jullybride_template_part('components/floating-strip', [
            'class' => $marquee_class,
            'text' => $marquee_text,
        ]);
    }
    ?>
    <?php if ($decor_image !== '') : ?>
        <img class="<?php echo esc_attr($decor_class); ?>" src="<?php echo esc_url($decor_image); ?>" alt="">
    <?php endif; ?>
</section>

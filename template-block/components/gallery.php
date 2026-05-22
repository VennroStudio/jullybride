<?php
if (!defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], [
    'gallery' => [],
    'image_url' => null,
    'image_alt' => null,
    'part' => 'all',
    'after_mobile' => '',
]);

$gallery = is_array($args['gallery']) ? array_values(array_filter($args['gallery'])) : [];
$part = in_array($args['part'], ['all', 'inline', 'desktop'], true) ? $args['part'] : 'all';
$after_mobile = (string) $args['after_mobile'];

$image_url = is_callable($args['image_url'])
    ? $args['image_url']
    : static function (mixed $image): string {
        if (function_exists('jullybride_media_url')) {
            return jullybride_media_url($image);
        }

        if (is_numeric($image)) {
            return (string) wp_get_attachment_url((int) $image);
        }

        if (is_array($image)) {
            return (string) ($image['url'] ?? '');
        }

        return is_string($image) ? $image : '';
    };

$image_alt = is_callable($args['image_alt'])
    ? $args['image_alt']
    : static function (mixed $image): string {
        if (is_numeric($image)) {
            return (string) get_post_meta((int) $image, '_wp_attachment_image_alt', true);
        }

        if (is_array($image)) {
            return (string) ($image['alt'] ?? '');
        }

        return '';
    };

if (!$gallery) {
    return;
}
?>
<?php if ($part === 'all' || $part === 'inline') : ?>
    <div class="col-12 position-relative d-none d-md-block">
        <a href="javascript:void(0)" class="box_beautiful_vacation-carusel-nav box_beautiful_vacation-carusel-prev wow slideInLeft"></a>
        <a href="javascript:void(0)" class="box_beautiful_vacation-carusel-nav box_beautiful_vacation-carusel-next wow slideInRight"></a>
    </div>

    <div class="d-block d-md-none wow bounceInUp position-relative">
        <div class="position-relative">
            <ul class="owl-list box_beautiful_vacation-carusel-mobile owl-carousel owl-theme autoheight" id="box_beautiful_vacation-carusel-mobile">
                <?php foreach ($gallery as $image) : ?>
                    <?php
                    $image_url_value = $image_url($image);
                    $image_alt_value = $image_alt($image);
                    ?>
                    <?php if ($image_url_value) : ?>
                        <li><img src="<?php echo esc_url($image_url_value); ?>" alt="<?php echo esc_attr($image_alt_value); ?>" loading="lazy"></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <div class="box_beautiful_vacation-carusel-mobile-nav-dots">
                <a href="javascript:void(0)" class="box_beautiful_vacation-carusel-mobile-nav box_beautiful_vacation-carusel-mobile-prev wow slideInLeft"></a>
                <a href="javascript:void(0)" class="box_beautiful_vacation-carusel-mobile-nav box_beautiful_vacation-carusel-mobile-next wow slideInRight"></a>
            </div>
        </div>
        <?php echo wp_kses_post($after_mobile); ?>
    </div>
<?php endif; ?>

<?php if ($part === 'all' || $part === 'desktop') : ?>
    <?php $slides = array_chunk($gallery, 2); ?>
    <div class="swiper-container wow bounceInUp d-none d-md-block overflow-hidden" id="box_beautiful_vacation-carusel">
        <ul class="box_beautiful_vacation-carusel swiper-wrapper owl-list">
            <?php foreach ($slides as $slide_images) : ?>
                <li class="swiper-slide">
                    <?php foreach ($slide_images as $image) : ?>
                        <?php
                        $image_url_value = $image_url($image);
                        $image_alt_value = $image_alt($image);
                        ?>
                        <?php if ($image_url_value) : ?>
                            <div><img src="<?php echo esc_url($image_url_value); ?>" alt="<?php echo esc_attr($image_alt_value); ?>" loading="lazy"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

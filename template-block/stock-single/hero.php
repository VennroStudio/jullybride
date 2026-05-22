<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once JULLYBRIDE_THEME_DIR . '/template-block/stock/helpers.php';

$post_id = get_the_ID();
$image = jullybride_stock_image_url('sale_img', $post_id, 'full', jullybride_stock_featured_image_url($post_id, 'full'));
$title = (string) jullybride_stock_field('sale_header', $post_id, get_the_title());
$subtitle = (string) jullybride_stock_field('sale_header_2', $post_id, '');
$description = (string) jullybride_stock_field('sale_description', $post_id, get_the_excerpt());
$button = (string) jullybride_stock_field('btn_label', $post_id, jullybride_option('booking_text', 'Записаться на примерку'));
?>
<section class="jb-promo-hero">
    <div class="jb-promo-hero__inner">
        <figure class="jb-promo-hero__image">
            <?php if ($image) : ?>
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
            <?php endif; ?>
        </figure>

        <div class="jb-promo-hero__content">
            <h1><?php echo esc_html($title); ?></h1>

            <?php if ($subtitle) : ?>
                <h2><?php echo esc_html($subtitle); ?></h2>
            <?php endif; ?>

            <?php if ($description) : ?>
                <div class="jb-promo-hero__description">
                    <?php echo wp_kses_post(wpautop($description)); ?>
                </div>
            <?php endif; ?>

            <div class="jb-promo-countdown" data-jb-countdown="<?php echo esc_attr(jullybride_stock_countdown_target($post_id)); ?>">
                <span><b>00</b><small>дней</small></span>
                <span><b>00</b><small>часов</small></span>
                <span><b>00</b><small>минут</small></span>
            </div>

            <p class="jb-promo-hero__soon">Уже совсем скоро!!!</p>

            <a href="javascript:void(0)" class="jb-promo-button ms_booking"><?php echo esc_html($button); ?></a>
        </div>
    </div>
</section>

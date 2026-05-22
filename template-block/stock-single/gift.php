<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once JULLYBRIDE_THEME_DIR . '/template-block/stock/helpers.php';

$post_id = get_the_ID();
$enabled = (bool) jullybride_stock_field('sale_gift_enabled', $post_id, true);

if (!$enabled) {
    return;
}

$marquee = (string) jullybride_stock_field('sale_gift_marquee', $post_id, 'WOW! ПОДАРОК!');
$image = jullybride_stock_image_url('sale_gift_image', $post_id, 'full', content_url('uploads/2025/02/s.png'));
$title = (string) jullybride_stock_field('sale_gift_title', $post_id, 'ЗАБЕРИ СВОЙ ПОДАРОК!');
$description = (string) jullybride_stock_field('sale_gift_description', $post_id, 'Дорогая, это WOW! Мы запустили бота, где ты можешь выиграть более 20 wedy призов: скидки на платья, сертификаты на свадебных специалистов, наш фирменный мерч и главный приз — потрясающее вечернее платье из коллекции Diamond! Поторопись, подарков ограниченное количество!');
$button = (string) jullybride_stock_field('sale_gift_button', $post_id, 'ЗАБРАТЬ ПОДАРОК');
?>
<section class="jb-promo-gift">
    <?php jullybride_template_part('stock-single/marquee', ['text' => $marquee]); ?>

    <div class="jb-promo-gift__inner">
        <?php if ($image) : ?>
            <img class="jb-promo-gift__image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
        <?php endif; ?>

        <div class="jb-promo-gift__content">
            <h2><?php echo esc_html($title); ?></h2>
            <p><?php echo esc_html($description); ?></p>
            <a href="javascript:void(0)" class="jb-promo-button ms_booking"><?php echo esc_html($button); ?></a>
        </div>
    </div>
</section>

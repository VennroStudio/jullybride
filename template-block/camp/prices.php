<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_8_-_zagolovok');
$subtitle = jullybride_camp_field('ekran_8_-_podzagolovok');
$intro = jullybride_camp_field('ekran_8_-_predvaritelnyj_tekst');

$products = new WP_Query([
    'post_type' => 'product',
    'product_cat' => 'tariffs',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_key' => '_price',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => [
        [
            'key' => '_price',
            'compare' => 'EXISTS',
        ],
    ],
]);
?>
<section class="box_price" id="box_price">
    <div class="container position-relative">
        <div class="row">
            <div class="col-12">
                <?php if ($title) : ?>
                    <span class="section-subtitle d-block text-center wow bounceInUp"><?php echo esc_html($title); ?></span>
                <?php endif; ?>
                <?php if ($subtitle) : ?>
                    <h2 class="section-title text-center font-title wow bounceInUp"><?php echo esc_html($subtitle); ?></h2>
                <?php endif; ?>
            </div>

            <?php if ($intro) : ?>
                <div class="col-12">
                    <span class="d-block prev-text wow bounceInUp"><?php echo wp_kses_post($intro); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($products->have_posts()) : ?>
        <div class="box_price_carusel_wrap wow bounceInUp">
            <ul class="box_price_carusel owl-list owl-carousel owl-theme" id="box_price_carusel">
                <?php while ($products->have_posts()) : $products->the_post(); ?>
                    <?php
                    $product = wc_get_product(get_the_ID());
                    if (!$product) {
                        continue;
                    }

                    $image_id = $product->get_image_id();
                    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
                    $image_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : get_the_title();
                    $badge = function_exists('get_field') ? get_field('shild_tarif', $product->get_id()) : '';
                    $badge_url = jullybride_camp_image_url($badge);
                    $price_note = function_exists('get_field') ? get_field('text_prev_price', $product->get_id()) : '';
                    ?>
                    <li class="box_price_carusel-item">
                        <div class="position-relative">
                            <div class="box_price_carusel-item-img">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" class="prod_photo" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
                                <?php endif; ?>

                                <?php if ($badge_url) : ?>
                                    <img class="nakleyka wow heartBeat" data-wow-iteration="10" src="<?php echo esc_url($badge_url); ?>" alt="">
                                <?php endif; ?>
                            </div>

                            <div class="box_price_carusel-item-data">
                                <span class="box_price_carusel-item-title d-block"><?php echo esc_html(get_the_title()); ?></span>
                                <?php if ($product->get_short_description()) : ?>
                                    <div class="box_price_carusel-item_prev-text">
                                        <?php echo wp_kses_post($product->get_short_description()); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($product->get_description()) : ?>
                                    <div class="box_price_carusel-item-data_color">
                                        <span class="box_price_carusel-item-title d-block">ТО, ЧТО ТЕБЕ НЕ ПРЕДЛОЖАТ ДРУГИЕ ТУРЫ:</span>
                                        <?php echo wp_kses_post($product->get_description()); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="box_price_carusel_price">
                                <div>
                                    <div class="box_price_carusel_price-first">
                                        <?php if ($price_note) : ?>
                                            <span class="box_price_carusel_price-first-mest"><?php echo esc_html($price_note); ?></span>
                                        <?php endif; ?>
                                        <?php if ($product->get_price() !== '') : ?>
                                            <span class="box_price_carusel_price-first-price"><?php echo esc_html(number_format((float) $product->get_price(), 0, ',', ' ')); ?>₽</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="box_price_carusel_price-last">
                                        <a href="#" class="theme-button wow heartBeat" data-product="<?php echo esc_attr((string) $product->get_id()); ?>" data-product-name="<?php echo esc_attr(get_the_title()); ?>" data-action="buy-now">забронировать место</a>
                                    </div>
                                </div>
                                <a href="#" class="box_price_carusel_last-link">У меня остались вопросы</a>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            <div class="box_price_carusel-nav-wrap">
                <a href="javascript:void(0)" class="box_price_carusel-nav box_price_carusel-nav_prev" id="box_price_carusel-nav_prev"></a>
                <a href="javascript:void(0)" class="box_price_carusel-nav box_price_carusel-nav_next" id="box_price_carusel-nav_next"></a>
            </div>
            <img class="box_price-svg1 wow slideInRight d-block d-xl-none" src="<?php echo esc_url(jullybride_camp_asset('rilsmeyker.svg')); ?>" alt="">
        </div>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</section>
<?php jullybride_template_part('camp/buy-modal'); ?>

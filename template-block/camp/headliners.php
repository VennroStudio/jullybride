<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_7_-_zagolovok');
$subtitle = jullybride_camp_field('ekran_7_-_podzagolovok');
?>
<section class="box_headliners position-relative">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if ($title) : ?>
                    <span class="section-subtitle d-block text-center wow bounceInUp"><?php echo esc_html($title); ?></span>
                <?php endif; ?>
                <?php if ($subtitle) : ?>
                    <h2 class="section-title text-center font-title wow bounceInUp"><?php echo esc_html($subtitle); ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (function_exists('have_rows') && have_rows('ekran_7_-_galereya_hedlajnerov')) : ?>
        <div class="box_headliners-list swiper-container wow bounceInUp" id="box_headliners-list-carusel">
            <ul class="owl-list box_headliners-list-carusel swiper-wrapper">
                <?php while (have_rows('ekran_7_-_galereya_hedlajnerov')) : the_row(); ?>
                    <?php
                    $name = get_sub_field('imya');
                    $photo = get_sub_field('foto');
                    $description = get_sub_field('opisanie');
                    $image_url = jullybride_camp_image_url($photo);
                    $image_alt = jullybride_camp_image_alt($photo, $name ?: 'Хедлайнер');
                    ?>
                    <?php if ($image_url) : ?>
                        <li class="swiper-slide">
                            <div class="box_headliners-list_img">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
                            </div>
                            <?php if ($name) : ?>
                                <span class="box_headliners-list-title d-block"><?php echo esc_html($name); ?></span>
                            <?php endif; ?>
                            <?php if ($description) : ?>
                                <span class="box_headliners-list-desc d-block"><?php echo esc_html($description); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="container wow bounceInUp position-relative">
        <div class="row">
            <div class="col-12">
                <div class="box-nav">
                    <a href="javascript:void(0)" class="box_headliners-list-nav box_headliners-list-prev" id="box_headliners-list-prev"></a>
                    <a href="javascript:void(0)" class="box_headliners-list-nav box_headliners-list-next" id="box_headliners-list-next"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="box_headliners-soc wow slideInRight">
        <img class="box_headliners-soc-title" src="<?php echo esc_url(jullybride_camp_asset('group-1241.svg')); ?>" alt="">
        <ul class="owl-list">
            <li><a href="https://t.me/jullybridesalon" target="_blank" rel="noopener"><img src="<?php echo esc_url(jullybride_camp_asset('symbol1-1.svg')); ?>" alt=""></a></li>
            <li><a href="https://vk.com/jullybride" target="_blank" rel="noopener"><img src="<?php echo esc_url(jullybride_camp_asset('symbol2-1.svg')); ?>" alt=""></a></li>
            <li><a href="https://instagram.com/jullybride" target="_blank" rel="noopener"><img src="<?php echo esc_url(jullybride_camp_asset('symbol3-1.svg')); ?>" alt=""></a></li>
            <li><a href="https://www.youtube.com/channel/UCo_Zo2x9fyN19uuxkWO_v-g" target="_blank" rel="noopener"><img src="<?php echo esc_url(jullybride_camp_asset('symbol4-1.svg')); ?>" alt=""></a></li>
        </ul>
    </div>
</section>

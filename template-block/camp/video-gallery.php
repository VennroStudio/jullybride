<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_6_-_zagolovok');
$subtitle = jullybride_camp_field('ekran_6_-_podzagolovok');
$button_text = jullybride_camp_field('ekran_6_-_tekst_knopki');
$button_url = jullybride_camp_field('ekran_6_-_ssylka_knopki', '#');
?>
<section class="box-look-how">
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

    <div class="container box-look-how-data">
        <div class="row">
            <div class="d-none d-xl-flex col-md-4">
                <img src="<?php echo esc_url(jullybride_camp_asset('group-1235.svg')); ?>" class="wow slideInLeft" alt="">
                <img src="<?php echo esc_url(jullybride_camp_asset('group-1237.svg')); ?>" class="wow slideInLeft" alt="">
                <img src="<?php echo esc_url(jullybride_camp_asset('group-1239.svg')); ?>" class="wow slideInLeft" alt="">
            </div>
            <div class="col-md-4 wow bounceInUp">
                <div class="box-look-how-carusel-wrap">
                    <?php if (function_exists('have_rows') && have_rows('ekran_6_-_videogalereya_v_telefone')) : ?>
                        <ul class="box-look-how-carusel owl-list owl-carousel owl-theme" id="box-look-how-carusel">
                            <?php while (have_rows('ekran_6_-_videogalereya_v_telefone')) : the_row(); ?>
                                <?php $video = jullybride_camp_image_url(get_sub_field('video')); ?>
                                <?php if ($video) : ?>
                                    <li>
                                        <video data-src="<?php echo esc_url($video); ?>" poster="<?php echo esc_url(jullybride_camp_asset('galereya1.webp')); ?>" muted playsinline class="lazy-video">
                                            Ваш браузер не поддерживает видео.
                                        </video>
                                    </li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                    <a href="javascript:void(0)" class="box-look-how-carusel-nav box-look-how-carusel-nav-prev" id="box-look-how-carusel-nav-prev"></a>
                    <a href="javascript:void(0)" class="box-look-how-carusel-nav box-look-how-carusel-nav-next" id="box-look-how-carusel-nav-next"></a>
                </div>
            </div>
            <div class="d-none d-xl-flex col-md-4">
                <img src="<?php echo esc_url(jullybride_camp_asset('group-1236.svg')); ?>" class="wow slideInRight" alt="">
                <img src="<?php echo esc_url(jullybride_camp_asset('group-1238.svg')); ?>" class="wow slideInRight" alt="">
                <img src="<?php echo esc_url(jullybride_camp_asset('group-1240.svg')); ?>" class="wow slideInRight" alt="">
            </div>
        </div>
    </div>

    <?php if ($button_text) : ?>
        <div class="container wow bounceInUp">
            <div class="row">
                <div class="col-12">
                    <a href="<?php echo esc_url($button_url); ?>" class="theme-button button-main d-table m-auto want_link"><?php echo esc_html($button_text); ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

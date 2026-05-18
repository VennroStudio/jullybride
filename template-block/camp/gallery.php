<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_4_-_zagolovok');
$subtitle = jullybride_camp_field('ekran_4_-_podzagolovok');
$intro = jullybride_camp_field('ekran_4_-_predvaritelnyj_tekst');
$gallery = jullybride_camp_field('ekran_4_-_galereya', []);
?>
<section class="box_beautiful_vacation">
    <div class="container position-relative">
        <img class="box_beautiful_vacation-img1 wow slideInLeft" src="<?php echo esc_url(jullybride_camp_asset('zavtraki-i-obedy.svg')); ?>" alt="">
        <img class="box_beautiful_vacation-img2 wow slideInRight" src="<?php echo esc_url(jullybride_camp_asset('mesta-dlya-storiz.svg')); ?>" alt="">

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
                <div class="col-12 wow bounceInUp">
                    <span class="d-block prev-text"><?php echo wp_kses_post($intro); ?></span>
                </div>
            <?php endif; ?>

            <img src="<?php echo esc_url(jullybride_camp_asset('box-beautiful-vacation-img1.svg')); ?>" class="d-block d-md-none box_beautiful_vacation-img3" alt="">

            <?php if ($gallery) : ?>
                <div class="col-12 position-relative d-none d-md-block">
                    <a href="javascript:void(0)" class="box_beautiful_vacation-carusel-nav box_beautiful_vacation-carusel-prev wow slideInLeft"></a>
                    <a href="javascript:void(0)" class="box_beautiful_vacation-carusel-nav box_beautiful_vacation-carusel-next wow slideInRight"></a>
                </div>

                <div class="d-block d-md-none wow bounceInUp position-relative">
                    <div class="position-relative">
                        <ul class="owl-list box_beautiful_vacation-carusel-mobile owl-carousel owl-theme autoheight" id="box_beautiful_vacation-carusel-mobile">
                            <?php foreach ($gallery as $image) : ?>
                                <?php
                                $image_url = jullybride_camp_image_url($image);
                                $image_alt = jullybride_camp_image_alt($image);
                                ?>
                                <?php if ($image_url) : ?>
                                    <li><img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy"></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>

                        <div class="box_beautiful_vacation-carusel-mobile-nav-dots">
                            <a href="javascript:void(0)" class="box_beautiful_vacation-carusel-mobile-nav box_beautiful_vacation-carusel-mobile-prev wow slideInLeft"></a>
                            <a href="javascript:void(0)" class="box_beautiful_vacation-carusel-mobile-nav box_beautiful_vacation-carusel-mobile-next wow slideInRight"></a>
                        </div>
                    </div>
                    <img class="d-block d-md-none box-beautiful-vacation-img2" src="<?php echo esc_url(jullybride_camp_asset('box-beautiful-vacation-img2.svg')); ?>" alt="">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($gallery) : ?>
        <?php $slides = array_chunk($gallery, 2); ?>
        <div class="swiper-container wow bounceInUp d-none d-md-block overflow-hidden" id="box_beautiful_vacation-carusel">
            <ul class="box_beautiful_vacation-carusel swiper-wrapper owl-list">
                <?php foreach ($slides as $slide_images) : ?>
                    <li class="swiper-slide">
                        <?php foreach ($slide_images as $image) : ?>
                            <?php
                            $image_url = jullybride_camp_image_url($image);
                            $image_alt = jullybride_camp_image_alt($image);
                            ?>
                            <?php if ($image_url) : ?>
                                <div><img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</section>

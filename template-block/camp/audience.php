<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_3_-_zagolovok');
$subtitle = jullybride_camp_field('ekran_3_-_podzagolovok');
$button_text = jullybride_camp_field('ekran_3_-_tekst_knopki');
$button_url = jullybride_camp_field('ekran_3_-_ssylka_knopki', '#');
$photo_one = jullybride_camp_image_url(jullybride_camp_field('ekran_3_-_foto_1_razmer_350h350'));
$photo_two = jullybride_camp_image_url(jullybride_camp_field('ekran_3_-_foto_2'));
$photo_three = jullybride_camp_image_url(jullybride_camp_field('ekran_3_-_foto_3_razmer'));
$decor_photo = jullybride_camp_image_url(jullybride_camp_field('ekran_4_-_foto_razmer_610h420'));
?>
<section class="box_for_whom position-relative">
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

    <div class="container box_for_whom-mobile">
        <div class="row">
            <div class="col-12 box_for_whom-dvij">
                <div class="whom-dvij_pointer wow slideInLeft">
                    <span>надоело</span>
                    <span>решать</span>
                    <span>вопросы</span>
                </div>
                <div class="whom-dvij_pointer wow bounceInUp">
                    <span>хочется</span>
                    <span>сменить</span>
                    <span>обстановку</span>
                </div>
                <div class="whom-dvij_pointer wow slideInRight">
                    <span>не хватает</span>
                    <span>движа</span>
                </div>

                <?php if ($photo_three) : ?>
                    <div class="whom-dvij_pointer wow bounceInUp">
                        <img src="<?php echo esc_url($photo_three); ?>" alt="">
                    </div>
                <?php endif; ?>

                <?php if ($button_text) : ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="btn-whom btn-whom-theme want_link d-none d-md-block"><?php echo esc_html($button_text); ?></a>
                <?php endif; ?>

                <?php if ($photo_one) : ?>
                    <img src="<?php echo esc_url($photo_one); ?>" class="box_for_whom-img1 wow slideInRight d-none d-xl-block" alt="">
                <?php endif; ?>

                <?php if ($photo_two) : ?>
                    <img src="<?php echo esc_url($photo_two); ?>" class="box_for_whom-img2 wow slideInLeft d-none d-xl-block" alt="">
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($button_text) : ?>
        <a href="<?php echo esc_url($button_url); ?>" class="btn-whom btn-whom-theme want_link d-block d-md-none">условия и цены</a>
    <?php endif; ?>

    <?php if ($decor_photo) : ?>
        <img src="<?php echo esc_url($decor_photo); ?>" class="box_for_whom-img3 wow slideInRight d-block d-md-none d-xl-block" alt="">
    <?php endif; ?>
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_9_-_zagolovok');
$subtitle = jullybride_camp_field('ekran_9_-_podzagolovok');
$target_date = jullybride_camp_field('ekran_9_-_data_i_vremya_do_kotorogo_schitaet_schyotchik');
$button_text = jullybride_camp_field('ekran_9_-_tekst_knopki');
$button_url = jullybride_camp_field('ekran_9_-_ssylka_knopki', '#');
?>
<section class="box_counter position-relative">
    <img class="box_counter-img d-none d-md-block" src="<?php echo esc_url(jullybride_camp_asset('serdtsa.webp')); ?>" alt="">
    <img class="box_counter-img1 d-block d-md-none" src="<?php echo esc_url(jullybride_camp_asset('serdtsa123.webp')); ?>" alt="">
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

            <div class="col-12 d-flex justify-content-center">
                <span class="box_counter-data wow bounceInUp" data-camp-countdown="<?php echo esc_attr($target_date); ?>"></span>
            </div>

            <?php if ($button_text) : ?>
                <div class="col-12 d-flex justify-content-center">
                    <a class="box_counter-btn wow jello" href="<?php echo esc_url($button_url); ?>" data-wow-iteration="10"><?php echo esc_html($button_text); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_1_-_zagovok_vverhu');
$subtitle = jullybride_camp_field('ekran_1_-_podzagolovok_vverhu');
$hero_image = jullybride_camp_image_url(jullybride_camp_field('ekran_1_-_izobrazhenie_razmer_480h715'));
$date_badge = jullybride_camp_image_url(jullybride_camp_field('ekran_1_-_shildik_daty_razmer_224h254'));
$before_button = jullybride_camp_field('ekran_1_-_tekst_pered_knopkoj');
$event_date = jullybride_camp_field('ekran_1_-_tekst_daty_meropriyatiya');
$button_text = jullybride_camp_field('ekran_1_-_tekst_knopki');
$button_url = jullybride_camp_field('ekran_1_-_ssylka_knopki', '#');
$home_source_id = function_exists('jullybride_home_source_id') ? jullybride_home_source_id() : 0;
$text_stroke = ($home_source_id && function_exists('get_field')) ? get_field('text_stroke', $home_source_id) : '';
?>
<section class="hero-block position-relative">
    <div class="hero-block-title wow slideInRight">
        <?php if ($title) : ?>
            <span><?php echo esc_html($title); ?></span>
        <?php endif; ?>
        <?php if ($subtitle) : ?>
            <span><?php echo esc_html($subtitle); ?></span>
        <?php endif; ?>
    </div>

    <div class="hero-block-image d-flex justify-content-center wow bounceInUp">
        <div class="hero-block-img position-relative">
            <?php if ($date_badge) : ?>
                <img src="<?php echo esc_url($date_badge); ?>" alt="" class="hero-block-img-img1 d-none d-lg-block">
            <?php endif; ?>
            <?php if ($hero_image) : ?>
                <img src="<?php echo esc_url($hero_image); ?>" class="hero-block-img-img" alt="<?php echo esc_attr($title); ?>" data-critical="true">
            <?php endif; ?>
            <div class="position-absolute">
                <?php if ($before_button) : ?>
                    <span class="hero-block-img-title d-block">
                        <?php echo wp_kses_post($before_button); ?>
                        <?php if ($event_date) : ?>
                            <b><br><?php echo esc_html($event_date); ?></b>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
                <?php if ($button_text) : ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="theme-button button-main d-table want_link"><?php echo esc_html($button_text); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if ($text_stroke) : ?>
        <?php
        jullybride_template_part('components/floating-strip', [
            'class' => 'lenta-stroke wow bounceInUp',
            'text' => (string) $text_stroke,
            'height' => 110,
            'viewbox_height' => 110,
            'repeat' => false,
        ]);
        ?>
    <?php endif; ?>

    <img src="<?php echo esc_url(jullybride_camp_asset('oblaka.png')); ?>" alt="" class="clouds-pattern d-none d-lg-block" data-critical="true">
    <img src="<?php echo esc_url(jullybride_camp_asset('group-1243-1.png')); ?>" alt="" class="clouds-pattern d-block d-lg-none" data-critical="true">
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_4_-_zagolovok');
$subtitle = jullybride_camp_field('ekran_4_-_podzagolovok');
$intro = jullybride_camp_field('ekran_4_-_predvaritelnyj_tekst');
$gallery = jullybride_camp_field('ekran_4_-_galereya', []);
$gallery_args = [
    'gallery' => $gallery,
    'image_url' => static function (mixed $image): string {
        return jullybride_camp_image_url($image);
    },
    'image_alt' => static function (mixed $image): string {
        return jullybride_camp_image_alt($image);
    },
];
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

            <?php
            jullybride_template_part('components/gallery', array_merge($gallery_args, [
                'part' => 'inline',
                'after_mobile' => '<img class="d-block d-md-none box-beautiful-vacation-img2" src="' . esc_url(jullybride_camp_asset('box-beautiful-vacation-img2.svg')) . '" alt="">',
            ]));
            ?>
        </div>
    </div>

    <?php
    jullybride_template_part('components/gallery', array_merge($gallery_args, [
        'part' => 'desktop',
    ]));
    ?>
</section>

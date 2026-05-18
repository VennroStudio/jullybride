<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_camp_field('ekran_2_-_zagolovok');
$subtitle = jullybride_camp_field('ekran_2_-_podzagolovok');
$intro = jullybride_camp_field('ekran_2_-_predvaritelnyj_tekst');
$program_title = jullybride_camp_field('ekran_2_-_zagolovok_2');
?>
<section class="box-reload">
    <div class="container position-relative">
        <img class="tabs-box-svg2 d-none d-lg-block wow slideInRight" src="<?php echo esc_url(jullybride_camp_asset('nashey-atmosfere-zaviduyut.svg')); ?>" alt="">
        <div class="row">
            <div class="col-12">
                <?php if ($title) : ?>
                    <span class="section-subtitle d-block text-center wow bounceInUp"><?php echo esc_html($title); ?></span>
                <?php endif; ?>
                <?php if ($subtitle) : ?>
                    <h2 class="section-title text-center font-title wow bounceInUp"><?php echo esc_html($subtitle); ?></h2>
                <?php endif; ?>
            </div>
            <div class="col-12">
                <?php if ($intro) : ?>
                    <span class="d-block prev-text wow bounceInUp"><?php echo wp_kses_post($intro); ?></span>
                <?php endif; ?>
                <?php if ($program_title) : ?>
                    <span class="d-block title-two wow bounceInUp"><?php echo esc_html($program_title); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (function_exists('have_rows') && have_rows('ekran_2_-_dni')) : ?>
        <div class="container d-none d-md-block">
            <div class="row box-reload-days">
                <?php while (have_rows('ekran_2_-_dni')) : the_row(); ?>
                    <?php
                    $image = jullybride_camp_image_url(get_sub_field('izobrazhenie'));
                    $day_title = get_sub_field('zagolovok_dnya');
                    $tags = get_sub_field('tegi');
                    ?>
                    <div class="col-12 bounceInUp <?php echo get_row_index() % 3 === 0 ? '' : 'col-xl-6'; ?> position-relative reload-days-item wow">
                        <div class="wrap" style="background: url(<?php echo esc_url($image); ?>) center no-repeat;"></div>
                        <div class="wrap_no-brightness">
                            <span class="reload-days-title">день <span><?php echo esc_html($day_title); ?></span></span>
                            <?php if ($tags) : ?>
                                <ul>
                                    <?php foreach ($tags as $tag) : ?>
                                        <li><a href="javascript:void(0)"><?php echo esc_html($tag['nazvanie_tega'] ?? ''); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (function_exists('have_rows') && have_rows('ekran_2_-_dni')) : ?>
        <div class="d-block d-md-none position-relative wow bounceInUp">
            <ul class="box-reload-mobile owl-list owl-carousel owl-theme" id="box-reload-mobile">
                <?php while (have_rows('ekran_2_-_dni')) : the_row(); ?>
                    <?php
                    $image = jullybride_camp_image_url(get_sub_field('izobrazhenie'));
                    $day_title = get_sub_field('zagolovok_dnya');
                    $tags = get_sub_field('tegi');
                    ?>
                    <li class="box-reload-mobile_item">
                        <div class="box-reload-mobile_item-wrap" style="background-image: url(<?php echo esc_url($image); ?>);"></div>
                        <div class="box-reload-mobile_title">
                            <span>день</span>
                            <span<?php echo get_row_index() === 2 ? ' style="margin-left: -28px;"' : ''; ?>><?php echo esc_html($day_title); ?></span>
                        </div>
                        <?php if ($tags) : ?>
                            <ul>
                                <?php foreach ($tags as $tag) : ?>
                                    <li><a href="javascript:void(0)"><?php echo esc_html($tag['nazvanie_tega'] ?? ''); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
            <div class="box-bottom_nav">
                <div class="d-flex justify-content-center">
                    <a href="javascript:void(0)" class="bottom_nav bottom_nav-prev" id="bottom_nav-prev"></a>
                    <a href="javascript:void(0)" class="bottom_nav bottom_nav-next" id="bottom_nav-next"></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

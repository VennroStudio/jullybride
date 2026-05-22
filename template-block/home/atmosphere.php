<?php
if (!defined('ABSPATH')) {
    exit;
}

$atmosphere_videos = [];
$atmosphere_attachment_ids = [];

if (function_exists('have_rows') && have_rows('carusel_atmosfera')) {
    while (have_rows('carusel_atmosfera')) {
        the_row();

        $video = get_sub_field('video', false);
        $video_id = is_numeric($video) ? (int) $video : 0;

        if ($video_id > 0) {
            $atmosphere_attachment_ids[] = $video_id;
        }

        if ($video) {
            $atmosphere_videos[] = $video;
        }
    }
}

if (function_exists('jullybride_prime_attachment_caches')) {
    jullybride_prime_attachment_caches($atmosphere_attachment_ids);
}
?>
            <? if ($atmosphere_videos): ?> 
                <section class="atm-pint">
                    <span class="font-cursive d-block atm-pint-left">Вау!</span>
                    <img class="atm-pint-svg1 d-none d-md-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/uyutno.svg" alt="" loading="lazy" />
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <span class="section-subtitle d-block text-center">атмосфера как в pinterest</span>
                                <h2 class="section-title text-center font-title">только в реальности</h2>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 position-relative">
                                <ul class="carousel-pint owl-list owl-carousel owl-theme autoheight" id="carousel-pint">
                                    <? foreach ($atmosphere_videos as $video): 
                                        $video_url = jullybride_media_url($video);
                                    ?>
                                        <li>
                                            <video src="<?php echo esc_url($video_url); ?>" data-src="<?php echo esc_url($video_url); ?>" muted playsinline preload="metadata" class="lazy-video">Ваш браузер не поддерживает видео.</video>
                                        </li> 
                                    <?endforeach?>                                                       
                                </ul>
                                <div class="carousel-pint-nav">
                                    <a href="javascript:void(0)" class="carousel-pint-prev" id="carousel-pint-prev"></a>
                                    <a href="javascript:void(0)" class="carousel-pint-next" id="carousel-pint-next"></a>
                                </div>
                            </div>
                        </div>   
                    </div>
                </section>
            <?endif?>

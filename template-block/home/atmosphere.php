<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
            <? if (have_rows('carusel_atmosfera')): ?> 
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
                                    <? while (have_rows('carusel_atmosfera')): the_row(); 
                                        $video = get_sub_field('video');
                                        if (!$video) {
                                            continue;
                                        }
                                    ?>
                                        <li>
                                            <video src="<?php echo esc_url($video); ?>" data-src="<?php echo esc_url($video); ?>" muted playsinline preload="metadata" class="lazy-video">Ваш браузер не поддерживает видео.</video>
                                        </li> 
                                    <?endwhile?>                                                       
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

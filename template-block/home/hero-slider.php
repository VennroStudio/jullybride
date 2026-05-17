<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
            <section class="padding-bottom-80">
                <div class="main-slide">
                    <div class="slide-duration">
                        <div class="slide-duration_indicator"></div>
                    </div>

                    <? if (have_rows('banners')): ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <ul class="main-slide_list owl-carousel owl-theme" id="main-slide-carusel">

                                        <?php 
                                        $index = 0; // Счётчик итераций
                                        while (have_rows('banners')): the_row(); 
                                            $image = get_sub_field('image');
                                            $title = get_sub_field('title');
                                            $subtitle = get_sub_field('subtitle');
                                            $text_left = get_sub_field('text_left');
                                            $text_right = get_sub_field('text_right');
                                            $link = get_sub_field('link');
                                            $button_text = get_sub_field('button_text');
                                        ?>
                                            <li class="row align-items-center">
                                                <div class="main-slide_top col-12">
                                                    <span class="font-title d-block main-slide_title text-center"><?=$title?></span>
                                                    <span class="font-cursive d-block main-slide_cursive text-center"><?=$subtitle?></span>
                                                </div>
                                                <div class="col d-none d-md-block">
                                                    <span class="font-arsenica-regular main-slide_left d-block"><?=$text_left?></span>
                                                    <a href="<?=$link?>" class="theme-button button-main d-table"><?=$button_text?></a>
                                                </div>
                                                <div class="col main-slide_img">
                                                    <div class="main-slide_img-wrap">
                                                        <span class="main-slide_img-text d-block d-md-none"><?=$text_left?></span>
                                                        <a href="<?=$link?>" class="main-slide_img-btn d-block d-md-none">Вау! Можно к вам?</a>
                                                        
                                                        <?php if ($index === 0): ?>
                                                            <img src="<?=$image?>" 
     alt="<?=$title?>" 
     fetchpriority="high"
     width="295" 
     height="439"
     data-critical="true"
     decoding="async" />
                                                        <?php else: ?>
                                                            <img data-src="<?=$image?>" alt="<?=$title?>" />
                                                        <?php endif; ?>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col d-none d-md-block">
                                                    <a href="/blog/" class="secret-link d-block"></a>
                                                    <span class="main-slide_right d-block text-end"><?=$text_right?></span>
                                                </div>
                                            </li>
                                        <?php 
                                            $index++; // Увеличиваем счётчик
                                        endwhile; 
                                        ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    <? endif;?>

                    <div class="lenta-stroke">
                        <svg width="100%" height="180" viewBox="0 0 1920 180" preserveAspectRatio="none">
                    
                            <rect x="0" y="60" width="1920" height="120" fill="#f9e5e9" />

                            <path d="M0,40 C250,-20 500,100 750,40 C1000,-20 1250,100 1500,40 C1700,-20 1850,100 1920,40 L1920,80 C1850,140 1700,20 1500,80 C1250,140 1000,20 750,80 C500,140 250,20 0,80 Z" fill="rgba(24, 24, 24, 1)" />

                            <path id="text-path" d="M0,60 C250,0 500,120 750,60 C1000,0 1250,120 1500,60 C1700,0 1850,120 1920,60" stroke="none" fill="none" />

                            <text font-size="14" fill="#fde5ec" text-anchor="middle" letter-spacing="1" id="svg_text" dy="5">
                                <textPath href="#text-path" startOffset="50%"><?=get_field('text_stroke')?><animate 
                                    attributeName="startOffset" 
                                    from="100%" 
                                    to="-100%" 
                                    dur="120s" /></textPath>
                            </text>
                        </svg>
                    </div>

                </div>

                <?php if (have_rows('carusel-added-owl')): ?>
                <div class="carusel-added container">
                    <div class="row">
                        <div class="col-1 d-md-flex d-none align-items-center">
                            <a href="javascript:void(0)" class="arrow-prev carusel-nav" id="carusel-added-prev"></a>
                        </div>
                        <div class="col-12 col-md-10">
                            <ul class="carusel-added-owl owl-carousel owl-theme" id="carusel-added-owl">
                                <?php while (have_rows('carusel-added-owl')): the_row(); 
                                    $id = 'open-carusel-added-story_' . get_row_index();
                                    $img = get_sub_field('img');
                                    $title = get_sub_field('title');
                                ?>
                                    <li id="<?=$id?>">
                                        <a href="javascript:void(0)">
                                            <img src="<?= esc_url($img) ?>" alt="<?= esc_attr($title) ?>" />
                                            <span><?= esc_html($title) ?></span>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                        <div class="col-1 d-md-flex d-none justify-content-end align-items-center">
                            <a href="javascript:void(0)" class="arrow-next carusel-nav" id="carusel-added-next"></a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </section>

<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
            <section class="box-important position-relative">
                <div class="container position-relative z-index-1">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                        <? if (have_rows('box_important')): ?>
                            <? while (have_rows('box_important')): the_row(); 
                                $title = get_sub_field('title');
                                $text = get_sub_field('text');
                            ?>
                                <div class="box-important_item1 text-center">
                                    <span class="box-important_item1-title font-cursive d-block text-center"><?=$title?></span>
                                    <span class="box-important_item1-desc"><?=$text?></span>
                                    <div>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/vector-11.svg" alt="" />
                                    </div>
                                </div>
                            <?endwhile?>
                        <?endif?>    
                        </div>
                        <div class="col-md-4">
                            <div class="box-important_item2">
                                <video 
                                    data-src="<?=get_field('video_important')?>" 
                                    poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/galereya1.webp"
                                    autoplay
                                    muted 
                                    playsinline 
                                    loop 
                                    class="bg-video lazy-video">
                                    Ваш браузер не поддерживает видео.
                                </video>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box-important_item3 d-flex justify-content-center align-items-center">
                                <div class="position-relative">
                                    <span class="box-important_item3-cursive font-cursive d-block">“то самое”</span>
                                    <span class="box-important_item3-title font-title d-block">совсем близко</span>
                                </div>
                                <span class="box-important_item3-desc">Ты находишься в одном шаге<br> от знакомства с платьем мечты!</span>
                                <a href="javascript:void(0)" class="button-main-main-bg theme-button d-table ms_booking">Записаться на примерку</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                jullybride_template_part('components/floating-strip', [
                    'class' => 'lenta-stroke2 z-index-0',
                    'text' => (string) get_field('text_stroke'),
                ]);
                ?>
                <img class="box-important-svg1 d-none d-md-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/2000.svg" alt="" />
            </section>

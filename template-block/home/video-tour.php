<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
            <section class="video-box">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <span class="section-subtitle d-block text-center">Салон, в который хочется возвращаться</span>
                            <h2 class="section-title text-center font-title">даже после свадьбы</h2>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <a class="vk-video-link" 
                                href="<?=get_field('video')?>" 
                                data-fancybox 
                                data-type="iframe"
                                data-width="1024"
                                data-height="768"
                                >
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/video.png" alt="Салон, в который хочется возвращаться" loading="lazy" />
                            </a>
                        </div>
                        <div class="col-12 text-center d-none d-md-block">
                            <span>Ты видишь это видео, потому что фото нашего<br>салона есть на твоей доске в пинтерест</span>
                        </div>
                    </div>
                </div>
                <?php
                jullybride_template_part('components/floating-strip', [
                    'class' => 'lenta-stroke2',
                    'text' => (string) get_field('text_stroke'),
                ]);
                ?>
                <img class="d-md-none d-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nashey-atmosfere-zaviduyut.svg" alt="" />      
            </section>

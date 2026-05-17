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
                <div class="lenta-stroke2">
                    <svg width="100%" height="180" viewBox="0 0 1920 180" preserveAspectRatio="none">
                        <path
                            d="M0,40 C250,-20 500,100 750,40 C1000,-20 1250,100 1500,40 C1700,-20 1850,100 1920,40 L1920,80 C1850,140 1700,20 1500,80 C1250,140 1000,20 750,80 C500,140 250,20 0,80 Z"
                            fill="rgba(24, 24, 24, 1)" />
                    
                        <path id="text-path" d="M0,60 C250,0 500,120 750,60 C1000,0 1250,120 1500,60 C1700,0 1850,120 1920,60" stroke="none"
                            fill="none" />
                    
                        <text font-size="14" fill="#fde5ec" text-anchor="middle" letter-spacing="1" id="svg_text_2" dy="5">
                            <textPath href="#text-path" startOffset="50%"><?=get_field('text_stroke')?><animate attributeName="startOffset" from="100%" to="-100%" dur="120s" repeatCount="indefinite" />
                            </textPath>
                        </text>
                    </svg>
                </div>   
                <img class="d-md-none d-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nashey-atmosfere-zaviduyut.svg" alt="" />      
            </section>

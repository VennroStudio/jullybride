<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
            <section class="sect-couture">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6 sect-couture_left-colunn">
                            <img class="sect-couture-img order-md-0 order-1" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-1230.svg" alt="" />
                            <div class="order-md-1 order-0">
                                <span class="sect-couture-subtitle d-block">свадебные платья</span>
                                <span class="sect-couture-title d-block font-title">от кутюр</span>
                            </div>
                            <div class="sect-couture-desc order-2">

                                <div class="sect-couture-text">
                                    <?=get_field('text_couture')?>
                                </div>
                                
                                <?php if (have_rows('couture_brand_gallery')): ?>
                                    <div class="row sect-couture-carusel">
                                        <div class="col-1 d-none align-items-center d-md-flex flex-column justify-content-center">
                                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev custom_btn" id="sect-couture-owl-prev"></a>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <ul class="owl-list sect-couture-owl owl-carousel owl-theme" id="sect-couture-owl">
                                                <?php if (have_rows('couture_brand_gallery')): ?>
                                                    <?php while (have_rows('couture_brand_gallery')): the_row(); 
                                                        $link_brand = get_sub_field('link_brand');
                                                        $img_brand = get_sub_field('img_brand');
                                                    ?>
                                                    <li>
                                                        <a href="<?=$link_brand?>">
                                                            <img data-src="<?=$img_brand?>" class="owl-lazy" alt="" />
                                                        </a>
                                                    </li>
                                                    <?php endwhile; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <div class="col-1 d-none align-items-center d-md-flex flex-column justify-content-center">
                                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_next custom_btn" id="sect-couture-owl-next"></a>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center d-md-none tabs-carusel_nav-mobile">
                                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev custom_btn"></a>
                                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_next custom_btn"></a>
                                        </div>
                                    </div>
                               <?php endif; ?> 

                            </div>
                            <img class="sect-couture-img2 order-3 d-none d-md-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/group-1231.svg" alt="" />
                        </div>

                        <?php if (have_rows('gallery_photo_couture')): ?>
                            <div class="col-12 col-md-6 sect-couture_right-colunn">
                                <a href="javascript:void(0)" class="sect-couture-nav sect-couture-owl2-prev" id="sect-couture-owl2-prev"></a>
                                <a href="javascript:void(0)" class="sect-couture-nav sect-couture-owl2-next" id="sect-couture-owl2-next"></a>
                                <ul class="owl-list sect-couture-owl2 owl-theme owl-carousel" id="sect-couture_right-colunn">
                                    <?php if (have_rows('gallery_photo_couture')): ?>
                                        <?php while (have_rows('gallery_photo_couture')): the_row(); 
                                            $img = get_sub_field('img');
                                            
                                            // Определяем ID изображения (универсально для всех форматов ACF)
                                            $attachment_id = 0;
                                            
                                            if (is_array($img) && !empty($img['ID'])) {
                                                // Формат "Image Array" (рекомендуется в ACF)
                                                $attachment_id = $img['ID'];
                                            } elseif (is_numeric($img)) {
                                                // Формат "Image ID"
                                                $attachment_id = (int) $img;
                                            } elseif (is_string($img)) {
                                                // Формат "Image URL" — конвертируем в ID
                                                $attachment_id = attachment_url_to_postid($img);
                                            }
                                            
                                            // Получаем миниатюру размера gallery-couture
                                            if ($attachment_id) {
                                                $image = wp_get_attachment_image_src($attachment_id, 'full');
                                                $img_url = $image[0] ?? $img; // fallback на оригинал, если миниатюра не сгенерирована
                                                $alt = !empty($img['alt']) ? $img['alt'] : get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                                            } else {
                                                // Fallback: используем оригинальный URL (если не удалось получить ID)
                                                $img_url = is_array($img) ? ($img['url'] ?? '') : $img;
                                                $alt = is_array($img) ? ($img['alt'] ?? '') : '';
                                            }
                                        ?>
                                            <li>
                                                <img data-src="<?= esc_url($img_url) ?>" 
                                                    class="owl-lazy" 
                                                    alt="<?= esc_attr($alt) ?>"
                                                />
                                            </li>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?> 

                    </div>
                </div>
            </section>

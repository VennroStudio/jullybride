<?php
if (!defined('ABSPATH')) {
    exit;
}

$couture_brands = [];
$couture_gallery = [];
$couture_attachment_ids = [];

if (function_exists('have_rows') && have_rows('couture_brand_gallery')) {
    while (have_rows('couture_brand_gallery')) {
        the_row();

        $img_brand = get_sub_field('img_brand', false);
        $img_brand_id = is_numeric($img_brand) ? (int) $img_brand : 0;

        if ($img_brand_id > 0) {
            $couture_attachment_ids[] = $img_brand_id;
        }

        $couture_brands[] = [
            'link_brand' => (string) get_sub_field('link_brand'),
            'img_brand' => $img_brand,
        ];
    }
}

if (function_exists('have_rows') && have_rows('gallery_photo_couture')) {
    while (have_rows('gallery_photo_couture')) {
        the_row();

        $image = get_sub_field('img', false);
        $image_id = is_numeric($image) ? (int) $image : 0;

        if ($image_id > 0) {
            $couture_attachment_ids[] = $image_id;
        }

        $couture_gallery[] = [
            'image' => $image,
            'image_id' => $image_id,
        ];
    }
}

if (function_exists('jullybride_prime_attachment_caches')) {
    jullybride_prime_attachment_caches($couture_attachment_ids);
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
                                
                                <?php if ($couture_brands): ?>
                                    <div class="row sect-couture-carusel">
                                        <div class="col-1 d-none align-items-center d-md-flex flex-column justify-content-center">
                                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev custom_btn" id="sect-couture-owl-prev"></a>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <ul class="owl-list sect-couture-owl owl-carousel owl-theme" id="sect-couture-owl">
                                                <?php foreach ($couture_brands as $brand): ?>
                                                    <li>
                                                        <a href="<?=$brand['link_brand']?>">
                                                            <img data-src="<?=esc_url(jullybride_media_url($brand['img_brand']))?>" class="owl-lazy" alt="" />
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
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

                        <?php if ($couture_gallery): ?>
                            <div class="col-12 col-md-6 sect-couture_right-colunn">
                                <a href="javascript:void(0)" class="sect-couture-nav sect-couture-owl2-prev" id="sect-couture-owl2-prev"></a>
                                <a href="javascript:void(0)" class="sect-couture-nav sect-couture-owl2-next" id="sect-couture-owl2-next"></a>
                                <ul class="owl-list sect-couture-owl2 owl-theme owl-carousel" id="sect-couture_right-colunn">
                                    <?php foreach ($couture_gallery as $gallery_item): 
                                            $attachment_id = (int) $gallery_item['image_id'];
                                            $img_url = jullybride_media_url($gallery_item['image']);
                                            $alt = $attachment_id > 0 ? (string) get_post_meta($attachment_id, '_wp_attachment_image_alt', true) : '';
                                        ?>
                                            <li>
                                                <img data-src="<?= esc_url($img_url) ?>" 
                                                    class="owl-lazy" 
                                                    alt="<?= esc_attr($alt) ?>"
                                                />
                                            </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?> 

                    </div>
                </div>
            </section>

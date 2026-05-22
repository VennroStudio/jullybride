<?php
if (!defined('ABSPATH')) {
    exit;
}

$reviews = [];
$review_image_ids = [];

if (function_exists('have_rows') && have_rows('reviews')) {
    while (have_rows('reviews')) {
        the_row();

        $foto = get_sub_field('foto', false);
        $foto_id = is_numeric($foto) ? (int) $foto : 0;

        if ($foto_id > 0) {
            $review_image_ids[] = $foto_id;
        }

        $reviews[] = [
            'foto' => $foto,
            'foto_id' => $foto_id,
            'fio' => (string) get_sub_field('fio'),
            'tekst' => (string) get_sub_field('tekst'),
            'link' => (string) get_sub_field('link'),
            'date' => (string) get_sub_field('date'),
        ];
    }
}

if (function_exists('jullybride_prime_attachment_caches')) {
    jullybride_prime_attachment_caches($review_image_ids);
}
?>
            <section class="your-turn">
                <div class="your-turn_righ_top">
                    <img class="your-turn-svg2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/spletni.svg" alt="" />
                    <ul>
                        <li><a href="https://t.me/jullybridesalon" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-telegram.svg" alt=""/></a></li>
                        <li><a href="https://vk.com/jullybride" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-vkontakte.svg" alt=""/></a></li>
                        <li><a href="https://instagram.com/jullybride" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-instagram.svg" alt=""/></a></li>
                        <li><a href="https://www.youtube.com/channel/UCo_Zo2x9fyN19uuxkWO_v-g" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-youtube.svg" alt=""/></a></li>
                    </ul>
                </div>

                <? if ($reviews): ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <span class="section-subtitle d-block text-center">эти невесты выбрали быть счастливыми</span>
                                <h2 class="section-title text-center font-title">теперь твоя очередь!</h2>
                            </div>
                        </div>
                    </div>
                    <ul class="owl-list reviews-carusel owl-carousel owl-theme center_item" id="reviews-carusel">
                        <? foreach ($reviews as $review):
                            $foto = jullybride_media_url($review['foto']);
                            $fio = $review['fio'];
                            $tekst = $review['tekst'];
                            $link = $review['link'];
                            $date = $review['date'];
                        ?>
                            <li>
                                <div class="reviews_item_wrap">
                                    <div class="reviews_item-boximg d-flex justify-content-center align-items-center">
                                        <?if(!empty($foto)):?>
                                            <img class="reviews_item-img" src="<?=$foto?>" alt="<?=$fio?>" />
                                        <?else:?>
                                            <img class="reviews_item-img" src="<?php echo esc_url(jullybride_logo_url('dark')); ?>" alt="<?=$fio?>" />
                                        <?endif?>
                                    </div>
                                    <span class="reviews_item-name d-block"><?=$fio?></span>
                                    <span class="reviews_item-desc d-block"><?= mb_strlen($tekst) > 120 ? mb_substr($tekst, 0, 120, 'UTF-8') . '...' : $tekst; ?></span>
                                </div>
                                <a href="<?=$link?>" class="reviews_item-more" target="_blank">Читать отзыв полностью</a>
                                <span class="reviews_item-date d-block"><?=$date?></span>
                            </li>
                        <?endforeach?>
                    </ul>
                    <div class="tabs-carusel_dot new-in-salon-carusel_dot reviews-carusel_dot d-none d-md-table">
                        <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev custom_btn" id="reviews-carusel_prev"></a>
                        <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_next custom_btn" id="reviews-carusel_next"></a>
                    </div>
                <?endif?>

                <div class="site-data d-flex justify-content-center align-items-center">
                    <span class="font-cursive">Оценка 5.0</span>
                    <a href="https://yandex.ru/maps/-/CDF0mUZg" target="_blank" class="text-decoration-none">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/subtraction-2.svg" alt="яндекс" />
                        <span>1200+ отзывов</span>
                    </a>
                    <div class="logos-row d-flex">
                        <a href="https://maps.app.goo.gl/g4cstST3aWEhCi5k9" target="_blank">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/gegl.svg" alt="google">
                        </a>
                        <a href="https://2gis.ru/spb/firm/5348553838718306" target="_blank">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tugis.svg" alt="2gis">
                        </a>
                    </div>
                </div>
                <img class="your-turn-svg1" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nevesty-vybirayut.svg" alt="" />
            </section>

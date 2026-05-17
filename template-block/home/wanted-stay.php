<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
            <!-- Блок не виден в мобиле -->
            <? if (have_rows('zashla_prosto_na_kofe')): ?>
                <section class="wanted-stay d-none d-md-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 position-relative">
                                <span class="section-subtitle d-block text-center">зашла “просто на кофе” — </span>
                                <h2 class="section-title text-center font-title">захотела остаться</h2>
                                <span class="sub-text">желательно навсегда</span>
                            </div>
                        </div>
                    </div>

                    <?php
                        $all_items = [];

                        // 1. Добавляем динамические элементы из Repeater'а
                        if (have_rows('zashla_prosto_na_kofe')) {
                            while (have_rows('zashla_prosto_na_kofe')) {
                                the_row();
                                $all_items[] = [
                                    'type' => 'dynamic',
                                    'img' => get_sub_field('img'),
                                    'sort' => (int) get_sub_field('sort') // приводим к числу!
                                ];
                            }
                        }

                        // 2. Добавляем статичные элементы с их "виртуальными" sort-значениями
                        $all_items[] = [
                            'type' => 'static_1',
                            'sort' => 2 // ← задайте нужное значение сортировки
                        ];

                        $all_items[] = [
                            'type' => 'static_4',
                            'sort' => 7 // ← задайте нужное значение
                        ];

                        $all_items[] = [
                            'type' => 'static_carousel',
                            'sort' => 5 // ← задайте нужное значение
                        ];
                        usort($all_items, function($a, $b) {
                            return $a['sort'] - $b['sort'];
                        });
                    ?>

                        <div class="wanted-stay-grid wanted-stay-grid1">

                            <?foreach ($all_items as $item): ?>
                                <? if ($item['type'] === 'dynamic'): ?>
                                    <div class="item" rel="<?=$item['sort']?>">
                                        <img src="<?= esc_url($item['img']); ?>" alt="" loading="lazy">
                                    </div>

                                <? elseif ($item['type'] === 'static_1'): ?>
                                    <div class="item" rel="<?=$item['sort']?>">
                                        <a href="/c/pink-merch/">
                                            <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/rozovyy-merch.svg" alt="" loading="lazy">
                                        </a>
                                    </div>

                                <? elseif ($item['type'] === 'static_carousel'): ?>
                                    <? if (have_rows('carusel_v_galeree_izobrazhenij')): ?>
                                        <div class="item" rel="<?=$item['sort']?>">
                                            <div class="owl-wrapper">
                                                <ul class="owl-list owl-carousel owl-theme wanted-stay-owl" id="wanted-stay-owl">
                                                    <? while (have_rows('carusel_v_galeree_izobrazhenij')): the_row(); ?>
                                                        <li><img src="<?=get_sub_field('img')?>" alt=""></li>
                                                    <?endwhile?>
                                                </ul>
                                            </div> 
                                        </div>
                                    <? endif; ?>
                                <? elseif ($item['type'] === 'static_4'): ?>
                                    <div class="item" rel="<?=$item['sort']?>">
                                        <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/luchshaya-primerka.svg" alt="" loading="lazy">
                                    </div>
                                <? endif; ?>
                            <? endforeach; ?>

                        </div>
                </section>
            <?endif?>

            <!-- Этот блок виден только в мобиле -->
            <section class="wanted-stay-mobile d-block d-md-none">
                <div class="container">
                    <div class="row">
                        <div class="col-12 position-relative">
                            <span class="section-subtitle d-block text-center">зашла “просто на кофе” — </span>
                            <h2 class="section-title text-center font-title">захотела остаться</h2>
                            <span class="sub-text">желательно навсегда</span>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 position-relative wanted-stay-mobile-bg">
                            <ul class="owl-list wanted-stay-mobile-carusel owl-carousel owl-theme autoheight" id="wanted-stay-mobile-carusel"></ul>
                            <div class="mobile-dots d-flex d-md-none justify-content-between">
                                <a href="javascript:void(0)" id="wanted-stay-mobile-carusel-prev"></a>
                                <a href="javascript:void(0)" id="wanted-stay-mobile-carusel-next"></a>
                            </div>
                        </div>
                        <div class="col-12 d-block d-md-none">
                            <a href="" class="wanted-stay-mobile-svg1 d-table"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rozovyy-merch.svg" alt="" loading="lazy"></a>
                        </div>
                    </div>
                </div>
            </section>

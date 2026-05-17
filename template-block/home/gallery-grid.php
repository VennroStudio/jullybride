<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
            <? if (have_rows('grid_slide')): ?>
                <section class="grid-slide position-relative d-none d-md-block">
                    <span class="font-cursive">атмосфера</span>
                    <img class="item-info-svg2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/vlyubilasь-v-platьe.svg" alt="" loading="lazy">
                   
                    <?php
                    $items = [];
                    // Собираем все элементы в массив
                    while (have_rows('grid_slide')) {
                        the_row();
                        if(!empty(get_sub_field('product_id'))){
                            $items[] = [
                                'title' => get_sub_field('title'),
                                'sub_title' => get_sub_field('sub_title'),
                                'product_name' => get_sub_field('product_name'),
                                'product_id' => get_sub_field('product_id'),
                                'img' => get_sub_field('img'),
                            ];
                        }
                    }

                    // Группируем по 9 элементов на слайд
                    $slides = array_chunk($items, 9);
                    ?>

                    <ul class="owl-list grid-slide-list owl-carousel owl-theme" id="adv-slide_carusel">
                        <?php foreach ($slides as $slide_items): ?>
                            <li>
                                <!-- Первая строка: первые 5 элементов -->
                                <div class="grid-slide-row">
                                    <?php for ($i = 0; $i < 5 && isset($slide_items[$i]); $i++): ?>
                                        <? 
                                        $product = wc_get_product($slide_items[$i]['product_id']);
                                        ?>
                                        <div class="item" rel="<?=$i?>">
                                            <div class="wrap">
                                                <div class="item-info">
                                                    <a href="javascript:void(0)" class="add-fav woosw-btn" data-id="<?=$product->id?>" data-product_name="<?=$product->get_name()?>" aria-label=" "></a>
                                                    <div class="item-info-first">
                                                        <span><?=$slide_items[$i]['title']?></span>
                                                        <span><?=$slide_items[$i]['sub_title']?></span>
                                                    </div>
                                                    <span class="item-info-two"><?=$slide_items[$i]['product_name']?></span>
                                                    <a href="<?=esc_url($product->get_permalink())?>" class="item-info-btn">хочу примерить</a>
                                                </div>
                                                <?php if (!empty($slide_items[$i]['img'])): ?>
                                                    <img src="<?php echo esc_url($slide_items[$i]['img']); ?>" alt="" loading="lazy">
                                                <?php endif; ?>
                                            </div>
                                        </div>         
                                    <?php endfor; ?>
                                </div>

                                <!-- Вторая строка: следующие 4 элемента -->
                                <div class="grid-slide-row">
                                    <?php for ($i = 5; $i < 9 && isset($slide_items[$i]); $i++): ?>
                                        <? 
                                        $product = wc_get_product($slide_items[$i]['product_id']);
                                        ?>
                                        <div class="item" rel="<?=$i?>">
                                            <?if($i == 6):?>
                                                <img class="item-info-svg1 owl-lazy" data-src="<?=get_stylesheet_directory_uri(); ?>/assets/images/schastliva.svg" alt="" />
                                            <?endif?>
                                            <div class="wrap">
                                                <div class="item-info">
                                                    <a href="javascript:void(0)" class="add-fav woosw-btn" data-id="<?=$product->id?>" data-product_name="<?=$product->get_name()?>" aria-label=" "></a>
                                                    <div class="item-info-first">
                                                        <span><?=$slide_items[$i]['title']?></span>
                                                        <span><?=$slide_items[$i]['sub_title']?></span>
                                                    </div>
                                                    <span class="item-info-two"><?=$slide_items[$i]['product_name']?></span>
                                                    <a href="<?=esc_url($product->get_permalink())?>" class="item-info-btn">хочу примерить</a>
                                                </div>
                                                <?php if (!empty($slide_items[$i]['img'])): ?>
                                                    <img src="<?php echo esc_url($slide_items[$i]['img']); ?>" alt="" loading="lazy">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
        
                    <span class="font-cursive">эмоции</span>
                </section>
            <?endif?>

            <!-- Этот блок виден только в мобиле -->
            <? if (have_rows('grid_slide')): ?>
                <section class="grid-slide-mobile d-md-none d-block position-relative">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 position-relative">
                                <ul class="owl-list grid-slide-mobile-list owl-carousel owl-theme autoheight" id="grid-slide-mobile-list">
                                    <? while (have_rows('grid_slide')): the_row(); 
                                        if(!empty(get_sub_field('product_id'))){
                                            $title = get_sub_field('title');
                                            $sub_title = get_sub_field('sub_title');
                                            $product_name = get_sub_field('product_name');
                                            $product_id = get_sub_field('product_id');
                                            $img = get_sub_field('img');
                                            $product = wc_get_product($product_id);    
                                        }
                                    ?>
                                        <li>
                                            <div class="wrap">
                                                <div class="item-info">
                                                    <a href="javascript:void(0)" class="add-fav woosw-btn" data-id="<?=$product->id?>" data-product_name="<?=$product->get_name()?>" aria-label=" "></a>
                                                    <div class="item-info-first">
                                                        <span><?=$title?></span>
                                                        <span><?=$sub_title?></span>
                                                    </div>
                                                    <span class="item-info-two"><?=$product_name?></span>
                                                    <a href="<?=esc_url($product->get_permalink())?>" class="item-info-btn">хочу примерить</a>
                                                </div>
                                                <img src="<?=esc_url($img);?>" alt="<?=$title." ".$sub_title." ".$product_name?>">
                                            </div>
                                        </li>
                                    <?endwhile?>
                                </ul>
                                <div class="mobile-dots d-flex d-md-none justify-content-between">
                                    <a href="javascript:void(0)" id="grid-slide-mobile-prev"></a>
                                    <a href="javascript:void(0)" id="grid-slide-mobile-next"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img class="grid-slide-mobile-svg1 d-block d-md-none" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/vlyubilasь-v-platьe.svg" alt="" loading="lazy">
                </section>
            <?endif?>

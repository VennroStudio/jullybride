<?php
if (!defined('ABSPATH')) {
    exit;
}

$group = $args['group'] ?? [];
$catalog_url = (string) ($args['catalog_url'] ?? '#');
$query_args = $args['query_args'] ?? null;

if (!$group || !is_callable($query_args)) {
    return;
}
?>
<div class="row mobile-direction">
    <div class="col-md-10">
        <div class="tabs-content">
            <div class="tabs-carusel">
                <?php foreach ((array) ($group['items'] ?? []) as $item_index => $item) : ?>
                    <?php $carousel_id = (int) ($item['id'] ?? 0); ?>
                    <div class="tab-content<?php echo $item_index === 0 ? ' active' : ''; ?>">
                        <div class="mobile-dots d-flex d-md-none justify-content-between">
                            <a href="javascript:void(0)" id="mobile-dots-prev<?php echo esc_attr($carousel_id); ?>"></a>
                            <a href="javascript:void(0)" id="mobile-dots-next<?php echo esc_attr($carousel_id); ?>"></a>
                        </div>
                        <ul class="owl-carousel owl-theme tabs-carusel_list" id="tabs-carusel_<?php echo esc_attr($carousel_id); ?>">
                            <?php
                            $products = new WP_Query($query_args($item, $group['main_category'] ?? 'wedding'));
                            if ($products->have_posts()) :
                                while ($products->have_posts()) :
                                    $products->the_post();
                                    $product = wc_get_product(get_the_ID());
                                    jullybride_template_part('components/dress-tab-product-card', ['product' => $product]);
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </ul>
                        <div class="tabs-carusel_dot d-none d-md-table">
                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev" id="tabs-carusel_prev_<?php echo esc_attr($carousel_id); ?>"></a>
                            <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_next" id="tabs-carusel_next_<?php echo esc_attr($carousel_id); ?>"></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="<?php echo esc_attr($group['sidebar_class'] ?? 'col-12 col-md-2 position-relative'); ?>">
        <ul class="categories-list">
            <?php foreach ((array) ($group['items'] ?? []) as $item_index => $item) : ?>
                <li class="<?php echo $item_index === 0 ? 'active ' : ''; ?>tab-trigger"><a href="javascript:void(0)"><?php echo esc_html((string) ($item['label'] ?? '')); ?></a></li>
            <?php endforeach; ?>
            <li class="d-md-none d-block"><a href="<?php echo esc_url($catalog_url); ?>">Смотреть все</a></li>
        </ul>
        <a href="<?php echo esc_url($catalog_url); ?>" class="button-main-main-bg theme-button d-md-block d-none text-center custom-btn">Перейти в каталог</a>
    </div>
</div>

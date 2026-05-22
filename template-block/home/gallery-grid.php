<?php
if (!defined('ABSPATH')) {
    exit;
}

$has_rows = function_exists('have_rows') && have_rows('grid_slide');

if (!$has_rows) {
    return;
}

$items = [];
$product_ids = [];
$gallery_image_ids = [];

while (have_rows('grid_slide')) {
    the_row();

    $product_value = get_sub_field('product_id', false);
    if ($product_value instanceof WC_Product) {
        $product_id = $product_value->get_id();
    } elseif ($product_value instanceof WP_Post) {
        $product_id = (int) $product_value->ID;
    } else {
        $product_id = (int) $product_value;
    }

    if ($product_id <= 0) {
        continue;
    }

    $image = get_sub_field('img', false);
    $image_id = is_numeric($image) ? (int) $image : 0;

    if ($image_id > 0) {
        $gallery_image_ids[] = $image_id;
    }

    $items[] = [
        'title' => (string) get_sub_field('title'),
        'sub_title' => (string) get_sub_field('sub_title'),
        'product_name' => (string) get_sub_field('product_name'),
        'product_id' => $product_id,
        'img' => $image,
    ];
    $product_ids[] = $product_id;
}

if (!$items) {
    return;
}

if (function_exists('jullybride_prime_product_caches')) {
    jullybride_prime_product_caches($product_ids);
}

if (function_exists('jullybride_prime_attachment_caches')) {
    jullybride_prime_attachment_caches($gallery_image_ids);
}

$products_by_id = [];
foreach (array_values(array_unique(array_filter(array_map('absint', $product_ids)))) as $product_id) {
    $product = wc_get_product($product_id);

    if ($product instanceof WC_Product) {
        $products_by_id[$product_id] = $product;
    }
}

if (function_exists('jullybride_prime_product_image_caches')) {
    jullybride_prime_product_image_caches(array_values($products_by_id));
}

$render_grid_item = static function (array $item, int $index, bool $with_decor = false) use ($products_by_id): void {
    $product = $products_by_id[(int) $item['product_id']] ?? null;

    if (!$product instanceof WC_Product) {
        return;
    }
    ?>
    <div class="item" rel="<?php echo esc_attr((string) $index); ?>">
        <?php if ($with_decor) : ?>
            <img class="item-info-svg1 owl-lazy" data-src="<?php echo esc_url(jullybride_asset_uri('images/schastliva.svg')); ?>" alt="" />
        <?php endif; ?>
        <div class="wrap">
            <div class="item-info">
                <a href="javascript:void(0)" class="add-fav woosw-btn" data-id="<?php echo esc_attr((string) $product->get_id()); ?>" data-product_name="<?php echo esc_attr($product->get_name()); ?>" aria-label=" "></a>
                <div class="item-info-first">
                    <span><?php echo esc_html($item['title']); ?></span>
                    <span><?php echo esc_html($item['sub_title']); ?></span>
                </div>
                <span class="item-info-two"><?php echo esc_html($item['product_name']); ?></span>
                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="item-info-btn">хочу примерить</a>
            </div>
            <?php if (!empty($item['img'])) : ?>
                <img src="<?php echo esc_url(jullybride_media_url($item['img'])); ?>" alt="" loading="lazy">
            <?php endif; ?>
        </div>
    </div>
    <?php
};

$slides = array_chunk($items, 9);
?>
<section class="grid-slide position-relative d-none d-md-block">
    <span class="font-cursive">атмосфера</span>
    <img class="item-info-svg2" src="<?php echo esc_url(jullybride_asset_uri('images/vlyubilasь-v-platьe.svg')); ?>" alt="" loading="lazy">

    <ul class="owl-list grid-slide-list owl-carousel owl-theme" id="adv-slide_carusel">
        <?php foreach ($slides as $slide_items) : ?>
            <li>
                <div class="grid-slide-row">
                    <?php for ($i = 0; $i < 5 && isset($slide_items[$i]); $i++) : ?>
                        <?php $render_grid_item($slide_items[$i], $i); ?>
                    <?php endfor; ?>
                </div>

                <div class="grid-slide-row">
                    <?php for ($i = 5; $i < 9 && isset($slide_items[$i]); $i++) : ?>
                        <?php $render_grid_item($slide_items[$i], $i, $i === 6); ?>
                    <?php endfor; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <span class="font-cursive">эмоции</span>
</section>

<section class="grid-slide-mobile d-md-none d-block position-relative">
    <div class="container">
        <div class="row">
            <div class="col-12 position-relative">
                <ul class="owl-list grid-slide-mobile-list owl-carousel owl-theme autoheight" id="grid-slide-mobile-list">
                    <?php foreach ($items as $item) : ?>
                        <?php
                        $product = $products_by_id[(int) $item['product_id']] ?? null;
                        if (!$product instanceof WC_Product) {
                            continue;
                        }
                        ?>
                        <li>
                            <div class="wrap">
                                <div class="item-info">
                                    <a href="javascript:void(0)" class="add-fav woosw-btn" data-id="<?php echo esc_attr((string) $product->get_id()); ?>" data-product_name="<?php echo esc_attr($product->get_name()); ?>" aria-label=" "></a>
                                    <div class="item-info-first">
                                        <span><?php echo esc_html($item['title']); ?></span>
                                        <span><?php echo esc_html($item['sub_title']); ?></span>
                                    </div>
                                    <span class="item-info-two"><?php echo esc_html($item['product_name']); ?></span>
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="item-info-btn">хочу примерить</a>
                                </div>
                                <?php if (!empty($item['img'])) : ?>
                                    <img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr(trim($item['title'] . ' ' . $item['sub_title'] . ' ' . $item['product_name'])); ?>">
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="mobile-dots d-flex d-md-none justify-content-between">
                    <a href="javascript:void(0)" id="grid-slide-mobile-prev"></a>
                    <a href="javascript:void(0)" id="grid-slide-mobile-next"></a>
                </div>
            </div>
        </div>
    </div>
    <img class="grid-slide-mobile-svg1 d-block d-md-none" src="<?php echo esc_url(jullybride_asset_uri('images/vlyubilasь-v-platьe.svg')); ?>" alt="" loading="lazy">
</section>

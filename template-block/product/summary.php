<?php
if (!defined('ABSPATH')) {
    exit;
}

$product = $args['product'] ?? wc_get_product(get_the_ID());
if (!$product instanceof WC_Product) {
    return;
}

$product_id = $product->get_id();
$category_slug = 'wedding';
$main_category = function_exists('jullybride_get_main_product_category') ? jullybride_get_main_product_category($product_id) : null;

if ($main_category instanceof WP_Term) {
    $category_slug = $main_category->slug;
} else {
    $category_terms = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'slugs']);
    if ($category_terms) {
        $category_slug = reset($category_terms);
    }
}

$catalog_base_url = home_url('/c/' . $category_slug . '/');
$designer_links = [];

foreach ([
    ['param' => 'pa_designer', 'taxonomies' => ['pa_designer']],
    ['param' => 'pa_collection', 'taxonomies' => ['pa_collection']],
] as $group) {
    $links_before = count($designer_links);

    foreach ($group['taxonomies'] as $taxonomy) {
        if (!taxonomy_exists($taxonomy)) {
            continue;
        }

        $terms = wc_get_product_terms($product_id, $taxonomy);
        if (!$terms || is_wp_error($terms)) {
            continue;
        }

        foreach ($terms as $term) {
            if (!$term instanceof WP_Term) {
                continue;
            }

            $url = add_query_arg(['_f' => '1', $group['param'] => $term->slug], $catalog_base_url);
            $designer_links[$taxonomy . ':' . $term->slug] = '<a href="' . esc_url($url) . '">' . esc_html($term->name) . '</a>';
        }

        if (count($designer_links) > $links_before) {
            break;
        }
    }
}

$size_terms = taxonomy_exists('pa_razmer') ? wc_get_product_terms($product_id, 'pa_razmer') : [];
$sizes_info = [];
$variation_map = [];

if ($product->is_type('variable')) {
    $available_variations = $product->get_available_variations();
    foreach ($size_terms as $term) {
        $in_stock = false;
        $variation_id = 0;
        $sku = '';

        foreach ($available_variations as $variation) {
            if (($variation['attributes']['attribute_pa_razmer'] ?? '') !== $term->slug) {
                continue;
            }

            $variation_product = wc_get_product($variation['variation_id']);
            $variation_id = (int) $variation['variation_id'];
            $sku = $variation_product ? (string) $variation_product->get_sku() : '';
            $in_stock = $variation_product && $variation_product->is_in_stock();
            break;
        }

        $sizes_info[] = ['term' => $term, 'in_stock' => $in_stock];
        if ($variation_id) {
            $variation_map[$term->slug] = ['id' => $variation_id, 'sku' => $sku, 'size' => $term->slug];
        }
    }
} else {
    foreach ($size_terms as $term) {
        $sizes_info[] = ['term' => $term, 'in_stock' => $product->is_in_stock()];
    }
}

$active_size = '';
foreach ($sizes_info as $size) {
    if ($size['in_stock']) {
        $active_size = $size['term']->slug;
        break;
    }
}
?>
<?php if ($designer_links) : ?>
    <span class="product-header_collect d-block"><?php echo wp_kses_post(implode(' ', $designer_links)); ?></span>
<?php endif; ?>

<div class="product-header_right-item1 row">
    <div class="col-md-6">
        <h1 class="product-header_name d-block"><?php echo esc_html($product->get_name()); ?></h1>
        <span class="product-header_cat d-block"><?php echo esc_html(jullybride_product_type_label($product_id)); ?></span>
    </div>
    <div class="col-md-6 position-relative">
        <?php if ($product->is_in_stock()) : ?>
            <span class="d-md-none product-header_stock d-block header_stock-mobile">В наличии</span>
        <?php endif; ?>
        <?php if ($product->get_price() !== '') : ?>
            <span class="product-header_price d-block"><?php echo esc_html(jullybride_format_price($product->get_price())); ?></span>
        <?php endif; ?>
        <?php if ($product->get_regular_price() && (float) $product->get_regular_price() > (float) $product->get_price()) : ?>
            <span class="product-header_oldprice d-block"><?php echo esc_html(jullybride_format_price($product->get_regular_price())); ?></span>
        <?php endif; ?>
    </div>
</div>

<?php if ($product->is_in_stock()) : ?>
    <span class="d-block product-header_stock d-none d-md-block">В наличии</span>
<?php endif; ?>

<?php if ($sizes_info) : ?>
    <div class="d-flex product-header_size">
        <span>Размер:</span>
        <ul class="d-flex owl-list product-header_size-list">
            <?php foreach ($sizes_info as $size) : ?>
                <?php $term = $size['term']; ?>
                <li>
                    <?php if ($size['in_stock']) : ?>
                        <a href="#" data-size="<?php echo esc_attr($term->slug); ?>" class="<?php echo $term->slug === $active_size ? 'active' : ''; ?>"><?php echo esc_html($term->name); ?></a>
                    <?php else : ?>
                        <a href="#" class="disables" aria-disabled="true"><?php echo esc_html($term->name); ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<script>
window.jullybrideVariationMap = <?php echo wp_json_encode($variation_map); ?>;
document.addEventListener('DOMContentLoaded', function () {
    const sizeLinks = document.querySelectorAll('.product-header_size-list a[data-size]');
    const skuElement = document.querySelector('.product-sku');
    sizeLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const data = window.jullybrideVariationMap?.[this.dataset.size];
            sizeLinks.forEach(function (item) { item.classList.remove('active'); });
            this.classList.add('active');
            if (data && skuElement) {
                skuElement.textContent = data.sku || skuElement.textContent;
            }
        });
    });
});
</script>

<?php if ($product->get_sku()) : ?>
    <span class="d-block product-header_article">Артикул: <span class="product-sku"><?php echo esc_html($product->get_sku()); ?></span></span>
<?php endif; ?>

<div class="d-grid product-header_btn">
    <a href="javascript:void(0)" class="add-favorite woosw-btn" data-id="<?php echo esc_attr($product_id); ?>" data-product_name="<?php echo esc_attr($product->get_name()); ?>" aria-label=" "></a>
    <a href="javascript:void(0)" class="theme-button button-main ms_booking">Записаться на примерку</a>
    <span class="font-cursive d-none d-md-block">или звони:</span>
    <img src="<?php echo esc_url(jullybride_asset_uri('images/ili-zvoni.svg')); ?>" class="d-md-none d-block" alt="">
    <a href="tel:+78129291699" class="product-header_phone">+7 (812) 929-16-99</a>
</div>
<div class="d-md-block product-header_decor d-none d-md-block">
    <img src="<?php echo esc_url(jullybride_asset_uri('images/nadpisi.svg')); ?>" alt="">
</div>
<div class="d-md-none product-header_decor d-block">
    <img src="<?php echo esc_url(jullybride_asset_uri('images/nadpisi-1.svg')); ?>" alt="">
</div>

<?php
$description = $product->get_description();
$description = jullybride_clean_builder_content((string) $description);
$description = trim(wp_strip_all_tags(strip_shortcodes($description)));
?>
<?php if ($description) : ?>
    <div class="product-header_prevtext">
        <?php echo esc_html($description); ?>
    </div>
<?php endif; ?>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$term = is_product_category() ? get_queried_object() : null;
$text = '';
if ($term instanceof WP_Term && function_exists('get_field')) {
    $text = get_field('seo_text', 'product_cat_' . $term->term_id) ?: get_field('opisanie', 'product_cat_' . $term->term_id);
}
if (!$text && !is_product_category()) {
    $page_id = jullybride_catalog_page_id();
    $text = $page_id ? get_post_field('post_content', $page_id) : '';
}
if (!$text && is_product_category()) {
    $text = category_description();
}

if (!$text) {
    return;
}
?>
<section class="cat-desc">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cat-desc_text text-ellipsis-multiline">
                    <?php echo wp_kses_post(wpautop($text)); ?>
                </div>
                <a href="javascript:void(0)" class="cat-desc_more">Читать дальше</a>
            </div>
        </div>
    </div>
</section>

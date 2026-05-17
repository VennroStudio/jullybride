<?php
if (!defined('ABSPATH')) {
    exit;
}

$term = is_product_category() ? get_queried_object() : null;
$catalog_page_id = jullybride_catalog_page_id();
$title = $term instanceof WP_Term ? $term->name : get_the_title($catalog_page_id);
$h1 = $term instanceof WP_Term && function_exists('get_field') ? get_field('h1', 'product_cat_' . $term->term_id) : '';
?>
<section class="breadcrubs-custom">
    <div class="container">
        <div class="row">
            <div class="col-12"><?php jullybride_breadcrumbs(); ?></div>
        </div>
    </div>
</section>

<section class="top-products">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="font-title"><?php echo esc_html($h1 ?: $title ?: 'Каталог'); ?></h1>
            </div>
        </div>
    </div>
</section>

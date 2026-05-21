<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();

$catalog_query = new WP_Query(jullybride_catalog_query_args());
?>

<?php jullybride_template_part('catalog/story-overlays'); ?>

<main class="main-page content products">
    <?php jullybride_template_part('catalog/story-carousel'); ?>
    <?php jullybride_template_part('catalog/header'); ?>
    <?php jullybride_template_part('catalog/filters'); ?>
    <?php jullybride_template_part('catalog/product-list', ['query' => $catalog_query]); ?>
    <?php jullybride_template_part('catalog/seo-text'); ?>
    <?php jullybride_template_part('catalog/important-cta'); ?>
</main>

<?php
wp_reset_postdata();
get_footer();

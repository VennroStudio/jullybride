<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();

jullybride_template_part('components/story-overlays');

while (have_posts()) :
    the_post();

    global $product;

    if (!$product instanceof WC_Product) {
        continue;
    }
    ?>
    <main class="main-page content">
        <?php jullybride_template_part('components/story-carousel', ['section_class' => 'product-top']); ?>
        <?php jullybride_template_part('product/breadcrumbs'); ?>
        <?php jullybride_template_part('product/header', ['product' => $product]); ?>
        <?php jullybride_template_part('product/accessories', ['product' => $product]); ?>
        <?php jullybride_template_part('product/similar-products', ['product' => $product]); ?>
        <?php jullybride_template_part('product/blog-related'); ?>
        <?php jullybride_template_part('product/important-cta'); ?>
    </main>
    <?php
endwhile;

get_footer();

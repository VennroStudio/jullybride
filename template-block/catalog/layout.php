<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<?php jullybride_template_part('catalog/story-overlays'); ?>

<main class="main-page content products">
    <?php jullybride_template_part('catalog/story-carousel'); ?>
    <?php jullybride_template_part('catalog/header'); ?>
    <?php jullybride_template_part('catalog/filters'); ?>
    <?php jullybride_template_part('catalog/product-list'); ?>
    <?php jullybride_template_part('catalog/seo-text'); ?>
    <?php jullybride_template_part('catalog/important-cta'); ?>
</main>

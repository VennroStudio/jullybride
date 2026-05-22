<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<?php jullybride_template_part('components/story-overlays'); ?>

<main class="main-page content products">
    <?php jullybride_template_part('components/story-carousel', ['section_class' => 'product-top']); ?>
    <?php jullybride_template_part('catalog/header'); ?>
    <?php jullybride_template_part('catalog/filters'); ?>
    <?php jullybride_template_part('catalog/product-list'); ?>
    <?php jullybride_template_part('catalog/seo-text'); ?>
    <?php jullybride_template_part('catalog/important-cta'); ?>
</main>

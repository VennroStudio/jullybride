<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php jullybride_template_part('common/story-overlays'); ?>

<main class="main-page content products">
    <?php jullybride_template_part('common/story-carousel', ['disabled' => true]); ?>
    <?php jullybride_template_part('catalog/header'); ?>
    <?php jullybride_template_part('catalog/filters'); ?>
    <?php jullybride_template_part('catalog/product-list-legacy'); ?>
    <?php jullybride_template_part('catalog/seo-text'); ?>
    <?php jullybride_template_part('common/important-cta'); ?>
</main>

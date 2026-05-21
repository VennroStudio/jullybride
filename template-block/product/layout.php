<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<?php while (have_posts()) : the_post(); ?>
    <?php
    global $product;
    $product = wc_get_product(get_the_ID());
    if (!$product instanceof WC_Product) {
        continue;
    }
    ?>
    <main class="main-page content">
        <?php jullybride_template_part('product/breadcrumbs'); ?>
        <?php jullybride_template_part('product/header', ['product' => $product]); ?>
        <?php jullybride_template_part('product/accessories', ['product' => $product]); ?>
        <?php jullybride_template_part('product/similar-products', ['product' => $product]); ?>
        <?php jullybride_template_part('product/blog-related'); ?>
        <?php jullybride_template_part('common/important-cta'); ?>
    </main>
<?php endwhile; ?>

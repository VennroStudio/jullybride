<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php while (have_posts()) : the_post(); ?>
    <article class="jb-single-stock jb-stock-single">
        <?php
        jullybride_template_part('stock/single-header');
        jullybride_template_part('stock/single-content');
        jullybride_template_part('stock/related-products');
        ?>
    </article>
<?php endwhile; ?>

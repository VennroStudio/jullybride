<?php
if (!defined('ABSPATH')) {
    exit;
}

$promos = new WP_Query([
    'post_type' => 'promo',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'orderby' => 'date',
    'order' => 'DESC',
]);

if (!$promos->have_posts()) {
    wp_reset_postdata();
    return;
}
?>
<section class="jb-stock-promos">
    <div class="jb-stock-promos__grid">
        <?php $index = 0; ?>
        <?php while ($promos->have_posts()) : $promos->the_post(); ?>
            <?php
            jullybride_template_part('stock/promo-card', ['index' => $index]);
            $index++;
            ?>
        <?php endwhile; ?>
    </div>
</section>
<?php wp_reset_postdata(); ?>

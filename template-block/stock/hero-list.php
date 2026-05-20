<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once JULLYBRIDE_THEME_DIR . '/template-block/stock/helpers.php';

$promos = new WP_Query([
    'post_type' => 'promo',
    'post_status' => 'publish',
    'posts_per_page' => 13,
    'orderby' => 'date',
    'order' => 'DESC',
]);

if (!$promos->have_posts()) {
    wp_reset_postdata();
    return;
}
?>
<section class="jb-stock-promos">
    <div class="jb-stock-promos__slider owl-carousel owl-theme" data-jb-stock-promos>
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

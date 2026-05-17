<?php
if (!defined('ABSPATH')) {
    exit;
}

$query = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
]);

if (!$query->have_posts()) {
    return;
}
?>
<section class="jb-home-posts">
    <div class="container">
        <?php jullybride_template_part('common/section-title', ['subtitle' => 'Блог', 'title' => 'полезное для невест']); ?>
        <div class="jb-card-grid jb-card-grid--3">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php jullybride_template_part('common/article-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>


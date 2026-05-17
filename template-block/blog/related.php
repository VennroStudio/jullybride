<?php
if (!defined('ABSPATH')) {
    exit;
}

$category_ids = wp_get_post_categories(get_the_ID());
$related = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'post__not_in' => [get_the_ID()],
    'category__in' => $category_ids ?: [],
    'ignore_sticky_posts' => true,
]);

if (!$related->have_posts()) {
    wp_reset_postdata();
    return;
}
?>
<section class="jb-related-posts">
    <h2>Похожие статьи</h2>
    <div class="jb-blog-grid jb-blog-grid--related">
        <?php while ($related->have_posts()) : $related->the_post(); ?>
            <?php jullybride_template_part('blog/card'); ?>
        <?php endwhile; ?>
    </div>
</section>
<?php wp_reset_postdata(); ?>

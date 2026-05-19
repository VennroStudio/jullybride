<?php
if (!defined('ABSPATH')) {
    exit;
}

$category_ids = wp_get_post_categories(get_the_ID());
$related = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 6,
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
    <h2>Читайте также</h2>
    <div class="jb-related-posts__carousel" data-jb-related-carousel>
        <button class="jb-related-posts__arrow jb-related-posts__arrow--prev" type="button" data-jb-related-prev aria-label="Предыдущие статьи">&lsaquo;</button>
        <div class="jb-related-posts__grid" data-jb-related-track>
            <?php while ($related->have_posts()) : $related->the_post(); ?>
                <?php jullybride_template_part('blog/related-card'); ?>
            <?php endwhile; ?>
        </div>
        <button class="jb-related-posts__arrow jb-related-posts__arrow--next" type="button" data-jb-related-next aria-label="Следующие статьи">&rsaquo;</button>
    </div>
</section>
<?php
wp_reset_postdata();

$prev_post = get_previous_post();
$next_post = get_next_post();

if ($prev_post || $next_post) :
    ?>
    <nav class="jb-adjacent-posts" aria-label="Навигация по записям">
        <div class="jb-adjacent-posts__slot">
            <?php if ($prev_post) : ?>
                <a class="jb-adjacent-posts__item jb-adjacent-posts__item--prev" href="<?php echo esc_url(get_permalink($prev_post)); ?>">
                    <span class="jb-adjacent-posts__arrow" aria-hidden="true">&lsaquo;</span>
                    <span>
                        <span class="jb-adjacent-posts__label">Предыдущая запись</span>
                        <strong><?php echo esc_html(get_the_title($prev_post)); ?></strong>
                    </span>
                </a>
            <?php endif; ?>
        </div>
        <div class="jb-adjacent-posts__slot jb-adjacent-posts__slot--next">
            <?php if ($next_post) : ?>
                <a class="jb-adjacent-posts__item jb-adjacent-posts__item--next" href="<?php echo esc_url(get_permalink($next_post)); ?>">
                    <span>
                        <span class="jb-adjacent-posts__label">Следующая запись</span>
                        <strong><?php echo esc_html(get_the_title($next_post)); ?></strong>
                    </span>
                    <span class="jb-adjacent-posts__arrow" aria-hidden="true">&rsaquo;</span>
                </a>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>

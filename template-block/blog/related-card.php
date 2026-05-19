<?php
if (!defined('ABSPATH')) {
    exit;
}

$categories = get_the_category();
$category_name = $categories ? $categories[0]->name : __('Статья', 'jullybride');
?>
<article class="jb-related-card">
    <a class="jb-related-card__image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('jullybride-card'); ?>
        <?php else : ?>
            <span class="jb-related-card__placeholder"></span>
        <?php endif; ?>
        <span class="jb-related-card__badge"><?php echo esc_html($category_name); ?></span>
    </a>
    <h3 class="jb-related-card__title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
</article>

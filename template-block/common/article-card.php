<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<article class="jb-article-card">
    <a class="jb-article-card__image" href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium_large'); ?>
        <?php endif; ?>
    </a>
    <div class="jb-article-card__body">
        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?></p>
    </div>
</article>


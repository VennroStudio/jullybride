<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<article class="jb-blog-card">
    <a class="jb-blog-card__image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('jullybride-card'); ?>
        <?php else : ?>
            <span class="jb-blog-card__placeholder"></span>
        <?php endif; ?>
    </a>
    <div class="jb-blog-card__meta">
        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d.m.Y')); ?></time>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </div>
</article>

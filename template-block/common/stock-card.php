<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<article class="jb-stock-card">
    <a class="jb-stock-card__image" href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium_large'); ?>
        <?php endif; ?>
    </a>
    <div class="jb-stock-card__body">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
    </div>
</article>


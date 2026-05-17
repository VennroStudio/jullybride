<?php
if (!defined('ABSPATH')) {
    exit;
}

$index = (int) ($args['index'] ?? 0);
$class = 'jb-stock-promo-card jb-stock-promo-card--' . ($index + 1);
?>
<article class="<?php echo esc_attr($class); ?>">
    <a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail($index === 1 ? 'jullybride-wide' : 'jullybride-card'); ?>
        <?php else : ?>
            <span class="jb-stock-promo-card__placeholder"></span>
        <?php endif; ?>
        <span class="jb-stock-promo-card__overlay">
            <strong><?php the_title(); ?></strong>
            <?php if (has_excerpt()) : ?>
                <small><?php echo esc_html(wp_trim_words(get_the_excerpt(), 10)); ?></small>
            <?php endif; ?>
        </span>
    </a>
</article>

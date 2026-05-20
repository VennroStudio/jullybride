<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once JULLYBRIDE_THEME_DIR . '/template-block/stock/helpers.php';

$index = (int) ($args['index'] ?? 0);
$class = 'jb-stock-promo-card jb-stock-promo-card--' . ($index + 1);
$image = jullybride_stock_featured_image_url(get_the_ID(), $index === 1 ? 'jullybride-wide' : 'jullybride-card');
$is_clickable = (bool) jullybride_stock_field('sale_clickable', get_the_ID(), true);
$tag = $is_clickable ? 'a' : 'div';
$title = (string) jullybride_stock_field('sale_header', get_the_ID(), get_the_title());
$subtitle = (string) jullybride_stock_field('sale_header_2', get_the_ID(), get_the_excerpt());
?>
<article class="<?php echo esc_attr($class); ?>">
    <<?php echo $tag; ?> class="jb-stock-promo-card__link" <?php echo $is_clickable ? 'href="' . esc_url(get_permalink()) . '"' : ''; ?> aria-label="<?php echo esc_attr(get_the_title()); ?>">
        <?php if ($image) : ?>
            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="<?php echo $index < 3 ? 'eager' : 'lazy'; ?>">
        <?php else : ?>
            <span class="jb-stock-promo-card__placeholder"></span>
        <?php endif; ?>
        <span class="jb-stock-promo-card__overlay">
            <strong><?php echo esc_html($title ?: get_the_title()); ?></strong>
            <?php if ($subtitle) : ?>
                <small><?php echo esc_html(wp_trim_words($subtitle, 12)); ?></small>
            <?php endif; ?>
        </span>
    </<?php echo $tag; ?>>
</article>

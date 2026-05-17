<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="jb-single-stock__content jb-stock-single__content">
    <?php if (has_post_thumbnail()) : ?>
        <figure class="jb-stock-single__image"><?php the_post_thumbnail('jullybride-wide'); ?></figure>
    <?php endif; ?>
    <?php echo jullybride_render_clean_post_content(); ?>
    <p class="jb-stock-single__cta">
        <a class="theme-button button-main" href="<?php echo esc_url(jullybride_option('booking_url', '#booking')); ?>">
            <?php echo esc_html(jullybride_option('booking_text', 'Записаться на примерку')); ?>
        </a>
    </p>
</div>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = jullybride_option('footer_cta_title');
$text = jullybride_option('footer_cta_text');
$button = jullybride_option('footer_cta_button_text', 'Записаться');
$url = jullybride_option('footer_cta_button_url', '#booking');

if (!$title && !$text) {
    return;
}
?>
<section class="jb-footer-cta">
    <?php if ($title) : ?>
        <h2><?php echo esc_html($title); ?></h2>
    <?php endif; ?>
    <?php if ($text) : ?>
        <p><?php echo esc_html($text); ?></p>
    <?php endif; ?>
    <a class="jb-button" href="<?php echo esc_url($url); ?>"><?php echo esc_html($button); ?></a>
</section>


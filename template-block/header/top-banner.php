<?php
if (!defined('ABSPATH')) {
    exit;
}

$text = jullybride_option('top_banner_text');
$url = jullybride_option('top_banner_url');
if (!$text) {
    return;
}
?>
<div class="jb-top-banner">
    <?php if ($url) : ?>
        <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($text); ?></a>
    <?php else : ?>
        <span><?php echo esc_html($text); ?></span>
    <?php endif; ?>
</div>


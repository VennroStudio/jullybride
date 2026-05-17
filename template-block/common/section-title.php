<?php
if (!defined('ABSPATH')) {
    exit;
}

$subtitle = $args['subtitle'] ?? '';
$title = $args['title'] ?? get_the_title();
?>
<header class="jb-section-title">
    <?php if ($subtitle) : ?>
        <span><?php echo esc_html($subtitle); ?></span>
    <?php endif; ?>
    <h2><?php echo esc_html($title); ?></h2>
</header>


<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = trim((string) ($args['title'] ?? ''));

if ($title === '') {
    $title = get_the_title();
}
?>
<header class="jb-stock-header">
    <h1><?php echo esc_html($title); ?></h1>
</header>

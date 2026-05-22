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
    <h1 class="font-title"><?php echo esc_html($title); ?></h1>
    <span class="jb-stock-header__note" aria-hidden="true"></span>
</header>

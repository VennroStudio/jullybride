<?php
if (!defined('ABSPATH')) {
    exit;
}

$title = trim((string) ($args['title'] ?? ''));

if ($title === '') {
    $title = get_the_title();
}
?>
<header class="jb-stock-header jb-contacts-header">
    <h1 class="jb-display-title font-title"><?php echo esc_html($title); ?></h1>
    <span class="jb-contacts-header__note" aria-hidden="true"></span>
</header>

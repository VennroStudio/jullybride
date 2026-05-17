<?php
if (!defined('ABSPATH')) {
    exit;
}

$updated = get_the_modified_date('d.m.Y');
?>
<header class="jb-article-header">
    <?php if ($updated) : ?>
        <div class="jb-article-header__date">Последние изменения: <?php echo esc_html($updated); ?></div>
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
</header>

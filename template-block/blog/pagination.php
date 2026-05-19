<?php
if (!defined('ABSPATH')) {
    exit;
}

global $wp_query;

$links = paginate_links([
    'current' => max(1, (int) get_query_var('paged')),
    'total' => max(1, (int) $wp_query->max_num_pages),
    'mid_size' => 2,
    'end_size' => 1,
    'prev_text' => '<span aria-hidden="true">&lsaquo;</span>',
    'next_text' => '<span aria-hidden="true">&rsaquo;</span>',
    'type' => 'array',
]);

if (empty($links)) {
    return;
}
?>
<nav class="jb-pagination jb-blog-pagination" aria-label="Пагинация записей">
    <ul class="jb-pagination__list">
        <?php foreach ($links as $link) : ?>
            <li><?php echo wp_kses_post($link); ?></li>
        <?php endforeach; ?>
    </ul>
</nav>

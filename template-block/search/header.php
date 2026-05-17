<?php
if (!defined('ABSPATH')) {
    exit;
}

$query = get_search_query();
?>
<header class="jb-search-header">
    <h1>
        <?php if ($query !== '') : ?>
            <?php echo esc_html(sprintf('Результаты поиска «%s»', $query)); ?>
        <?php else : ?>
            Поиск
        <?php endif; ?>
    </h1>
</header>

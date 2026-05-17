<?php
if (!defined('ABSPATH')) {
    exit;
}

$columns = jullybride_footer_columns();
?>
<div class="jb-footer-menu" aria-label="Меню в футере">
    <?php foreach ($columns as $column) : ?>
        <nav class="jb-footer-menu__column" aria-label="<?php echo esc_attr($column['title']); ?>">
            <h2><?php echo esc_html($column['title']); ?></h2>
            <ul class="jb-footer-menu__list">
                <?php foreach ($column['items'] as $item) : ?>
                    <li><a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php endforeach; ?>
</div>

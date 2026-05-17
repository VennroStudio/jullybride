<?php
if (!defined('ABSPATH')) {
    exit;
}

$categories = get_categories([
    'hide_empty' => true,
    'orderby' => 'name',
    'order' => 'ASC',
]);

if (!$categories) {
    return;
}
?>
<details class="jb-blog-categories">
    <summary>Рубрики</summary>
    <div class="jb-blog-categories__list">
        <?php foreach ($categories as $category) : ?>
            <a href="<?php echo esc_url(get_category_link($category)); ?>">
                <?php echo esc_html($category->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
</details>

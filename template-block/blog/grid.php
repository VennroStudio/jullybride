<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php if (have_posts()) : ?>
    <div class="jb-blog-grid">
        <?php while (have_posts()) : the_post(); ?>
            <?php jullybride_template_part('blog/card'); ?>
        <?php endwhile; ?>
    </div>
<?php else : ?>
    <div class="jb-empty">Пока нет опубликованных материалов.</div>
<?php endif; ?>

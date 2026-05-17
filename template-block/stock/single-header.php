<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<header class="jb-stock-single__header">
    <h1><?php the_title(); ?></h1>
    <?php if (has_excerpt()) : ?>
        <p><?php echo esc_html(get_the_excerpt()); ?></p>
    <?php endif; ?>
</header>

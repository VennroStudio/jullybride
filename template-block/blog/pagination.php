<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<nav class="jb-pagination jb-blog-pagination">
    <?php
    the_posts_pagination([
        'mid_size' => 2,
        'prev_text' => 'Назад',
        'next_text' => 'Дальше',
    ]);
    ?>
</nav>

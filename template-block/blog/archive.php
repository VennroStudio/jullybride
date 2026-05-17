<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="jb-blog-archive">
    <?php
    jullybride_template_part('blog/header');
    jullybride_template_part('blog/categories');
    jullybride_template_part('blog/grid');
    jullybride_template_part('blog/pagination');
    ?>
</div>

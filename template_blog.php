<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<main class="jb-main jb-editorial-page jb-blog">
    <div class="container">
        <?php jullybride_breadcrumbs(); ?>
        <?php is_singular('post') ? jullybride_template_part('blog/single') : jullybride_template_part('blog/archive'); ?>
    </div>
</main>

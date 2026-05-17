<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<main class="jb-main jb-editorial-page jb-stock">
    <div class="container">
        <?php jullybride_breadcrumbs(); ?>
        <?php is_singular('promo') ? jullybride_template_part('stock/single') : jullybride_template_part('stock/archive'); ?>
    </div>
</main>

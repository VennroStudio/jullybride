<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="jb-stock-archive">
    <?php
    jullybride_template_part('stock/header', [
        'title' => $args['title'] ?? '',
    ]);
    jullybride_template_part('stock/hero-list');
    jullybride_template_part('stock/sale-products');
    ?>
</div>

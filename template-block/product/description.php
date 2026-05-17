<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="jb-product-description">
    <h2>Описание</h2>
    <?php echo jullybride_render_clean_post_content(); ?>
    <?php woocommerce_template_single_meta(); ?>
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="jb-page-content">
    <?php
    $acf_text = function_exists('get_sub_field') ? get_sub_field('text') : '';
    if ($acf_text) {
        echo wp_kses_post($acf_text);
        return;
    }

    while (have_posts()) {
        the_post();
        echo jullybride_render_clean_post_content();
    }
    ?>
</div>

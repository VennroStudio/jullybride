<?php
get_header();

if (function_exists('is_product_category') && (is_product_category() || is_shop())) {
    jullybride_template_part('catalog/layout');
} else {
    ?>
    <main class="jb-main jb-editorial-page jb-blog">
        <div class="container">
            <?php jullybride_breadcrumbs(); ?>
            <?php jullybride_template_part('blog/archive'); ?>
        </div>
    </main>
    <?php
}

get_footer();

<?php
get_header();

if (get_post_type() === 'post') {
    ?>
    <main class="jb-main jb-editorial-page jb-blog">
        <div class="container">
            <?php jullybride_template_part('components/breadcrumbs'); ?>
            <?php jullybride_template_part('blog/single'); ?>
        </div>
    </main>
    <?php
} else {
    ?>
    <main class="jb-main jb-page">
        <div class="container">
            <?php jullybride_template_part('components/breadcrumbs'); ?>
            <?php jullybride_template_part('page/hero'); ?>
            <?php jullybride_template_part('page/content'); ?>
        </div>
    </main>
    <?php
}

get_footer();

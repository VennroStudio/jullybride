<?php
get_header();
?>
<main class="jb-main jb-page">
    <div class="container">
        <?php jullybride_template_part('components/breadcrumbs'); ?>
        <?php jullybride_template_part('page/hero'); ?>

        <?php
        if (!jullybride_render_flexible('page_blocks', 'page')) {
            jullybride_template_part('page/content');
        }
        ?>
    </div>
</main>

<?php
get_footer();

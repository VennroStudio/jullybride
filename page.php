<?php
get_header();

if (is_page('c')) {
    jullybride_template_part('catalog/layout');
} elseif (is_page('pinkcamp')) {
    jullybride_template_part('camp/layout');
} elseif (is_page(['franshiza', 'franshiza-2'])) {
    jullybride_template_part('franchise/layout');
} else {
    $is_service_page = is_page(['cart', 'checkout', 'wishlist']);
    ?>
    <main class="jb-main jb-page<?php echo $is_service_page ? ' jb-service-page' : ''; ?>">
        <div class="container">
            <?php jullybride_breadcrumbs(); ?>
            <?php
            if ($is_service_page) {
                jullybride_template_part('page/service');
            } else {
                jullybride_template_part('page/hero');
            }

            if (!$is_service_page && !jullybride_render_flexible('page_blocks', 'page')) {
                jullybride_template_part('page/content');
            }
            ?>
        </div>
        <?php
        if ($is_service_page) {
            jullybride_template_part('common/important-cta');
        }
        ?>
    </main>
    <?php
}

get_footer();

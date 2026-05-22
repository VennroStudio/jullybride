<?php
/**
 * Template Name: JullyBride: Акции
 * Template Post Type: page
 */

get_header();

jullybride_template_part('components/story-overlays');
?>
<main class="jb-main jb-editorial-page jb-stock jb-stock-archive jb-striped-arch">
    <?php jullybride_template_part('components/story-carousel', ['section_class' => 'jb-story-carousel-section']); ?>

    <?php
    while (have_posts()) {
        the_post();
        ?>
        <div class="container">
            <?php
            jullybride_template_part('components/breadcrumbs');
            jullybride_template_part('stock/header', [
                'title' => get_the_title(),
            ]);
            jullybride_template_part('stock/hero-list');
            jullybride_template_part('stock/sale-products');
            ?>
        </div>
        <?php
        jullybride_template_part('stock/important-cta');
    }
    ?>
</main>
<?php
get_footer();

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

    <div class="container">
        <?php
        while (have_posts()) {
            the_post();

            jullybride_breadcrumbs();
            jullybride_template_part('stock/header', [
                'title' => get_the_title(),
            ]);
            jullybride_template_part('stock/hero-list');
            jullybride_template_part('stock/sale-products');
        }
        ?>
    </div>
</main>
<?php
get_footer();

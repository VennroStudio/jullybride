<?php
/**
 * Template Name: JullyBride: Акции
 * Template Post Type: page
 */

get_header();
?>
<main class="jb-main jb-editorial-page jb-stock jb-stock-archive jb-striped-arch">
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

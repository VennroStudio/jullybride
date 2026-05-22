<?php
/**
 * Template Name: Акции
 * Template Post Type: page
 */

get_header();
?>
<main class="jb-main jb-editorial-page jb-stock">
    <div class="container">
        <?php
        while (have_posts()) {
            the_post();

            jullybride_breadcrumbs();
            jullybride_template_part('stock/archive', [
                'title' => get_the_title(),
            ]);
        }
        ?>
    </div>
</main>
<?php
get_footer();

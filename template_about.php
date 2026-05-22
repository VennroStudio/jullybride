<?php
/**
 * Template Name: JullyBride: О компании
 */

get_header();
?>
<main class="jb-main jb-page jb-about-page">
    <div class="container">
        <?php
        jullybride_template_part('components/breadcrumbs');
        jullybride_template_part('about/video');
        jullybride_template_part('about/features');
        jullybride_template_part('about/gallery');
        jullybride_template_part('about/fitting');
        ?>
    </div>
</main>
<?php
get_footer();

<?php
/**
 * Template Name: JullyBride: Контакты
 */

get_header();

jullybride_template_part('components/story-overlays');
?>
<main class="jb-main jb-editorial-page">
    <?php jullybride_template_part('components/story-carousel', ['section_class' => 'jb-story-carousel-section']); ?>
    <div class="container">
        <div class="jb-contacts-page">
            <?php
            jullybride_template_part('components/breadcrumbs');
            jullybride_template_part('contacts/header', ['title' => get_the_title()]);
            ?>
        </div>
    </div>
    <?php jullybride_template_part('contacts/contact-tabs'); ?>
    <?php jullybride_template_part('components/rest-ribbon'); ?>
    <?php jullybride_template_part('contacts/gallery'); ?>
    <?php jullybride_template_part('contacts/important-cta'); ?>
</main>
<?php
get_footer();

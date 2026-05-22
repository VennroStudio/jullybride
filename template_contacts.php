<?php
/**
 * Template Name: JullyBride: Контакты
 */

get_header();
?>
<main class="jb-main jb-page">
    <div class="container">
        <div class="jb-contacts-page">
            <?php
            jullybride_breadcrumbs();
            jullybride_template_part('contacts/header', ['title' => get_the_title()]);
            jullybride_template_part('contacts/contact-tabs');
            jullybride_template_part('contacts/company-details');
            ?>
        </div>
    </div>
</main>
<?php
get_footer();

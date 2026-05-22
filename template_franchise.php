<?php
/*
Template Name: JullyBride Франшиза
*/
if (!defined('ABSPATH')) {
    exit;
}

get_header();

jullybride_template_part('franchise/helpers');
?>
<main class="franchise-page">
    <?php
    jullybride_template_part('franchise/nav');
    jullybride_template_part('franchise/hero');
    jullybride_template_part('franchise/ticker');
    jullybride_template_part('franchise/business-stack');
    jullybride_template_part('franchise/visibility');
    jullybride_template_part('franchise/social-gallery');
    jullybride_template_part('franchise/brand-now');
    jullybride_template_part('franchise/image-carousel');
    jullybride_template_part('franchise/conditions');
    jullybride_template_part('franchise/steps');
    jullybride_template_part('franchise/team');
    jullybride_template_part('franchise/family');
    jullybride_template_part('franchise/history');
    jullybride_template_part('franchise/merch');
    jullybride_template_part('franchise/guarantee');
    ?>
    <a class="franchise-floating-stamp" href="#franchise-feedback-modal" aria-label="Узнать условия франшизы" data-jb-franchise-feedback>
        <span>узнать условия франшизы</span>
    </a>
    <?php jullybride_template_part('franchise/video-modal'); ?>
    <?php jullybride_template_part('franchise/feedback-modal'); ?>
</main>
<?php
get_footer();

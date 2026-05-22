<?php
/*
Template Name: JullyBride: Главная
*/
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="main-page content">
    <?php
    jullybride_template_part('components/story-overlays');
    jullybride_template_part('home/hero');
    jullybride_template_part('home/dress-tabs');
    jullybride_template_part('home/video-tour');
    jullybride_template_part('home/booking-calendar');
    jullybride_template_part('home/new-products');
    jullybride_template_part('home/wanted-stay');
    jullybride_template_part('home/couture');
    jullybride_template_part('home/accessories-carousel');
    jullybride_template_part('home/booking-strip');
    jullybride_template_part('home/roulette');
    jullybride_template_part('home/bestsellers');
    jullybride_template_part('home/gallery-grid');
    jullybride_template_part('home/atmosphere');
    jullybride_template_part('home/evening-products');
    jullybride_template_part('home/reviews');
    jullybride_template_part('home/important-cta');
    ?>
</main>
<?php
get_footer();

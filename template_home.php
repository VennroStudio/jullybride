<?php
if (!defined('ABSPATH')) {
    exit;
}
if (function_exists('have_rows') && !have_rows('home_blocks') && (have_rows('banners') || have_rows('carusel-added-owl'))) {
    ?>
    <main class="main-page content">
        <?php
        jullybride_template_part('home/story-overlays');
        jullybride_template_part('home/hero-slider');
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
    return;
}
?>
<main class="jb-main jb-home">
    <?php
    if (!jullybride_render_flexible('home_blocks', 'home')) {
        jullybride_template_part('home/hero');
        jullybride_template_part('home/catalog-tabs');
        jullybride_template_part('home/about');
        jullybride_template_part('home/cta');
        jullybride_template_part('home/latest-posts');
    }
    ?>
</main>

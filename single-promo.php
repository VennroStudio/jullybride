<?php
get_header();
?>
<main class="jb-main jb-editorial-page jb-stock">
    <div class="container">
        <?php jullybride_breadcrumbs(); ?>

        <?php while (have_posts()) : the_post(); ?>
            <article class="jb-single-stock jb-stock-single">
                <?php
                jullybride_template_part('stock-single/hero');
                jullybride_template_part('stock-single/marquee', [
                    'text' => (string) jullybride_stock_field('sale_running_line', get_the_ID(), 'несколько слов'),
                ]);
                jullybride_template_part('stock-single/video-gallery');
                jullybride_template_part('stock-single/sale-products');
                jullybride_template_part('stock-single/gift');
                ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();

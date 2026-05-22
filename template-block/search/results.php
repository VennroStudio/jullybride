<?php
if (!defined('ABSPATH')) {
    exit;
}

$paged = max(1, absint(get_query_var('paged')), absint(get_query_var('page')));
$search_query = get_search_query();
$products = new WP_Query([
    'post_type' => 'product',
    'post_status' => 'publish',
    's' => $search_query,
    'posts_per_page' => 15,
    'paged' => $paged,
]);
?>
<section class="jb-search-results">
    <?php if ($products->have_posts()) : ?>
        <div class="row products-list jb-search-products">
            <?php $index = 0; ?>
            <?php while ($products->have_posts()) : $products->the_post(); ?>
                <?php
                $product = wc_get_product(get_the_ID());
                if ($product) {
                    jullybride_template_part('components/product-card', [
                        'product' => $product,
                        'index' => $index,
                        'class' => 'col-lg-4 col-md-4 col-6 products-list-item',
                    ]);
                    $index++;
                }
                ?>
            <?php endwhile; ?>
        </div>
        <nav class="jb-pagination">
            <?php echo paginate_links(['total' => $products->max_num_pages]); ?>
        </nav>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <?php wp_reset_postdata(); ?>
        <?php if (!have_posts()) : ?>
            <?php jullybride_template_part('search/empty'); ?>
            <?php return; ?>
        <?php endif; ?>
        <div class="jb-blog-grid jb-search-posts">
            <?php $index = 0; ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php
                $product = get_post_type() === 'product' ? wc_get_product(get_the_ID()) : null;

                if ($product instanceof WC_Product) {
                    jullybride_template_part('components/product-card', [
                        'product' => $product,
                        'index' => $index,
                        'class' => 'col-lg-4 col-md-4 col-6 products-list-item',
                    ]);
                    $index++;
                } else {
                    jullybride_template_part('blog/card');
                }
                ?>
            <?php endwhile; ?>
        </div>
        <nav class="jb-pagination"><?php the_posts_pagination(); ?></nav>
    <?php endif; ?>
</section>

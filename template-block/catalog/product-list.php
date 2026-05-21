<?php
if (!defined('ABSPATH')) {
    exit;
}

$catalog_query = $args['query'] ?? null;
$owns_query = false;

if (!$catalog_query instanceof WP_Query) {
    $catalog_query = new WP_Query(jullybride_catalog_query_args());
    $owns_query = true;
}
?>
<?php if ($catalog_query->have_posts()) : ?>
    <section class="products-list-box position-relative">
        <div class="container">
            <div class="row products-list" id="products-row">
                <?php $index = 0; ?>
                <?php while ($catalog_query->have_posts()) : ?>
                    <?php
                    $catalog_query->the_post();
                    $index++;
                    $product = wc_get_product(get_the_ID());
                    jullybride_template_part('common/product-card-legacy', [
                        'product' => $product,
                        'index' => $index,
                    ]);
                    ?>

                    <?php if ($index === 4) : ?>
                        <?php jullybride_template_part('catalog/lucky-card'); ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>

        <?php jullybride_template_part('catalog/load-more', ['query' => $catalog_query]); ?>
        <?php jullybride_template_part('catalog/pagination', ['query' => $catalog_query]); ?>
    </section>
<?php else : ?>
    <?php jullybride_template_part('catalog/empty'); ?>
<?php endif; ?>
<?php
if ($owns_query) {
    wp_reset_postdata();
}
?>

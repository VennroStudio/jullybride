<?php
if (!defined('ABSPATH')) {
    exit;
}

$query = new WP_Query(jullybride_catalog_query_args());
?>
<section class="jb-catalog-grid">
    <div class="container">
        <?php if ($query->have_posts()) : ?>
            <div class="jb-card-grid jb-card-grid--products">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php jullybride_template_part('common/product-card', ['product' => wc_get_product(get_the_ID())]); ?>
                <?php endwhile; ?>
            </div>
            <nav class="jb-pagination">
                <?php
                echo paginate_links([
                    'total' => $query->max_num_pages,
                    'current' => max(1, absint(get_query_var('paged'))),
                ]);
                ?>
            </nav>
        <?php else : ?>
            <p class="jb-empty">Товары не найдены.</p>
        <?php endif; wp_reset_postdata(); ?>
    </div>
</section>


<?php
if (!defined('ABSPATH')) {
    exit;
}

$catalog_query = new WP_Query(jullybride_catalog_query_args());
$GLOBALS['wp_query'] = $catalog_query;
?>
<?php if ($catalog_query->have_posts()) : ?>
    <section class="products-list-box position-relative">
        <div class="container">
            <div class="row products-list" id="products-row">
                <?php $i = 0; ?>
                <?php while ($catalog_query->have_posts()) : $catalog_query->the_post(); ?>
                    <?php
                    $i++;
                    $product = wc_get_product(get_the_ID());
                    jullybride_template_part('common/product-card-legacy', ['product' => $product, 'index' => $i]);
                    ?>

                    <?php if ($i === 4) : ?>
                        <div class="col-md-4 col-6 products-list-item products-list-item_custom">
                            <div class="position-relative">
                                <span class="d-block font-cursive products-list-item1 text-center">хочешь испытать удачу?</span>
                                <img src="<?php echo esc_url(jullybride_asset_uri('images/korset-1.png')); ?>" class="products-list-item2" alt="">
                                <span class="d-block products-list-item3 text-center">крути колесо и выиграй<br>вечернее платье!</span>
                                <a href="" class="theme-button button-main d-block">Играть сейчас!</a>
                                <span class="d-none d-md-block products-list-item4 text-center">больше интересного</span>
                                <span class="d-none d-md-block font-cursive products-list-item5 text-center">в нашем телеграм!</span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>

        <?php jullybride_template_part('catalog/load-more', ['query' => $catalog_query]); ?>
        <?php jullybride_template_part('catalog/pagination', ['query' => $catalog_query]); ?>
    </section>
<?php else : ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p><b>Нет соответствующих товаров!</b></p><br><br>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

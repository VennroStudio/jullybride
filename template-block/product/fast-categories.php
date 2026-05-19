<?php
if (!defined('ABSPATH')) {
    exit;
}

$product = $args['product'] ?? wc_get_product(get_the_ID());
if (!$product instanceof WC_Product) {
    return;
}

$product_id = $product->get_id();
$category_slug = 'wedding';
$main_category = function_exists('jullybride_get_main_product_category') ? jullybride_get_main_product_category($product_id) : null;

if ($main_category instanceof WP_Term) {
    $category_slug = $main_category->slug;
} else {
    $terms = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'slugs']);
    if ($terms) {
        $category_slug = reset($terms);
    }
}

$base_url = home_url('/c/' . $category_slug . '/');

$definitions = function_exists('jullybride_catalog_filter_definitions') ? jullybride_catalog_filter_definitions() : [];
$definitions = array_filter($definitions, static function (array $definition): bool {
    return !in_array($definition['param'] ?? '', ['pa_razmer'], true);
});

$get_terms = static function (array $taxonomies) use ($product_id): array {
    $items = [];

    foreach ($taxonomies as $taxonomy) {
        if (!taxonomy_exists($taxonomy)) {
            continue;
        }

        $terms = wc_get_product_terms($product_id, $taxonomy);
        if (!$terms || is_wp_error($terms)) {
            continue;
        }

        foreach ($terms as $term) {
            if (!$term instanceof WP_Term) {
                continue;
            }

            $items[sanitize_title($term->name)] = $term;
        }
    }

    return array_values($items);
};
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="fast-categories">
                <?php foreach ($definitions as $definition) : ?>
                    <?php
                    $terms = $get_terms((array) ($definition['taxonomies'] ?? []));
                    if (!$terms) {
                        continue;
                    }
                    $query_param = (string) ($definition['param'] ?? '');
                    ?>
                    <div>
                        <span><?php echo esc_html($definition['label'] ?? ''); ?>:</span>
                        <?php foreach ($terms as $term) : ?>
                            <?php $url = add_query_arg(['_f' => '1', $query_param => $term->slug], $base_url); ?>
                            <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($term->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

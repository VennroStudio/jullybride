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
$terms = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'slugs']);
if ($terms) {
    $category_slug = reset($terms);
}
$base_url = home_url('/c/' . $category_slug . '/');

$groups = [
    'pa_czvet' => ['label' => 'Цвет', 'query' => '_color'],
    'silhouette' => ['label' => 'Силуэт', 'query' => '_silhouette'],
    'style' => ['label' => 'Стиль', 'query' => '_style'],
];
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="fast-categories">
                <?php foreach ($groups as $taxonomy => $data) : ?>
                    <?php
                    $terms = get_the_terms($product_id, $taxonomy);
                    if (!$terms || is_wp_error($terms)) {
                        continue;
                    }
                    ?>
                    <div>
                        <span><?php echo esc_html($data['label']); ?>:</span>
                        <?php foreach ($terms as $term) : ?>
                            <?php $url = add_query_arg(['_f' => '1', $data['query'] => $term->slug], $base_url); ?>
                            <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($term->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

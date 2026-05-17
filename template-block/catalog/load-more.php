<?php
if (!defined('ABSPATH')) {
    exit;
}

$query = $args['query'] ?? null;
if (!$query instanceof WP_Query || $query->max_num_pages <= 1) {
    return;
}
?>
<div class="container products-list_more">
    <div class="row">
        <div class="col-12">
            <a href="#" class="theme-button button-main d-block load-more-products" data-page="2" data-max-pages="<?php echo esc_attr($query->max_num_pages); ?>">Показать больше</a>
        </div>
    </div>
</div>


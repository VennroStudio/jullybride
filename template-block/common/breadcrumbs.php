<?php
if (!defined('ABSPATH')) {
    exit;
}

if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<nav class="jb-breadcrumbs">', '</nav>');
    return;
}

if (function_exists('woocommerce_breadcrumb') && (is_woocommerce() || is_product_category())) {
    woocommerce_breadcrumb(['wrap_before' => '<nav class="jb-breadcrumbs">', 'wrap_after' => '</nav>']);
}


<?php
get_header();

if (is_post_type_archive('promo') || get_post_type() === 'promo') {
    get_template_part('template_stock');
} elseif (function_exists('is_product_category') && (is_product_category() || is_shop())) {
    get_template_part('template_catalog');
} else {
    get_template_part('template_blog');
}

get_footer();


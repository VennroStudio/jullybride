<?php
get_header();

if (get_post_type() === 'promo') {
    get_template_part('template_stock');
} elseif (get_post_type() === 'post') {
    get_template_part('template_blog');
} else {
    get_template_part('template_page');
}

get_footer();


<?php
get_header();

if (is_page('c')) {
    get_template_part('template_catalog');
} elseif (is_page('promo')) {
    get_template_part('template_stock');
} else {
    get_template_part('template_page');
}

get_footer();

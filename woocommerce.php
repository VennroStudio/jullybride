<?php
get_header();
if (is_product()) {
    get_template_part('template_product');
} else {
    get_template_part('template_catalog');
}
get_footer();


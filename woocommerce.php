<?php
get_header();
if (is_product()) {
    jullybride_template_part('product/layout');
} else {
    jullybride_template_part('catalog/layout');
}
get_footer();

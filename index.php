<?php
get_header();
if (have_posts()) {
    echo '<main class="jb-main jb-main--index">';
    while (have_posts()) {
        the_post();
        get_template_part('template_page');
    }
    echo '</main>';
}
get_footer();


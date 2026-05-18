<?php
get_header();
if (have_posts()) {
    echo '<main class="jb-main jb-main--index">';
    while (have_posts()) {
        the_post();
        jullybride_template_part('page/hero');
        jullybride_template_part('page/content');
    }
    echo '</main>';
}
get_footer();

<?php
get_header();
?>
<main class="jb-main jb-editorial-page jb-search-page">
    <div class="container">
        <?php jullybride_template_part('components/breadcrumbs'); ?>
        <?php jullybride_template_part('search/header'); ?>
        <?php jullybride_template_part('search/form'); ?>
        <?php get_search_query() !== '' ? jullybride_template_part('search/results') : jullybride_template_part('search/empty'); ?>
    </div>
</main>
<?php
get_footer();

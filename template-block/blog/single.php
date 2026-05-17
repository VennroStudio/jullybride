<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php while (have_posts()) : the_post(); ?>
    <article class="jb-single-article jb-article">
        <?php
        jullybride_template_part('blog/single-header');
        jullybride_template_part('blog/single-content');
        jullybride_template_part('blog/related');
        ?>
    </article>
<?php endwhile; ?>

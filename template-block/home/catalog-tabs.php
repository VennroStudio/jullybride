<?php
if (!defined('ABSPATH')) {
    exit;
}

$terms = get_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
    'parent' => 0,
    'slug' => ['wedding', 'evening', 'shoes', 'veils', 'jewelry', 'outerwear', 'morning', 'pink-merch'],
]);
?>
<section class="jb-home-catalog">
    <div class="container">
        <?php jullybride_template_part('common/section-title', ['subtitle' => 'Выбери свое идеальное', 'title' => 'свадебное платье']); ?>
        <div class="jb-home-catalog__tabs">
            <?php foreach ($terms as $term) : ?>
                <a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>


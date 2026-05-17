<?php
if (!defined('ABSPATH') || !function_exists('have_rows')) {
    return;
}

$context = jullybride_home_story_context();
$post_id = $args['post_id'] ?? $context['post_id'];
$field = $args['field'] ?? $context['field'];
$disabled = !empty($args['disabled']) ? ' disabled' : '';

if (!have_rows($field, $post_id)) {
    return;
}
?>
<section class="product-top">
    <div class="carusel-added container">
        <div class="row">
            <div class="col-1 d-md-flex d-none align-items-center">
                <a href="javascript:void(0)" class="arrow-prev carusel-nav<?php echo esc_attr($disabled); ?>" id="carusel-added-prev"></a>
            </div>
            <div class="col-12 col-md-10">
                <ul class="carusel-added-owl owl-carousel owl-theme" id="carusel-added-owl">
                    <?php while (have_rows($field, $post_id)) : the_row(); ?>
                        <?php
                        $id = 'open-carusel-added-story_' . get_row_index();
                        $img = get_sub_field('img');
                        $title = get_sub_field('title');
                        ?>
                        <li id="<?php echo esc_attr($id); ?>">
                            <a href="javascript:void(0)">
                                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>">
                                <span><?php echo esc_html($title); ?></span>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="col-1 d-md-flex d-none justify-content-end align-items-center">
                <a href="javascript:void(0)" class="arrow-next carusel-nav<?php echo esc_attr($disabled); ?>" id="carusel-added-next"></a>
            </div>
        </div>
    </div>
</section>


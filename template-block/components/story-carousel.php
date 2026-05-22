<?php
if (!defined('ABSPATH')) {
    exit;
}

$args = wp_parse_args($args ?? [], [
    'source' => function_exists('jullybride_stories_source') ? jullybride_stories_source() : 'option',
    'field_name' => function_exists('jullybride_stories_field_name') ? jullybride_stories_field_name() : 'carusel-added-owl',
    'section_class' => '',
    'thumb_size' => 'thumbnail',
]);

$source = $args['source'];
$field_name = (string) $args['field_name'];
$section_class = trim((string) $args['section_class']);
$thumb_size = (string) $args['thumb_size'];

if ($source === 'option' && function_exists('jullybride_prime_acf_option_field')) {
    jullybride_prime_acf_option_field($field_name);
    jullybride_prime_acf_option_missing_subfields($field_name, ['link']);
    jullybride_prime_acf_option_media($field_name, ['img', 'foto', 'video']);
}

if (!function_exists('have_rows') || !have_rows($field_name, $source)) {
    return;
}
?>
<?php if ($section_class !== '') : ?>
    <section class="<?php echo esc_attr($section_class); ?>">
<?php endif; ?>
    <div class="carusel-added container">
        <div class="row">
            <div class="col-1 d-md-flex d-none align-items-center">
                <a href="javascript:void(0)" class="arrow-prev carusel-nav disabled" id="carusel-added-prev"></a>
            </div>
            <div class="col-12 col-md-10">
                <ul class="carusel-added-owl owl-carousel owl-theme" id="carusel-added-owl">
                    <?php
                    while (have_rows($field_name, $source)) :
                        the_row();
                        $story_id = 'open-carusel-added-story_' . get_row_index();
                        $image = get_sub_field('img', false);
                        $image_url = function_exists('jullybride_media_url') ? jullybride_media_url($image, $thumb_size) : '';
                        $title = (string) get_sub_field('title', false);
                        ?>
                        <li id="<?php echo esc_attr($story_id); ?>">
                            <a href="javascript:void(0)">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                <?php endif; ?>
                                <span><?php echo esc_html($title); ?></span>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="col-1 d-md-flex d-none justify-content-end align-items-center">
                <a href="javascript:void(0)" class="arrow-next carusel-nav disabled" id="carusel-added-next"></a>
            </div>
        </div>
    </div>
<?php if ($section_class !== '') : ?>
    </section>
<?php endif; ?>

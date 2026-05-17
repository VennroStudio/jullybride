<?php
if (!defined('ABSPATH')) {
    exit;
}

$layout_title = function_exists('get_sub_field') ? get_sub_field('title') : '';
$layout_text = function_exists('get_sub_field') ? get_sub_field('text') : '';
$title = $layout_title ?: jullybride_option('home_hero_title', get_bloginfo('name'));
$subtitle = $layout_text ?: jullybride_option('home_hero_subtitle', 'Свадебный салон в Санкт-Петербурге');
$image = jullybride_option('home_hero_image');
$image_url = is_array($image) && !empty($image['url']) ? $image['url'] : JULLYBRIDE_THEME_URI . '/assets/images/glavnoe-foto.png';
?>
<section class="jb-home-hero">
    <div class="container jb-home-hero__inner">
        <div class="jb-home-hero__content">
            <span class="font-cursive jb-home-hero__subtitle"><?php echo esc_html($subtitle); ?></span>
            <h1 class="font-title"><?php echo esc_html($title); ?></h1>
            <?php jullybride_template_part('common/button', ['text' => 'Записаться на примерку', 'url' => jullybride_option('booking_url', '#booking')]); ?>
        </div>
        <img class="jb-home-hero__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
    </div>
</section>

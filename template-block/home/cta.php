<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="jb-home-cta">
    <div class="container">
        <?php $title = function_exists('get_sub_field') ? get_sub_field('title') : ''; ?>
        <h2><?php echo esc_html($title ?: jullybride_option('home_cta_title', 'Приезжай на примерку')); ?></h2>
        <?php jullybride_template_part('common/button', ['text' => jullybride_option('booking_text', 'Записаться'), 'url' => jullybride_option('booking_url', '#booking')]); ?>
    </div>
</section>

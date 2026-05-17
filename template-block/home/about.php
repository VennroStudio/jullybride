<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="jb-home-about">
    <div class="container">
        <?php jullybride_template_part('common/section-title', ['subtitle' => 'Jully Bride', 'title' => 'атмосфера, которую нужно почувствовать']); ?>
        <div class="jb-home-about__text">
            <?php
            $text = function_exists('get_sub_field') ? get_sub_field('text') : '';
            echo wp_kses_post($text ?: jullybride_option('home_about_text', 'Бережно переносим этот блок из текущей главной в ACF Flexible Content.'));
            ?>
        </div>
    </div>
</section>

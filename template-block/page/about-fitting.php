<?php
if (!defined('ABSPATH')) {
    exit;
}

$bg_url = wp_get_attachment_image_url(17960, 'full');
?>
<section class="jb-about-fitting" style="--jb-about-fitting-bg: url('<?php echo esc_url($bg_url); ?>');">
    <div class="jb-about-fitting__inner">
        <span>КАК ПРОХОДИТ</span>
        <h2>Примерка Мечты?</h2>
        <p>
            Примерка у нас похожа на мини-девичник красивыми платьями и кофе.
            Бери подругу и приходи в Jully Bride искать платье мечты!
            Посмотри видео о том, как проходит выбор платья у нас.
        </p>
        <?php jullybride_template_part('common/social-links', ['context' => 'about']); ?>
    </div>
</section>

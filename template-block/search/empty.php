<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="jb-empty jb-empty--search">
    <h2>Ничего не найдено</h2>
    <p>Попробуйте изменить запрос или перейти в каталог.</p>
    <?php jullybride_template_part('common/button', ['text' => 'В каталог', 'url' => home_url('/c/')]); ?>
</section>

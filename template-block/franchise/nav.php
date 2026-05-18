<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = [
    ['label' => 'О компании', 'href' => '#brand_now'],
    ['label' => 'Условия и состав франшизы', 'href' => '#conditions'],
];
?>
<nav class="franchise-nav" aria-label="Навигация по странице франшизы">
    <div class="franchise-container franchise-nav__inner">
        <div class="franchise-nav__links">
            <?php foreach ($items as $item) : ?>
                <a href="<?php echo esc_url($item['href']); ?>"><?php echo esc_html($item['label']); ?></a>
            <?php endforeach; ?>
            <?php jullybride_franchise_cta('Стать частью Jully Bride', 'franchise-button--small'); ?>
        </div>
    </div>
</nav>

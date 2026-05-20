<?php
if (!defined('ABSPATH')) {
    exit;
}

$products = jullybride_footer_products();

$menu_groups = [
    'trends' => [
        'title' => 'Свадебные тренды 2026',
        'items' => jullybride_footer_menu_items('footer_menu_trends'),
    ],
    'material' => [
        'title' => 'Материал',
        'items' => jullybride_footer_menu_items('footer_menu_material'),
    ],
    'silhouette' => [
        'title' => 'Силуэт',
        'items' => jullybride_footer_menu_items('footer_menu_silhouette'),
    ],
    'style' => [
        'title' => 'Стиль',
        'items' => jullybride_footer_menu_items('footer_menu_style'),
    ],
    'designers' => [
        'title' => 'Дизайнеры и бренды',
        'items' => jullybride_footer_menu_items('footer_menu_designers'),
    ],
    'info' => [
        'title' => '',
        'items' => jullybride_footer_menu_items('footer_menu_info'),
    ],
];

$render_items = static function (array $items) use (&$render_items): void {
    foreach ($items as $item) {
        $children = $item['children'] ?? [];
        ?>
        <li>
            <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
            <?php if ($children) : ?>
                <ul>
                    <?php $render_items($children); ?>
                </ul>
            <?php endif; ?>
        </li>
        <?php
    }
};

$render_group = static function (array $group, string $modifier = '') use ($render_items): void {
    if (empty($group['items'])) {
        return;
    }

    $classes = trim('jb-footer-menu-column ' . $modifier);
    ?>
    <nav class="<?php echo esc_attr($classes); ?>" aria-label="<?php echo esc_attr($group['title'] ?: 'Меню футера'); ?>">
        <?php if ($group['title']) : ?>
            <h2><?php echo esc_html($group['title']); ?></h2>
        <?php endif; ?>
        <ul class="jb-footer-menu-column__list">
            <?php $render_items($group['items']); ?>
        </ul>
    </nav>
    <?php
};
?>
<section class="jb-footer-1 jb-footer-desktop" aria-label="Основной футер">
    <div class="container jb-footer-1__inner">
        <div class="jb-footer-products-block">
            <h2 class="jb-footer-products-block__title">Эксклюзивные свадебные платья</h2>

            <?php if ($products) : ?>
                <div class="jb-footer-products" aria-label="Товары в футере">
                    <?php foreach ($products as $product) : ?>
                        <article class="jb-footer-product">
                            <a class="jb-footer-product__image" href="<?php echo esc_url($product['url']); ?>">
                                <?php if ($product['image']) : ?>
                                    <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['title']); ?>">
                                <?php endif; ?>
                            </a>
                            <div class="jb-footer-product__body">
                                <a class="jb-footer-product__meta" href="<?php echo esc_url($product['url']); ?>">
                                    <?php if ($product['type']) : ?>
                                        <span class="jb-footer-product__type"><?php echo esc_html($product['type']); ?></span>
                                    <?php endif; ?>
                                    <span class="jb-footer-product__title"><?php echo esc_html($product['title']); ?></span>
                                    <?php if ($product['price']) : ?>
                                        <span class="jb-footer-product__price"><?php echo esc_html($product['price']); ?></span>
                                    <?php endif; ?>
                                </a>
                                <a class="jb-footer-product__catalog" href="<?php echo esc_url($product['url']); ?>">
                                    <span>Каталог</span>
                                    <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="jb-footer-1__menus">
            <div class="jb-footer-1__menu-stack jb-footer-1__menu-stack--trends">
                <?php $render_group($menu_groups['trends']); ?>
                <?php $render_group($menu_groups['material']); ?>
                <div class="jb-footer-scroll-note" aria-hidden="true">
                    <span>покрутить</span>
                    <span>колесо</span>
                    <i>♡</i>
                </div>
            </div>

            <div class="jb-footer-1__menu-stack jb-footer-1__menu-stack--middle">
                <?php $render_group($menu_groups['silhouette']); ?>
                <?php $render_group($menu_groups['style']); ?>
            </div>

            <div class="jb-footer-1__menu-stack jb-footer-1__menu-stack--right">
                <?php $render_group($menu_groups['designers']); ?>
                <?php $render_group($menu_groups['info'], 'jb-footer-menu-column--plain'); ?>
                <a class="jb-footer-script-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                    <img src="<?php echo esc_url(jullybride_logo_url('light')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                </a>
            </div>
        </div>
    </div>
</section>

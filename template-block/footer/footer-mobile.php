<?php
if (!defined('ABSPATH')) {
    exit;
}

$products = jullybride_footer_products();
$columns = jullybride_footer_columns();
$left_links = jullybride_legal_links('left');
$right_links = jullybride_legal_links('right');
$copyright = trim((string) jullybride_option('footer_copyright_text'));
$subtitle = trim((string) jullybride_option('footer_copyright_subtitle'));

if (!$left_links && !$right_links) {
    $left_links = jullybride_legal_links();
}

$render_mobile_items = static function (array $items) use (&$render_mobile_items): void {
    foreach ($items as $item) {
        $children = $item['children'] ?? [];
        ?>
        <li>
            <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
            <?php if ($children) : ?>
                <ul>
                    <?php $render_mobile_items($children); ?>
                </ul>
            <?php endif; ?>
        </li>
        <?php
    }
};

$render_legal_links = static function (array $links): void {
    if (!$links) {
        return;
    }
    ?>
    <ul>
        <?php foreach ($links as $link) : ?>
            <li><a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php
};
?>
<section class="jb-footer-mobile" aria-label="Футер">
    <div class="container jb-footer-mobile__inner">
        <div class="jb-footer-mobile__products-block">
            <h2>Эксклюзивные свадебные платья</h2>

            <?php if ($products) : ?>
                <div class="jb-footer-mobile__products" aria-label="Товары в футере">
                    <?php foreach ($products as $product) : ?>
                        <article class="jb-footer-mobile-product">
                            <a class="jb-footer-mobile-product__image" href="<?php echo esc_url($product['url']); ?>">
                                <?php if ($product['image']) : ?>
                                    <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['title']); ?>">
                                <?php endif; ?>
                            </a>
                            <div class="jb-footer-mobile-product__body">
                                <a href="<?php echo esc_url($product['url']); ?>">
                                    <?php if ($product['type']) : ?>
                                        <span><?php echo esc_html($product['type']); ?></span>
                                    <?php endif; ?>
                                    <strong><?php echo esc_html($product['title']); ?></strong>
                                    <?php if ($product['price']) : ?>
                                        <b><?php echo esc_html($product['price']); ?></b>
                                    <?php endif; ?>
                                </a>
                                <a class="jb-footer-mobile-product__catalog" href="<?php echo esc_url($product['url']); ?>">
                                    <span>Каталог</span>
                                    <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($columns) : ?>
            <div class="jb-footer-mobile__menus">
                <?php foreach ($columns as $index => $column) : ?>
                    <?php if ($column['title']) : ?>
                        <details class="jb-footer-mobile__group"<?php echo $index === 0 ? ' open' : ''; ?>>
                            <summary><?php echo esc_html($column['title']); ?></summary>
                            <ul>
                                <?php $render_mobile_items($column['items']); ?>
                            </ul>
                        </details>
                    <?php else : ?>
                        <nav class="jb-footer-mobile__plain" aria-label="Меню футера">
                            <ul>
                                <?php $render_mobile_items($column['items']); ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a class="jb-footer-mobile__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <img src="<?php echo esc_url(jullybride_logo_url('light')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
        </a>

        <div class="jb-footer-mobile__bottom">
            <div class="jb-footer-bow" aria-hidden="true">
                <svg viewBox="893 7 104 120" focusable="false">
                    <path d="M945.996 26.0361L939.338 26.3885L937.341 26.0361L928.529 34.4539L922.146 44.5943V49.1359L926.375 52.5813L932.916 54.6955L937.341 53.3252L946.466 42.5584L952.536 34.493L954.064 32.1439L948.033 26.8583" />
                    <path d="M955.278 29.873L955.944 36.9596L956.531 38.7606L960.056 38.1733V32.3005L957.001 29.873H955.278Z" />
                    <path d="M958.059 28.5029L965.421 18.6365L974.821 12.4113L981.478 10.4146L989.585 13.7033L992.483 26.7019L990.799 39.0348L984.416 44.477L968.868 43.5373L963.15 40.366L958.059 28.5029Z" />
                    <path d="M958.058 40.7965L957.393 52.1506L961.074 57.4753L969.063 62.4085L974.938 65.4624L980.617 71.6093V80.6143L975.604 85.939L963.62 95.727L960.212 101.717L962.053 113.737L963.62 116.439L964.99 110.996L966.518 98.9375L972.392 93.652L979.873 88.3273L985.708 80.7317L987.353 74.1933L985.708 67.42L977.719 62.017L967.928 55.6743L963.737 48.8619L961.27 39.4653L958.528 40.3658" />
                    <path d="M954.808 38.7607L956.335 39.9353L954.338 44.1637L952.537 50.2715L950.461 55.9486L947.289 62.487L940.983 69.0645L932.132 74.1543L924.065 75.7204L919.992 78.8526L916.193 83.9424L914.352 91.3421L913.49 99.5249L911.532 102.54L910.788 101.717L910.201 97.4499L909.457 90.0501L910.553 83.6683L914.939 78.2653L921.754 73.4104L930.135 70.0825L938.124 65.8541L944.743 59.0807L949.991 49.6842L953.006 41.6972L954.808 38.7607Z" />
                </svg>
            </div>

            <?php if ($left_links || $right_links) : ?>
                <div class="jb-footer-mobile__legal" aria-label="Юридические ссылки">
                    <nav aria-label="Юридические ссылки слева">
                        <?php $render_legal_links($left_links); ?>
                    </nav>
                    <nav aria-label="Юридические ссылки справа">
                        <?php $render_legal_links($right_links); ?>
                    </nav>
                </div>
            <?php endif; ?>

            <?php if ($copyright || $subtitle) : ?>
                <div class="jb-footer-mobile__copyright">
                    <?php if ($copyright) : ?>
                        <p><?php echo esc_html($copyright); ?></p>
                    <?php endif; ?>
                    <?php if ($subtitle) : ?>
                        <span><?php echo esc_html($subtitle); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

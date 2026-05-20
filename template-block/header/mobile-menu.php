<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = jullybride_primary_nav_items();
$address = jullybride_option('header_address', 'Горьковская, Петроградская набережная, 18, ПН-ВС — с 11:00 до 21:00');
$phone = jullybride_option('header_phone', '+7 (812) 929-16-99');
?>
<div class="jb-mobile-menu" data-jb-mobile-menu hidden>
    <div class="jb-mobile-menu__panel">
        <button class="jb-mobile-menu__close" type="button" aria-label="Закрыть меню" data-jb-mobile-close>
            <span></span><span></span>
        </button>
        <a class="jb-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <img src="<?php echo esc_url(jullybride_logo_url('dark')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
        </a>
        <nav aria-label="Мобильное меню">
            <ul class="jb-mobile-menu__list">
                <?php foreach ($items as $item) : ?>
                    <?php $groups = jullybride_nav_item_groups($item); ?>
                    <li>
                        <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                        <?php if ($groups) : ?>
                            <ul>
                                <?php foreach ($groups as $group) : ?>
                                    <?php if (!empty($group['title'])) : ?>
                                        <li class="jb-mobile-menu__group-title"><?php echo esc_html($group['title']); ?></li>
                                    <?php endif; ?>
                                    <?php foreach (($group['items'] ?? []) as $child) : ?>
                                        <li><a href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['label']); ?></a></li>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <div class="jb-header-contacts">
            <span class="jb-header-contacts__address"><?php echo esc_html($address); ?></span>
            <a class="jb-header-contacts__phone" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
        </div>
        <div class="jb-mobile-menu__actions">
            <a class="jb-header-sale" href="<?php echo esc_url(home_url('/promo/')); ?>">Скидка</a>
            <a class="jb-header-icon" href="<?php echo esc_url(home_url('/wishlist/')); ?>" aria-label="Избранное">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 21s-7.2-4.7-9.4-9.1C.9 8.5 2.6 4.6 6.3 4.1c2-.3 3.6.6 4.7 2.1 1.1-1.5 2.7-2.4 4.7-2.1 3.7.5 5.4 4.4 3.7 7.8C19.2 16.3 12 21 12 21z"/></svg>
            </a>
            <a class="jb-header-icon" href="<?php echo esc_url(home_url('/?s=')); ?>" aria-label="Поиск">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m20.5 19.2-4.8-4.8a7 7 0 1 0-1.3 1.3l4.8 4.8 1.3-1.3ZM5.1 10.2a5.1 5.1 0 1 1 10.2 0 5.1 5.1 0 0 1-10.2 0Z"/></svg>
            </a>
        </div>
    </div>
</div>

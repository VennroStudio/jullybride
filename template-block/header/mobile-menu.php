<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = jullybride_primary_nav_items();
$address = (string) jullybride_option('header_address');
$phone = (string) jullybride_option('header_phone');
$phone_url = (string) jullybride_option('header_phone_url');
$logo = jullybride_header_logo();
$logo_url = jullybride_url((string) jullybride_option('header_logo_url'), home_url('/'));
$sale_label = (string) jullybride_option('header_sale_label');
$sale_url = jullybride_url((string) jullybride_option('header_sale_url'));
$favorites_url = jullybride_url((string) jullybride_option('header_favorites_url'));
$search_enabled = (bool) jullybride_option('header_search_enabled', true);
$extra_text = (string) jullybride_option('header_mobile_extra_text');

if ($phone && !$phone_url) {
    $phone_url = 'tel:' . preg_replace('/[^0-9+]/', '', $phone);
}
?>
<div class="jb-mobile-menu" data-jb-mobile-menu hidden>
    <div class="jb-mobile-menu__panel">
        <div class="jb-mobile-menu__head">
            <a class="jb-logo" href="<?php echo esc_url($logo_url); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
            </a>
            <button class="jb-mobile-menu__close" type="button" aria-label="Закрыть меню" data-jb-mobile-close>
                <span></span><span></span>
            </button>
        </div>
        <nav aria-label="Мобильное меню">
            <ul class="jb-mobile-menu__list">
                <?php foreach ($items as $item) : ?>
                    <?php $groups = jullybride_nav_item_groups($item); ?>
                    <li class="<?php echo $groups ? 'has-children' : ''; ?>">
                        <div class="jb-mobile-menu__top">
                            <a class="jb-mobile-menu__top-link" href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                            <?php if ($groups) : ?>
                                <button class="jb-mobile-menu__top-toggle" type="button" aria-label="Открыть раздел <?php echo esc_attr($item['label']); ?>" aria-expanded="false">
                                    <span></span>
                                </button>
                            <?php endif; ?>
                        </div>
                        <?php if ($groups) : ?>
                            <div class="jb-mobile-menu__groups">
                                <?php foreach ($groups as $group_index => $group) : ?>
                                    <div class="jb-mobile-menu__group<?php echo $group_index === 0 ? ' is-open' : ''; ?>">
                                        <?php if (!empty($group['title'])) : ?>
                                            <button class="jb-mobile-menu__group-button" type="button" aria-expanded="<?php echo $group_index === 0 ? 'true' : 'false'; ?>">
                                                <span><?php echo esc_html($group['title']); ?></span>
                                                <span class="jb-mobile-menu__group-marker" aria-hidden="true"></span>
                                            </button>
                                        <?php endif; ?>
                                        <ul>
                                            <?php foreach (($group['items'] ?? []) as $child) : ?>
                                                <li><a href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['label']); ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <?php if ($address || $phone || $extra_text) : ?>
            <div class="jb-header-contacts">
                <?php if ($address) : ?>
                    <span class="jb-header-contacts__address"><?php echo esc_html($address); ?></span>
                <?php endif; ?>
                <?php if ($phone) : ?>
                    <a class="jb-header-contacts__phone" href="<?php echo esc_url($phone_url ?: '#'); ?>"><?php echo esc_html($phone); ?></a>
                <?php endif; ?>
                <?php if ($extra_text) : ?>
                    <span class="jb-header-contacts__extra"><?php echo wp_kses_post(nl2br($extra_text)); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if (($sale_label && $sale_url) || $favorites_url || $search_enabled) : ?>
            <div class="jb-mobile-menu__actions">
                <?php if ($sale_label && $sale_url) : ?>
                    <a class="jb-header-sale" href="<?php echo esc_url($sale_url); ?>"><?php echo esc_html($sale_label); ?></a>
                <?php endif; ?>
                <?php if ($favorites_url) : ?>
                    <a class="jb-header-icon" href="<?php echo esc_url($favorites_url); ?>" aria-label="Избранное">
                        <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 21s-7.2-4.7-9.4-9.1C.9 8.5 2.6 4.6 6.3 4.1c2-.3 3.6.6 4.7 2.1 1.1-1.5 2.7-2.4 4.7-2.1 3.7.5 5.4 4.4 3.7 7.8C19.2 16.3 12 21 12 21z"/></svg>
                    </a>
                <?php endif; ?>
                <?php if ($search_enabled) : ?>
                    <a class="jb-header-icon" href="<?php echo esc_url(home_url('/?s=')); ?>" aria-label="Поиск">
                        <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m20.5 19.2-4.8-4.8a7 7 0 1 0-1.3 1.3l4.8 4.8 1.3-1.3ZM5.1 10.2a5.1 5.1 0 1 1 10.2 0 5.1 5.1 0 0 1-10.2 0Z"/></svg>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

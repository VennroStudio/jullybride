<?php
if (!defined('ABSPATH')) {
    exit;
}

$sale_label = (string) jullybride_option('header_sale_label');
$sale_url = jullybride_url((string) jullybride_option('header_sale_url'));
$favorites_url = jullybride_url((string) jullybride_option('header_favorites_url'));
$search_enabled = (bool) jullybride_option('header_search_enabled', true);
$logo = jullybride_header_logo();
$logo_url = jullybride_url((string) jullybride_option('header_logo_url'), home_url('/'));
?>
<div class="jb-site-header__nav-row">
    <div class="container jb-site-header__nav-inner">
        <?php if ($search_enabled) : ?>
            <a class="jb-header-icon jb-header-icon--mobile-search" href="<?php echo esc_url(home_url('/?s=')); ?>" aria-label="Поиск">
                <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m20.5 19.2-4.8-4.8a7 7 0 1 0-1.3 1.3l4.8 4.8 1.3-1.3ZM5.1 10.2a5.1 5.1 0 1 1 10.2 0 5.1 5.1 0 0 1-10.2 0Z"/></svg>
            </a>
        <?php endif; ?>
        <a class="jb-logo jb-site-header__mobile-logo" href="<?php echo esc_url($logo_url); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
        </a>
        <?php jullybride_template_part('header/main-menu'); ?>
        <div class="jb-site-header__actions">
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
            <button class="jb-burger" type="button" aria-label="Открыть меню" data-jb-mobile-open>
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</div>

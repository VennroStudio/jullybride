<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<header class="jb-site-header" data-jb-header>
    <?php jullybride_template_part('header/top-banner'); ?>
    <div class="jb-site-header__top">
        <div class="container jb-site-header__top-inner">
            <?php jullybride_template_part('header/city-switcher'); ?>
            <?php jullybride_template_part('header/contacts'); ?>
        </div>
    </div>

    <div class="jb-site-header__brand">
        <div class="container jb-site-header__brand-inner">
            <span class="jb-site-header__brand-text">Свадебный салон</span>
            <?php jullybride_template_part('header/logo', ['variant' => 'dark']); ?>
            <span class="jb-site-header__brand-text">Свадебный салон</span>
        </div>
    </div>

    <div class="jb-site-header__nav-row">
        <div class="container jb-site-header__nav-inner">
            <?php jullybride_template_part('header/main-menu'); ?>
            <div class="jb-site-header__actions">
                <a class="jb-header-icon" href="<?php echo esc_url(home_url('/wishlist/')); ?>" aria-label="Избранное">
                    <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 21s-7.2-4.7-9.4-9.1C.9 8.5 2.6 4.6 6.3 4.1c2-.3 3.6.6 4.7 2.1 1.1-1.5 2.7-2.4 4.7-2.1 3.7.5 5.4 4.4 3.7 7.8C19.2 16.3 12 21 12 21z"/></svg>
                </a>
                <a class="jb-header-icon" href="<?php echo esc_url(home_url('/?s=')); ?>" aria-label="Поиск">
                    <svg aria-hidden="true" viewBox="0 0 24 24"><path d="m20.5 19.2-4.8-4.8a7 7 0 1 0-1.3 1.3l4.8 4.8 1.3-1.3ZM5.1 10.2a5.1 5.1 0 1 1 10.2 0 5.1 5.1 0 0 1-10.2 0Z"/></svg>
                </a>
                <button class="jb-burger" type="button" aria-label="Открыть меню" data-jb-mobile-open>
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>

    <?php jullybride_template_part('header/mobile-menu'); ?>
</header>

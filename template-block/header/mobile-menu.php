<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = jullybride_primary_nav_items();
?>
<div class="jb-mobile-menu" data-jb-mobile-menu hidden>
    <div class="jb-mobile-menu__panel">
        <button class="jb-mobile-menu__close" type="button" aria-label="Закрыть меню" data-jb-mobile-close>
            <span></span><span></span>
        </button>
        <?php jullybride_template_part('header/logo', ['variant' => 'dark']); ?>
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
        <?php jullybride_template_part('header/contacts'); ?>
        <?php jullybride_template_part('header/booking-button'); ?>
    </div>
</div>

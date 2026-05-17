<?php
if (!defined('ABSPATH')) {
    exit;
}

$items = jullybride_primary_nav_items();
?>
<nav class="jb-main-menu" aria-label="Главное меню">
    <ul class="jb-main-menu__list">
        <?php foreach ($items as $item) : ?>
            <?php $groups = jullybride_nav_item_groups($item); ?>
            <li class="jb-main-menu__item<?php echo $groups ? ' has-dropdown' : ''; ?>">
                <a class="jb-main-menu__link" href="<?php echo esc_url($item['url']); ?>">
                    <span><?php echo esc_html($item['label']); ?></span>
                    <?php if ($groups) : ?>
                        <span class="jb-main-menu__arrow" aria-hidden="true"></span>
                    <?php endif; ?>
                </a>
                <?php if ($groups) : ?>
                    <div class="jb-main-menu__mega">
                        <?php foreach ($groups as $group) : ?>
                            <div class="jb-main-menu__mega-column">
                                <?php if (!empty($group['title'])) : ?>
                                    <?php if (!empty($group['url']) && $group['url'] !== '#') : ?>
                                        <a class="jb-main-menu__mega-title" href="<?php echo esc_url($group['url']); ?>"><?php echo esc_html($group['title']); ?></a>
                                    <?php else : ?>
                                        <span class="jb-main-menu__mega-title"><?php echo esc_html($group['title']); ?></span>
                                    <?php endif; ?>
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

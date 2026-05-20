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
                    <?php
                    $mega_columns = array_chunk($groups, (int) ceil(count($groups) / 2));
                    $group_index = 0;
                    ?>
                    <div class="jb-main-menu__mega">
                        <div class="jb-main-menu__mega-content">
                            <div class="jb-main-menu__mega-columns">
                                <?php foreach ($mega_columns as $mega_column) : ?>
                                    <div class="jb-main-menu__mega-stack">
                                        <?php foreach ($mega_column as $group) : ?>
                                            <div class="jb-main-menu__mega-column<?php echo $group_index === 0 ? ' is-open' : ''; ?>">
                                                <?php if (!empty($group['title'])) : ?>
                                                    <button class="jb-main-menu__mega-title" type="button" aria-expanded="<?php echo $group_index === 0 ? 'true' : 'false'; ?>">
                                                        <span class="jb-main-menu__mega-title-text"><?php echo esc_html($group['title']); ?></span>
                                                        <span class="jb-main-menu__mega-title-marker" aria-hidden="true"></span>
                                                    </button>
                                                <?php endif; ?>
                                                <ul>
                                                    <?php foreach (($group['items'] ?? []) as $child) : ?>
                                                        <li><a href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['label']); ?></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <?php $group_index++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="jb-main-menu__mega-visual" aria-hidden="true">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/mega-menu-visual.png'); ?>" alt="">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

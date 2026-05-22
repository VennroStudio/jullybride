<?php
if (!defined('ABSPATH')) {
    exit;
}

$filter_widget = '';
$sort_widget = '';
$filters = jullybride_catalog_filter_definitions();
$reset_url = jullybride_catalog_reset_url();
$current_order = isset($_GET['orderby']) ? sanitize_key(wp_unslash($_GET['orderby'])) : '';
$current_category = jullybride_catalog_current_product_category();
$current_category_id = $current_category instanceof WP_Term ? (int) $current_category->term_id : 0;
$stock_base_ids = jullybride_catalog_count_base_product_ids('jb_in_stock');
$stock_ids = jullybride_catalog_stock_product_ids(jullybride_catalog_selected_size_values());
$stock_count = count(array_intersect($stock_base_ids, $stock_ids));
$quick_filter_configs = [
    [
        'taxonomy' => 'pa_length',
        'id' => 'filter-length',
        'class' => 'filter-length',
        'label' => 'Длина',
    ],
    [
        'taxonomy' => 'pa_silhouette',
        'id' => 'filter-silhouette',
        'class' => 'filter-silhouette',
        'label' => 'Силуэт',
    ],
];
$quick_filters = [];

foreach ($quick_filter_configs as $config) {
    $definition = null;

    foreach ($filters as $filter) {
        if (in_array($config['taxonomy'], (array) ($filter['taxonomies'] ?? []), true)) {
            $definition = $filter;
            break;
        }
    }

    if (!$definition) {
        continue;
    }

    $param = (string) $definition['param'];
    $selected = jullybride_catalog_expanded_request_values_for_definition($definition);
    $terms = jullybride_catalog_filter_terms($definition, jullybride_catalog_count_base_product_ids($param));
    $terms = array_values(array_filter($terms, static function (array $term) use ($selected): bool {
        $term_slugs = (array) ($term['slugs'] ?? [$term['slug']]);

        return (int) ($term['count'] ?? 0) > 0 || (bool) array_intersect($selected, $term_slugs);
    }));

    if (!$terms) {
        continue;
    }

    $quick_filters[] = array_merge($config, [
        'param' => $param,
        'selected' => $selected,
        'terms' => $terms,
    ]);
}

[$price_min, $price_max] = jullybride_catalog_price_bounds(jullybride_catalog_count_base_product_ids('_price'));
[$selected_price_min, $selected_price_max] = jullybride_catalog_selected_price_values();
?>
<section class="top-filters">
    <div class="container position-relative">
        <div class="filter-box">
            <div class="filter-wrap">
                <button class="w-filter-list-closer" type="button" title="Закрыть" aria-label="Закрыть"></button>
                <span class="filter-box_title d-block">Фильтр</span>

                <?php if ($filter_widget !== '') : ?>
                    <?php echo $filter_widget; ?>
                <?php else : ?>
                    <form class="jb-catalog-filter-form" method="get" data-jb-filters data-jb-catalog-category="<?php echo esc_attr((string) $current_category_id); ?>">
                        <?php if ($current_order !== '') : ?>
                            <input type="hidden" name="orderby" value="<?php echo esc_attr($current_order); ?>">
                        <?php endif; ?>

                        <div class="jb-filter-scroll">
                            <fieldset class="jb-filter jb-filter--stock">
                                <legend class="jb-filter__legend">
                                    <button class="jb-filter__toggle" type="button" data-jb-filter-toggle>
                                        <span>Наличие</span>
                                        <span class="jb-filter__mark" aria-hidden="true"></span>
                                    </button>
                                </legend>
                                <div class="jb-filter__terms">
                                    <label data-jb-filter-option data-jb-filter-param="jb_in_stock" data-jb-filter-slug="1">
                                        <input type="checkbox" name="jb_in_stock" value="1" <?php checked(!empty($_GET['jb_in_stock'])); ?>>
                                        <span>В наличии</span>
                                        <small data-jb-filter-count><?php echo esc_html((string) $stock_count); ?></small>
                                    </label>
                                </div>
                            </fieldset>

                            <?php foreach ($filters as $filter) : ?>
                                <?php
                                $param = (string) $filter['param'];
                                $selected = jullybride_catalog_expanded_request_values_for_definition($filter);

                                $terms = jullybride_catalog_filter_terms($filter, jullybride_catalog_count_base_product_ids($param));
                                $terms = array_values(array_filter($terms, static function (array $term) use ($selected): bool {
                                    $term_slugs = (array) ($term['slugs'] ?? [$term['slug']]);

                                    return (int) ($term['count'] ?? 0) > 0 || (bool) array_intersect($selected, $term_slugs);
                                }));

                                if (!$terms) {
                                    continue;
                                }

                                ?>
                                <fieldset class="jb-filter">
                                    <legend class="jb-filter__legend">
                                        <button class="jb-filter__toggle" type="button" data-jb-filter-toggle>
                                            <span><?php echo esc_html((string) $filter['label']); ?></span>
                                            <span class="jb-filter__mark" aria-hidden="true"></span>
                                        </button>
                                    </legend>
                                    <div class="jb-filter__terms">
                                        <?php foreach ($terms as $term) : ?>
                                            <?php
                                            $term_slugs = (array) ($term['slugs'] ?? [$term['slug']]);
                                            $checked = (bool) array_intersect($selected, $term_slugs);
                                            $count = (int) $term['count'];
                                            $disabled = $count <= 0 && !$checked;
                                            ?>
                                            <label class="<?php echo $disabled ? 'is-disabled' : ''; ?>" data-jb-filter-option data-jb-filter-param="<?php echo esc_attr($param); ?>" data-jb-filter-slug="<?php echo esc_attr($term['slug']); ?>">
                                                <input type="checkbox" data-jb-filter-term="<?php echo esc_attr($param); ?>" value="<?php echo esc_attr($term['slug']); ?>" <?php checked($checked); ?> <?php disabled($disabled); ?>>
                                                <span><?php echo esc_html($term['name']); ?></span>
                                                <small data-jb-filter-count><?php echo esc_html((string) $count); ?></small>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" name="<?php echo esc_attr($param); ?>" value="<?php echo esc_attr(implode(',', $selected)); ?>">
                                </fieldset>
                            <?php endforeach; ?>
                        </div>

                        <div class="jb-filter-actions">
                            <a class="jb-filter-reset" href="<?php echo esc_url($reset_url); ?>">Сбросить</a>
                            <button class="theme-button button-main" type="submit">Применить</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <a href="javascript:void(0)" class="left-filter-btn">Фильтр</a>
                <?php if ($sort_widget !== '') : ?>
                    <?php echo $sort_widget; ?>
                <?php else : ?>
                    <form class="jb-catalog-sort-form" method="get">
                        <?php foreach ($_GET as $key => $value) : ?>
                            <?php
                            $key = sanitize_key((string) $key);
                            if ($key === 'orderby' || $key === 'paged' || $key === 'page') {
                                continue;
                            }

                            $value = is_array($value) ? '' : (string) wp_unslash($value);
                            if ($value === '') {
                                continue;
                            }
                            ?>
                            <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>">
                        <?php endforeach; ?>
                        <label class="screen-reader-text" for="jb-catalog-sort">Сортировка</label>
                        <select id="jb-catalog-sort" class="jb-sort-select" name="orderby" onchange="this.form.submit()">
                            <option value="" <?php selected($current_order, ''); ?>>По умолчанию</option>
                            <option value="price" <?php selected($current_order, 'price'); ?>>Сначала дешевле</option>
                            <option value="price-desc" <?php selected($current_order, 'price-desc'); ?>>Сначала дороже</option>
                            <option value="date" <?php selected($current_order, 'date'); ?>>Сначала новинки</option>
                        </select>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="last-filter" id="custom-filters">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex">
                <?php foreach ($quick_filters as $quick_filter) : ?>
                    <label class="screen-reader-text" for="<?php echo esc_attr($quick_filter['id']); ?>"><?php echo esc_html($quick_filter['label']); ?></label>
                    <select
                        id="<?php echo esc_attr($quick_filter['id']); ?>"
                        class="<?php echo esc_attr($quick_filter['class']); ?>"
                        data-jb-catalog-quick-filter="<?php echo esc_attr($quick_filter['param']); ?>"
                    >
                        <option value=""><?php echo esc_html($quick_filter['label']); ?></option>
                        <?php foreach ($quick_filter['terms'] as $term) : ?>
                            <?php
                            $term_slugs = (array) ($term['slugs'] ?? [$term['slug']]);
                            $checked = (bool) array_intersect($quick_filter['selected'], $term_slugs);
                            ?>
                            <option value="<?php echo esc_attr((string) $term['slug']); ?>" <?php selected($checked); ?>>
                                <?php echo esc_html((string) $term['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endforeach; ?>

                <div
                    class="filter-price-dropdown"
                    id="price-dropdown-root"
                    data-jb-price-filter
                    data-price-min="<?php echo esc_attr((string) $price_min); ?>"
                    data-price-max="<?php echo esc_attr((string) $price_max); ?>"
                >
                    <button class="filter-price-trigger" type="button" data-jb-price-toggle>Цена</button>
                    <div class="filter-price-content" data-jb-price-content hidden>
                        <div class="filter-price-range">
                            <input
                                type="number"
                                id="min-price"
                                placeholder="<?php echo esc_attr((string) $price_min); ?>"
                                value="<?php echo esc_attr($selected_price_min); ?>"
                                min="0"
                                data-jb-price-min
                            >
                            <input
                                type="number"
                                id="max-price"
                                placeholder="<?php echo esc_attr((string) $price_max); ?>"
                                value="<?php echo esc_attr($selected_price_max); ?>"
                                min="0"
                                data-jb-price-max
                            >
                        </div>
                        <div class="filter-price-actions">
                            <button type="button" class="btn btn-apply" data-jb-price-apply>Применить</button>
                            <button type="button" class="btn btn-reset" data-jb-price-reset>Сбросить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

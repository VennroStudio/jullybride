<?php
if (!defined('ABSPATH')) {
    exit;
}

$attributes = function_exists('wc_get_attribute_taxonomies') && jullybride_attribute_taxonomy_table_exists()
    ? wc_get_attribute_taxonomies()
    : [];
?>
<section class="top-filters">
    <div class="container position-relative">
        <div class="filter-box">
            <div class="filter-wrap">
                <button class="w-filter-list-closer" type="button" title="Закрыть" aria-label="Закрыть"></button>
                <span class="filter-box_title d-block">Фильтр</span>
                <?php echo do_shortcode('[fe_widget]'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <a href="javascript:void(0)" class="left-filter-btn">Фильтр</a>
                <?php echo do_shortcode('[fe_sort id="2"]'); ?>
            </div>
        </div>
    </div>
</section>

<section class="last-filter" id="custom-filters">
    <div class="container">
        <form class="d-flex jb-attribute-filters" method="get" data-jb-filters>
            <label class="filter-stock">
                <input type="checkbox" name="jb_in_stock" value="1" <?php checked(!empty($_GET['jb_in_stock'])); ?>>
                В наличии
            </label>

            <?php foreach ($attributes as $attribute) : ?>
                <?php
                $taxonomy = wc_attribute_taxonomy_name($attribute->attribute_name);
                if (!taxonomy_exists($taxonomy)) {
                    continue;
                }
                $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => true]);
                if (!$terms || is_wp_error($terms)) {
                    continue;
                }
                $param = 'filter_' . $taxonomy;
                $selected = isset($_GET[$param]) ? array_filter(array_map('sanitize_title', explode(',', (string) wp_unslash($_GET[$param])))) : [];
                ?>
                <fieldset class="jb-filter">
                    <legend><?php echo esc_html($attribute->attribute_label); ?></legend>
                    <?php foreach ($terms as $term) : ?>
                        <label>
                            <input type="checkbox" data-jb-filter-term="<?php echo esc_attr($param); ?>" value="<?php echo esc_attr($term->slug); ?>" <?php checked(in_array($term->slug, $selected, true)); ?>>
                            <span><?php echo esc_html($term->name); ?></span>
                        </label>
                    <?php endforeach; ?>
                    <input type="hidden" name="<?php echo esc_attr($param); ?>" value="<?php echo esc_attr(implode(',', $selected)); ?>">
                </fieldset>
            <?php endforeach; ?>
            <button class="theme-button button-main" type="submit">Показать</button>
        </form>
    </div>
</section>

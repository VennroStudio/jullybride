<?php
if (!defined('ABSPATH')) {
    exit;
}

function jullybride_product_primary_category(int $product_id): ?WP_Term
{
    $terms = wp_get_post_terms($product_id, 'product_cat', [
        'orderby' => 'term_order',
        'order' => 'ASC',
    ]);

    if (!$terms || is_wp_error($terms)) {
        return null;
    }

    $terms = array_values(array_filter($terms, static fn ($term): bool => $term instanceof WP_Term));

    return $terms[0] ?? null;
}

function jullybride_product_image_ids(WC_Product $product): array
{
    $main_image_id = $product->get_image_id();
    $gallery_ids = $product->get_gallery_image_ids();

    return array_values(array_filter(array_merge(
        $main_image_id ? [$main_image_id] : [],
        $gallery_ids ?: []
    )));
}

function jullybride_format_price(int|float|string|null $price): string
{
    if ($price === null || $price === '') {
        return '';
    }

    return number_format((float) $price, 0, ',', ' ') . '₽';
}

function jullybride_product_type_label(int $product_id): string
{
    return function_exists('get_field') ? (string) get_field('tip_tovara', $product_id) : '';
}

function jullybride_clean_builder_content(string $content): string
{
    $content = preg_replace('/\[\/?(?:vc|us)_[a-z0-9_-]+[^\]]*\]/i', '', $content) ?? $content;
    $content = preg_replace('/\[\/?vc_[^\]]*\]/i', '', $content) ?? $content;

    return trim($content);
}

function jullybride_render_clean_post_content(int|string|null $post_id = null): string
{
    $post = get_post($post_id ?: get_the_ID());

    if (!$post instanceof WP_Post) {
        return '';
    }

    $content = jullybride_clean_builder_content((string) $post->post_content);

    return apply_filters('the_content', $content);
}

function jullybride_home_source_id(): int
{
    $front_page_id = (int) get_option('page_on_front');

    return $front_page_id > 0 && get_post($front_page_id) instanceof WP_Post ? $front_page_id : 0;
}

function jullybride_product_available_sizes(int $product_id): array
{
    $product = wc_get_product($product_id);

    if (!$product) {
        return [];
    }

    if (!$product->is_type('variable')) {
        return $product->is_in_stock() ? ['В наличии'] : [];
    }

    $sizes = [];
    foreach ($product->get_children() as $variation_id) {
        $variation = wc_get_product($variation_id);
        if (!$variation || !$variation->is_in_stock()) {
            continue;
        }

        foreach ($variation->get_attributes() as $taxonomy => $slug) {
            if (!$slug) {
                continue;
            }

            $term = taxonomy_exists($taxonomy) ? get_term_by('slug', $slug, $taxonomy) : null;
            $sizes[] = $term instanceof WP_Term ? $term->name : (string) $slug;
        }
    }

    return array_values(array_unique(array_filter($sizes)));
}

add_action('template_redirect', 'jullybride_track_recently_viewed_products', 20);
function jullybride_track_recently_viewed_products(): void
{
    if (!function_exists('wc_setcookie') || !is_singular('product')) {
        return;
    }

    $product_id = get_queried_object_id();
    $viewed = empty($_COOKIE['woocommerce_recently_viewed'])
        ? []
        : wp_parse_id_list(explode('|', wp_unslash((string) $_COOKIE['woocommerce_recently_viewed'])));

    $viewed = array_values(array_diff($viewed, [$product_id]));
    $viewed[] = $product_id;

    if (count($viewed) > JULLYBRIDE_RECENTLY_VIEWED_LIMIT) {
        array_shift($viewed);
    }

    wc_setcookie('woocommerce_recently_viewed', implode('|', $viewed));
}

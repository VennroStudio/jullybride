<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('jullybride_stock_field')) {
    function jullybride_stock_field(string $field, int|string|null $post_id = null, mixed $fallback = ''): mixed
    {
        $post_id = $post_id ?: get_the_ID();

        if (function_exists('get_field')) {
            $value = get_field($field, $post_id);
            if ($value !== null && $value !== false && $value !== '') {
                return $value;
            }
        }

        $value = get_post_meta((int) $post_id, $field, true);

        return $value !== '' && $value !== null ? $value : $fallback;
    }
}

if (!function_exists('jullybride_stock_image_url')) {
    function jullybride_stock_image_url(string $field, int|string|null $post_id = null, string $size = 'full', string $fallback = ''): string
    {
        $post_id = $post_id ?: get_the_ID();
        $value = jullybride_stock_field($field, $post_id, '');

        if (is_array($value)) {
            if ($size !== 'full' && !empty($value['sizes'][$size])) {
                return (string) $value['sizes'][$size];
            }

            return (string) ($value['url'] ?? $fallback);
        }

        if (is_numeric($value)) {
            $url = $size === 'full'
                ? wp_get_attachment_url((int) $value)
                : wp_get_attachment_image_url((int) $value, $size);

            return (string) ($url ?: $fallback);
        }

        if (is_string($value) && preg_match('~^https?://~', $value)) {
            return $value;
        }

        return $fallback;
    }
}

if (!function_exists('jullybride_stock_featured_image_url')) {
    function jullybride_stock_featured_image_url(int|string|null $post_id = null, string $size = 'jullybride-card'): string
    {
        $post_id = $post_id ?: get_the_ID();
        $thumbnail_id = get_post_thumbnail_id((int) $post_id);

        if ($thumbnail_id) {
            return (string) (wp_get_attachment_image_url($thumbnail_id, $size) ?: wp_get_attachment_url($thumbnail_id));
        }

        return jullybride_stock_image_url('sale_img', $post_id, $size);
    }
}

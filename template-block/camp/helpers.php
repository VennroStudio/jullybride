<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('jullybride_camp_field')) {
    function jullybride_camp_field(string $name, mixed $fallback = ''): mixed
    {
        if (!function_exists('get_field')) {
            return $fallback;
        }

        $value = get_field($name);

        return ($value !== null && $value !== false && $value !== '') ? $value : $fallback;
    }
}

if (!function_exists('jullybride_camp_image_url')) {
    function jullybride_camp_image_url(mixed $image, string $size = 'full'): string
    {
        if (is_numeric($image)) {
            $image_url = $size === 'full' ? wp_get_attachment_url((int) $image) : wp_get_attachment_image_url((int) $image, $size);

            return (string) ($image_url ?: wp_get_attachment_url((int) $image));
        }

        if (is_array($image)) {
            if (!empty($image['sizes'][$size])) {
                return (string) $image['sizes'][$size];
            }

            return (string) ($image['url'] ?? '');
        }

        return is_string($image) ? $image : '';
    }
}

if (!function_exists('jullybride_camp_image_alt')) {
    function jullybride_camp_image_alt(mixed $image, string $fallback = ''): string
    {
        if (is_numeric($image)) {
            return (string) get_post_meta((int) $image, '_wp_attachment_image_alt', true);
        }

        if (is_array($image)) {
            return (string) ($image['alt'] ?? $fallback);
        }

        return $fallback;
    }
}

if (!function_exists('jullybride_camp_asset')) {
    function jullybride_camp_asset(string $file): string
    {
        return jullybride_asset_uri('images/' . ltrim($file, '/'));
    }
}

<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('jullybride_franchise_image')) {
    function jullybride_franchise_image(int $image_id, string $class = '', string $alt = '', string $size = 'full'): void
    {
        $attrs = [
            'class' => trim($class),
            'loading' => 'lazy',
        ];

        if (strpos($class, 'franchise-hero') !== false) {
            $attrs['loading'] = 'eager';
            $attrs['fetchpriority'] = 'high';
        }

        if ($alt !== '') {
            $attrs['alt'] = $alt;
        }

        $image = wp_get_attachment_image($image_id, $size, false, $attrs);

        if ($image) {
            echo $image;
        }
    }
}

if (!function_exists('jullybride_franchise_image_url')) {
    function jullybride_franchise_image_url(int $image_id, string $size = 'full'): string
    {
        $url = $size === 'full'
            ? wp_get_attachment_url($image_id)
            : wp_get_attachment_image_url($image_id, $size);

        return (string) ($url ?: wp_get_attachment_url($image_id));
    }
}

if (!function_exists('jullybride_franchise_video_url')) {
    function jullybride_franchise_video_url(int $video_id): string
    {
        $url = wp_get_attachment_url($video_id);

        return (string) ($url ?: '');
    }
}

if (!function_exists('jullybride_franchise_cta')) {
    function jullybride_franchise_cta(string $label = 'Получить предложение', string $class = ''): void
    {
        printf(
            '<a class="franchise-button %s" href="#franchise-feedback-modal" data-jb-franchise-feedback>%s</a>',
            esc_attr($class),
            esc_html($label)
        );
    }
}

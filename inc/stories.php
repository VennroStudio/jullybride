<?php
if (!defined('ABSPATH')) {
    exit;
}

function jullybride_stories_field_name(): string
{
    return 'carusel-added-owl';
}

function jullybride_stories_source(): string
{
    return 'option';
}

function jullybride_media_url(mixed $media, string $size = 'full'): string
{
    if (is_array($media)) {
        if (!empty($media['id'])) {
            $url = $size === 'full'
                ? wp_get_attachment_url((int) $media['id'])
                : wp_get_attachment_image_url((int) $media['id'], $size);

            return (string) ($url ?: ($media['url'] ?? ''));
        }

        if (!empty($media['ID'])) {
            $url = $size === 'full'
                ? wp_get_attachment_url((int) $media['ID'])
                : wp_get_attachment_image_url((int) $media['ID'], $size);

            return (string) ($url ?: ($media['url'] ?? ''));
        }

        return (string) ($media['url'] ?? '');
    }

    if (is_numeric($media)) {
        $url = $size === 'full'
            ? wp_get_attachment_url((int) $media)
            : wp_get_attachment_image_url((int) $media, $size);

        return (string) $url;
    }

    return is_string($media) ? $media : '';
}

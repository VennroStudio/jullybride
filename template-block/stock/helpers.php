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

if (!function_exists('jullybride_stock_countdown_target')) {
    function jullybride_stock_countdown_target(int|string|null $post_id = null): string
    {
        $post_id = $post_id ?: get_the_ID();
        $month = max(1, min(12, (int) jullybride_stock_field('sale_month', $post_id, (int) current_time('n'))));
        $day = max(1, min(31, (int) jullybride_stock_field('sale_day', $post_id, (int) current_time('j'))));
        $hour = max(0, min(23, (int) jullybride_stock_field('sale_hours', $post_id, 0)));
        $timezone = wp_timezone();
        $year = (int) current_time('Y');

        $target = DateTimeImmutable::createFromFormat('!Y-n-j G:i:s', sprintf('%d-%d-%d %d:00:00', $year, $month, $day, $hour), $timezone);
        if (!$target) {
            $target = new DateTimeImmutable('now', $timezone);
        }

        if ($target->getTimestamp() < current_time('timestamp')) {
            $target = $target->modify('+1 year');
        }

        return $target->format(DATE_ATOM);
    }
}

if (!function_exists('jullybride_stock_text_lines')) {
    function jullybride_stock_text_lines(string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($text)) ?: [];

        return array_values(array_filter(array_map('trim', $lines)));
    }
}

if (!function_exists('jullybride_stock_repeated_text')) {
    function jullybride_stock_repeated_text(string $text, int $times = 10): string
    {
        $text = trim($text) !== '' ? trim($text) : 'несколько слов';
        $items = array_fill(0, $times, $text);

        return implode(' ', $items);
    }
}

if (!function_exists('jullybride_stock_default_videos')) {
    function jullybride_stock_default_videos(): array
    {
        return [
            content_url('uploads/2023/09/14-febr-1.mp4'),
            content_url('uploads/2023/09/chernaya-pyatnitsa-1.mp4'),
            content_url('uploads/2023/09/img-3944-1.mp4'),
            content_url('uploads/2023/09/img-6565-1.mp4'),
            content_url('uploads/2023/09/img-6588-1.mp4'),
            content_url('uploads/2023/09/img-7361-1.mp4'),
        ];
    }
}

if (!function_exists('jullybride_stock_video_urls')) {
    function jullybride_stock_video_urls(int|string|null $post_id = null): array
    {
        $post_id = $post_id ?: get_the_ID();
        $raw = jullybride_stock_field('sale_video_urls', $post_id, '');
        $urls = is_string($raw) ? jullybride_stock_text_lines($raw) : [];

        return $urls ?: jullybride_stock_default_videos();
    }
}

<?php
if (!defined('ABSPATH')) {
    exit;
}

$home_source_id = jullybride_home_source_id();
$left_items = [];
$box_important = function_exists('get_field') ? get_field('box_important', $home_source_id) : [];

if (is_array($box_important)) {
    foreach ($box_important as $item) {
        if (!is_array($item)) {
            continue;
        }

        $left_items[] = [
            'title' => (string) ($item['title'] ?? ''),
            'text' => (string) ($item['text'] ?? ''),
            'icon' => jullybride_asset_uri('images/vector-11.svg'),
        ];
    }
}

$video_important = function_exists('get_field') ? (string) get_field('video_important', $home_source_id) : '';
$text_stroke = function_exists('get_field') ? (string) get_field('text_stroke', $home_source_id) : '';

jullybride_template_part('components/important-cta', [
    'section_class' => 'box-important position-relative jb-stock-important-cta',
    'left_items' => $left_items,
    'media' => [
        'type' => 'video',
        'url' => $video_important,
        'poster' => jullybride_asset_uri('images/galereya1.webp'),
    ],
    'right_cursive' => '“то самое”',
    'right_title' => 'совсем близко',
    'right_text' => 'Ты находишься в одном шаге<br> от знакомства с платьем мечты!',
    'button_text' => 'Записаться на примерку',
    'button_url' => 'javascript:void(0)',
    'button_class' => 'button-main-main-bg theme-button d-table ms_booking',
    'marquee_text' => $text_stroke,
    'decor_image' => jullybride_asset_uri('images/2000.svg'),
]);

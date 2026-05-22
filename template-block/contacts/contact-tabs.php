<?php
if (!defined('ABSPATH')) {
    exit;
}

$acf_cities = function_exists('get_field') ? get_field('contacts_cities') : [];
$cities = [];

$field_value = static function (array $source, string $key): string {
    $value = $source[$key] ?? '';

    return is_string($value) ? trim($value) : '';
};

if (is_array($acf_cities)) {
    foreach ($acf_cities as $index => $city_row) {
        if (!is_array($city_row)) {
            continue;
        }

        $contacts = isset($city_row['contacts']) && is_array($city_row['contacts']) ? $city_row['contacts'] : [];
        $socials = isset($contacts['socials']) && is_array($contacts['socials']) ? $contacts['socials'] : [];
        $title = $field_value($city_row, 'title');
        $slug = $field_value($city_row, 'slug');

        if ($title === '') {
            continue;
        }

        $cities[] = [
            'slug' => $slug !== '' ? $slug : sanitize_title($title ?: 'city-' . ($index + 1)),
            'title' => $title,
            'address' => $field_value($contacts, 'address'),
            'phone' => $field_value($contacts, 'phone'),
            'worktime' => $field_value($contacts, 'worktime'),
            'email' => $field_value($contacts, 'email'),
            'reply' => $field_value($contacts, 'reply'),
            'details' => isset($contacts['details']) && is_string($contacts['details']) ? $contacts['details'] : '',
            'map' => $field_value($contacts, 'map'),
            'map_link' => $field_value($contacts, 'map_link'),
            'socials' => [
                'telegram' => $field_value($socials, 'telegram'),
                'vk' => $field_value($socials, 'vk'),
                'instagram' => $field_value($socials, 'instagram'),
                'youtube' => $field_value($socials, 'youtube'),
            ],
        ];
    }
}

$tabs = [];

foreach ($cities as $city) {
    $tabs[] = [
        'id' => $city['slug'],
        'label' => $city['title'],
        'template' => 'contacts/contact-panel',
        'args' => [
            'city' => $city,
        ],
    ];
}

$company_details = function_exists('get_field') ? get_field('contacts_company_details') : '';

if ($company_details) {
    $tabs[] = [
        'id' => 'requisites',
        'label' => 'Реквизиты',
        'template' => 'contacts/company-details',
        'args' => [
            'details' => $company_details,
        ],
    ];
}

jullybride_template_part('components/tabs-section', [
    'aria_label' => 'Контакты по городам',
    'show_header' => false,
    'managed' => true,
    'tabs' => $tabs,
]);
?>

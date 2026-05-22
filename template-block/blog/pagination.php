<?php
if (!defined('ABSPATH')) {
    exit;
}

global $wp_query;

jullybride_template_part('components/pagination', [
    'query' => $wp_query,
    'next_id' => '',
]);

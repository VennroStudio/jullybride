#!/usr/bin/env php
<?php
/**
 * Move home page story data into the shared ACF Options page.
 *
 * Usage:
 * php scripts/migrate-stories-to-options.php
 * php scripts/migrate-stories-to-options.php --force
 * php scripts/migrate-stories-to-options.php --source=59177 --force
 */

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "This script must be run from CLI.\n");
    exit(1);
}

$args = getopt('', ['force', 'source:']);
$force = array_key_exists('force', $args);
$source_id = isset($args['source']) ? (int) $args['source'] : null;

$dir = __DIR__;
$wp_load = '';

for ($i = 0; $i < 8; $i++) {
    $candidate = $dir . '/wp-load.php';

    if (is_file($candidate)) {
        $wp_load = $candidate;
        break;
    }

    $parent = dirname($dir);

    if ($parent === $dir) {
        break;
    }

    $dir = $parent;
}

if ($wp_load === '') {
    fwrite(STDERR, "wp-load.php was not found above " . __DIR__ . ".\n");
    exit(1);
}

define('WP_USE_THEMES', false);
require_once $wp_load;

function jbs_stories_field_name(): string
{
    return 'carusel-added-owl';
}

function jbs_stories_option_field_key(string $meta_key): string
{
    $field_name = jbs_stories_field_name();
    $key = ltrim($meta_key, '_');

    if ($key === $field_name) {
        return 'field_jullybride_stories_items';
    }

    if (preg_match('/^' . preg_quote($field_name, '/') . '_\d+_title$/', $key)) {
        return 'field_jullybride_stories_title';
    }

    if (preg_match('/^' . preg_quote($field_name, '/') . '_\d+_img$/', $key)) {
        return 'field_jullybride_stories_img';
    }

    if (preg_match('/^' . preg_quote($field_name, '/') . '_\d+_link$/', $key)) {
        return 'field_jullybride_stories_link';
    }

    if (preg_match('/^' . preg_quote($field_name, '/') . '_\d+_karusel$/', $key)) {
        return 'field_jullybride_stories_slides';
    }

    if (preg_match('/^' . preg_quote($field_name, '/') . '_\d+_karusel_\d+_foto$/', $key)) {
        return 'field_jullybride_stories_slide_foto';
    }

    if (preg_match('/^' . preg_quote($field_name, '/') . '_\d+_karusel_\d+_video$/', $key)) {
        return 'field_jullybride_stories_slide_video';
    }

    return '';
}

function jbs_resolve_stories_source_id(?int $source_id): int
{
    if ($source_id !== null && $source_id > 0) {
        return $source_id;
    }

    return (int) get_option('page_on_front');
}

function jbs_migrate_stories_to_options(bool $force = false, ?int $source_id = null): bool
{
    $marker = 'jullybride_stories_migrated_to_options';

    if (!$force && get_option($marker)) {
        return false;
    }

    $field_name = jbs_stories_field_name();
    $option_count_key = 'options_' . $field_name;

    if (!$force && (int) get_option($option_count_key) > 0) {
        update_option($marker, 'already-present', false);
        return false;
    }

    $source_id = jbs_resolve_stories_source_id($source_id);

    if ($source_id <= 0) {
        return false;
    }

    $story_count = (int) get_post_meta($source_id, $field_name, true);

    if ($story_count <= 0) {
        return false;
    }

    $meta = get_post_meta($source_id);
    $copied = 0;

    foreach ($meta as $meta_key => $values) {
        $is_value_key = $meta_key === $field_name || str_starts_with($meta_key, $field_name . '_');
        $is_reference_key = $meta_key === '_' . $field_name || str_starts_with($meta_key, '_' . $field_name . '_');

        if (!$is_value_key && !$is_reference_key) {
            continue;
        }

        $value = maybe_unserialize($values[0] ?? '');

        if ($is_reference_key) {
            $field_key = jbs_stories_option_field_key($meta_key);

            if ($field_key === '') {
                continue;
            }

            update_option('_options_' . ltrim($meta_key, '_'), $field_key, false);
            $copied++;
            continue;
        }

        update_option('options_' . $meta_key, $value, false);
        $copied++;
    }

    if ($copied === 0) {
        return false;
    }

    update_option($marker, (string) time(), false);

    return true;
}

$field_name = jbs_stories_field_name();
$resolved_source_id = jbs_resolve_stories_source_id($source_id);
$before_count = (int) get_option('options_' . $field_name);
$result = jbs_migrate_stories_to_options($force, $source_id);
$after_count = (int) get_option('options_' . $field_name);
$acf_count = null;

if (function_exists('get_field')) {
    $stories = get_field($field_name, 'option');
    $acf_count = is_array($stories) ? count($stories) : 0;
}

echo 'source_id=' . $resolved_source_id . PHP_EOL;
echo 'force=' . ($force ? 'yes' : 'no') . PHP_EOL;
echo 'result=' . ($result ? 'migrated' : 'skipped') . PHP_EOL;
echo 'option_count_before=' . $before_count . PHP_EOL;
echo 'option_count_after=' . $after_count . PHP_EOL;

if ($acf_count !== null) {
    echo 'acf_count=' . $acf_count . PHP_EOL;
}

echo 'marker=' . get_option('jullybride_stories_migrated_to_options') . PHP_EOL;

<?php
if (!defined('ABSPATH')) {
    exit;
}

$args = $args ?? [];

$field = static function (string $name, mixed $fallback = '', bool $format = true): mixed {
    if (!function_exists('get_field')) {
        return $fallback;
    }

    $value = get_field($name, false, $format);

    return ($value !== null && $value !== false && $value !== '') ? $value : $fallback;
};

$gallery = $args['gallery'] ?? $field('ekran_4_-_galereya', [], false);

if (!$gallery) {
    return;
}

if (function_exists('jullybride_prime_attachment_caches') && is_array($gallery)) {
    jullybride_prime_attachment_caches($gallery);
}
?>
<section class="box_beautiful_vacation">
    <div class="container position-relative">
        <div class="row">
            <?php
            jullybride_template_part('components/gallery', [
                'gallery' => $gallery,
                'part' => 'inline',
            ]);
            ?>
        </div>
    </div>

    <?php
    jullybride_template_part('components/gallery', [
        'gallery' => $gallery,
        'part' => 'desktop',
    ]);
    ?>
</section>

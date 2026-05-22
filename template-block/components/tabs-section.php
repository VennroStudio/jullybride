<?php
if (!defined('ABSPATH')) {
    exit;
}

$tabs = array_values(array_filter((array) ($args['tabs'] ?? []), static function ($tab): bool {
    return is_array($tab) && !empty($tab['label']);
}));

if (!$tabs) {
    return;
}

$section_id = trim((string) ($args['section_id'] ?? ''));
$title = (string) ($args['title'] ?? '');
$subtitle = (string) ($args['subtitle'] ?? '');
$title_tag = (string) ($args['title_tag'] ?? 'h2');
$title_tag = in_array($title_tag, ['h1', 'h2', 'h3'], true) ? $title_tag : 'h2';
$show_header = array_key_exists('show_header', $args) ? (bool) $args['show_header'] : ($title !== '' || $subtitle !== '');
$aria_label = trim((string) ($args['aria_label'] ?? ''));
$before_html = (string) ($args['before_html'] ?? '');
$after_html = (string) ($args['after_html'] ?? '');
$managed = !empty($args['managed']);
?>
<section class="tabs-box"<?php echo $section_id !== '' ? ' id="' . esc_attr($section_id) . '"' : ''; ?> data-jb-tabs-section<?php echo $managed ? ' data-jb-tabs-managed="1"' : ''; ?>>
    <?php echo $before_html; ?>

    <?php if ($show_header) : ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if ($subtitle !== '') : ?>
                        <span class="section-subtitle d-block text-center"><?php echo esc_html($subtitle); ?></span>
                    <?php endif; ?>
                    <?php if ($title !== '') : ?>
                        <<?php echo $title_tag; ?> class="section-title text-center font-title"><?php echo esc_html($title); ?></<?php echo $title_tag; ?>>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container">
        <ul class="tabs-list d-md-flex d-none align-items-center"<?php echo $aria_label !== '' ? ' aria-label="' . esc_attr($aria_label) . '"' : ''; ?> role="tablist">
            <?php foreach ($tabs as $tab_index => $tab) : ?>
                <?php $tab_id = sanitize_title((string) ($tab['id'] ?? $tab['label'])); ?>
                <li
                    class="<?php echo $tab_index === 0 ? 'active' : ''; ?>"
                    data-jb-tabs-trigger="<?php echo esc_attr($tab_id); ?>"
                    role="tab"
                    aria-selected="<?php echo $tab_index === 0 ? 'true' : 'false'; ?>"
                >
                    <?php echo esc_html((string) $tab['label']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="slides-tabs">
        <?php foreach ($tabs as $tab_index => $tab) : ?>
            <?php
            $tab_id = sanitize_title((string) ($tab['id'] ?? $tab['label']));
            $panel_args = array_merge((array) ($tab['args'] ?? []), [
                'active' => $tab_index === 0,
                'tab_id' => $tab_id,
                'tab_index' => $tab_index,
            ]);
            ?>
            <span class="d-md-none d-block mobile-tab-wrap<?php echo $tab_index === 0 ? ' active' : ''; ?>" data-jb-tabs-mobile-trigger="<?php echo esc_attr($tab_id); ?>">
                <span class="mobile-tab"><?php echo esc_html((string) $tab['label']); ?></span>
            </span>
            <div class="container taab<?php echo $tab_index === 0 ? ' active' : ''; ?>" data-jb-tabs-panel="<?php echo esc_attr($tab_id); ?>"<?php echo $managed && $tab_index !== 0 ? ' hidden' : ''; ?>>
                <?php
                if (!empty($tab['template'])) {
                    jullybride_template_part((string) $tab['template'], $panel_args);
                } elseif (isset($tab['content'])) {
                    echo (string) $tab['content'];
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php echo $after_html; ?>
</section>

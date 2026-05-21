<?php
if (!defined('ABSPATH')) {
    exit;
}

$args = is_array($args ?? null) ? $args : [];
$text = (string) ($args['text'] ?? '');
$wrapper_class = trim((string) ($args['class'] ?? 'lenta-stroke2'));
$height = max(1, (int) ($args['height'] ?? 180));
$viewbox_height = max(1, (int) ($args['viewbox_height'] ?? 180));
$duration = (string) ($args['duration'] ?? '120s');
$font_size = max(1, (int) ($args['font_size'] ?? 14));
$text_fill = (string) ($args['text_fill'] ?? '#fde5ec');
$strip_fill = (string) ($args['strip_fill'] ?? 'rgba(24, 24, 24, 1)');
$background_rect = (bool) ($args['background_rect'] ?? false);
$background_fill = (string) ($args['background_fill'] ?? '#f9e5e9');
$repeat = array_key_exists('repeat', $args) ? (bool) $args['repeat'] : true;
$path_id = (string) ($args['path_id'] ?? wp_unique_id('floating-strip-path-'));
$text_id = (string) ($args['text_id'] ?? wp_unique_id('floating-strip-text-'));
?>
<div class="<?php echo esc_attr($wrapper_class); ?>">
    <svg width="100%" height="<?php echo esc_attr((string) $height); ?>" viewBox="0 0 1920 <?php echo esc_attr((string) $viewbox_height); ?>" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <?php if ($background_rect) : ?>
            <rect x="0" y="60" width="1920" height="120" fill="<?php echo esc_attr($background_fill); ?>"></rect>
        <?php endif; ?>
        <path d="M0,40 C250,-20 500,100 750,40 C1000,-20 1250,100 1500,40 C1700,-20 1850,100 1920,40 L1920,80 C1850,140 1700,20 1500,80 C1250,140 1000,20 750,80 C500,140 250,20 0,80 Z" fill="<?php echo esc_attr($strip_fill); ?>"></path>
        <path id="<?php echo esc_attr($path_id); ?>" d="M0,60 C250,0 500,120 750,60 C1000,0 1250,120 1500,60 C1700,0 1850,120 1920,60" stroke="none" fill="none"></path>
        <text font-size="<?php echo esc_attr((string) $font_size); ?>" fill="<?php echo esc_attr($text_fill); ?>" text-anchor="middle" letter-spacing="1" id="<?php echo esc_attr($text_id); ?>" dy="5">
            <textPath href="#<?php echo esc_attr($path_id); ?>" startOffset="50%">
                <?php echo esc_html($text); ?>
                <animate attributeName="startOffset" from="100%" to="-100%" dur="<?php echo esc_attr($duration); ?>"<?php echo $repeat ? ' repeatCount="indefinite"' : ''; ?>></animate>
            </textPath>
        </text>
    </svg>
</div>

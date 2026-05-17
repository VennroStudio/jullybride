<?php
if (!defined('ABSPATH')) {
    exit;
}

$links = jullybride_social_links();
?>
<div class="jb-social-links jb-social-links--<?php echo esc_attr($args['context'] ?? 'default'); ?>">
    <?php foreach ((array) $links as $link) : ?>
        <?php
        $url = is_array($link) ? ($link['url'] ?? '') : '';
        $label = is_array($link) ? ($link['label'] ?? $url) : '';
        $icon = is_array($link) ? ($link['icon'] ?? '') : '';
        if (!$url || $url === '#') {
            continue;
        }
        ?>
        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($label); ?>">
            <?php if ($icon) : ?>
                <img src="<?php echo esc_url(jullybride_asset_uri('images/' . $icon)); ?>" alt="">
            <?php else : ?>
                <span><?php echo esc_html($label); ?></span>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>
</div>

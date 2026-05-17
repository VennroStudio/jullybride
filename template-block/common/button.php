<?php
if (!defined('ABSPATH')) {
    exit;
}

$text = $args['text'] ?? 'Подробнее';
$url = $args['url'] ?? '#';
$mod = $args['modifier'] ?? '';
?>
<a class="jb-button <?php echo esc_attr($mod); ?>" href="<?php echo esc_url($url); ?>"><?php echo esc_html($text); ?></a>


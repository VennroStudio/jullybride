<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once JULLYBRIDE_THEME_DIR . '/template-block/stock-single/helpers.php';

$text = (string) ($args['text'] ?? 'несколько слов');
?>
<div class="jb-promo-marquee" aria-hidden="true">
    <div class="jb-promo-marquee__track">
        <span><?php echo esc_html(jullybride_stock_single_repeated_text($text, 16)); ?></span>
        <span><?php echo esc_html(jullybride_stock_single_repeated_text($text, 16)); ?></span>
    </div>
</div>

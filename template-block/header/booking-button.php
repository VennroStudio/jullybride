<?php
if (!defined('ABSPATH')) {
    exit;
}

$url = jullybride_option('booking_url', '#booking');
$text = jullybride_option('booking_text', 'Записаться');
?>
<a class="jb-button jb-button--booking" href="<?php echo esc_url($url); ?>"><?php echo esc_html($text); ?></a>


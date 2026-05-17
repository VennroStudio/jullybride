<?php
if (!defined('ABSPATH')) {
    exit;
}

$phone = jullybride_option('header_phone', '+7 (812) 929-16-99');
$address = jullybride_option('header_address', 'Горьковская, Петроградская набережная, 18, ПН-ВС — с 11:00 до 21:00');
?>
<div class="jb-header-contacts">
    <span class="jb-header-contacts__address"><?php echo esc_html($address); ?></span>
    <a class="jb-header-contacts__phone" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
</div>


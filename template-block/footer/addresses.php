<?php
if (!defined('ABSPATH')) {
    exit;
}

$addresses = jullybride_option('footer_addresses');
if (!$addresses) {
    $addresses = [['address' => jullybride_option('header_address', 'Горьковская, Петроградская набережная, 18')]];
}
?>
<div class="jb-footer-addresses">
    <?php foreach ((array) $addresses as $item) : ?>
        <?php $address = is_array($item) ? ($item['address'] ?? '') : $item; ?>
        <?php if ($address) : ?>
            <p><?php echo esc_html($address); ?></p>
        <?php endif; ?>
    <?php endforeach; ?>
</div>


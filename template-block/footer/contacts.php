<?php
if (!defined('ABSPATH')) {
    exit;
}

$phone = jullybride_option('footer_phone', jullybride_option('header_phone', '+7 (812) 929-16-99'));
$email = jullybride_option('footer_email', 'info@jullybride.ru');
$address = jullybride_option('footer_address', jullybride_option('header_address', 'г. Санкт-Петербург, Петроградская набережная, 18'));
?>
<div class="jb-footer-contacts">
    <h2>Контакты</h2>
    <p class="jb-footer-contacts__item jb-footer-contacts__item--address"><?php echo esc_html($address); ?></p>
    <a class="jb-footer-contacts__item jb-footer-contacts__item--phone" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
    <?php if ($email) : ?>
        <a class="jb-footer-contacts__item jb-footer-contacts__item--email" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
    <?php endif; ?>
</div>

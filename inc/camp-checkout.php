<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_buy_now', 'jullybride_buy_now_handler');
add_action('wp_ajax_nopriv_buy_now', 'jullybride_buy_now_handler');

function jullybride_buy_now_handler(): void
{
    if (!function_exists('wc_get_product') || !function_exists('wc_create_order')) {
        wp_send_json_error('WooCommerce недоступен');
    }

    $product_id = isset($_POST['product_id']) ? absint(wp_unslash($_POST['product_id'])) : 0;
    $name = isset($_POST['customer_name']) ? sanitize_text_field(wp_unslash($_POST['customer_name'])) : '';
    $email = isset($_POST['customer_email']) ? sanitize_email(wp_unslash($_POST['customer_email'])) : '';

    if (!$product_id || $name === '' || !is_email($email)) {
        wp_send_json_error('Некорректные данные');
    }

    $product = wc_get_product($product_id);

    if (!$product || !$product->is_purchasable()) {
        wp_send_json_error('Товар не найден');
    }

    try {
        $order = wc_create_order();
        $order->set_customer_id(get_current_user_id());
        $order->set_payment_method('yookassa');
        $order->add_product($product, 1);
        $order->set_billing_first_name($name);
        $order->set_billing_email($email);
        $order->calculate_totals();
        $order->save();

        wp_send_json_success([
            'redirect' => $order->get_checkout_payment_url(),
        ]);
    } catch (Throwable $exception) {
        wp_send_json_error('Не удалось создать заказ');
    }
}

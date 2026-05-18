<?php
/**
 * Empty cart page.
 *
 * @package JullyBride\WooCommerce
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

$shop_url = wc_get_page_permalink('shop');
if (!$shop_url) {
    $shop_url = home_url('/c/');
}
?>
<div class="jb-cart-empty">
    <?php
    /**
     * @hooked wc_empty_cart_message - 10
     */
    do_action('woocommerce_cart_is_empty');
    ?>

    <p class="return-to-shop">
        <a class="button wc-backward" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', $shop_url)); ?>">
            <?php echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Return to shop', 'woocommerce'))); ?>
        </a>
    </p>
</div>

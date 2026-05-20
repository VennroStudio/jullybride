<?php
if (!defined('ABSPATH')) {
    exit;
}

$logo = jullybride_header_logo();
$logo_url = jullybride_url((string) jullybride_option('header_logo_url'), home_url('/'));
$left_text = (string) jullybride_option('header_brand_left_text');
$right_text = (string) jullybride_option('header_brand_right_text');
?>
<div class="jb-site-header__brand">
    <div class="container jb-site-header__brand-inner">
        <?php if ($left_text) : ?>
            <div class="jb-site-header__brand-side jb-site-header__brand-side--left">
                <span class="jb-site-header__brand-text"><?php echo esc_html($left_text); ?></span>
            </div>
        <?php endif; ?>
        <a class="jb-logo" href="<?php echo esc_url($logo_url); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
        </a>
        <?php if ($right_text) : ?>
            <div class="jb-site-header__brand-side jb-site-header__brand-side--right">
                <span class="jb-site-header__brand-text"><?php echo esc_html($right_text); ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$variant = isset($args['variant']) ? (string) $args['variant'] : 'dark';
?>
<a class="jb-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <img src="<?php echo esc_url(jullybride_logo_url($variant)); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
</a>

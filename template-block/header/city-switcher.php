<?php
if (!defined('ABSPATH')) {
    exit;
}

$city = jullybride_option('current_city', 'Санкт-Петербург');
?>
<button class="jb-city-switcher" type="button" data-jb-city-switcher>
    <span><?php echo esc_html($city); ?></span>
    <span class="jb-city-switcher__arrow" aria-hidden="true"></span>
</button>

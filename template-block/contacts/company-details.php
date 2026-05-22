<?php
if (!defined('ABSPATH')) {
    exit;
}

$details = (string) ($args['details'] ?? '');

if ($details === '' && function_exists('get_field')) {
    $details = (string) get_field('contacts_company_details');
}

if ($details === '') {
    return;
}
?>
<section class="jb-company-details">
    <?php echo wp_kses_post($details); ?>
</section>

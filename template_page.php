<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
$is_contacts_page = is_page('contacts');
$is_service_page = is_page(['cart', 'checkout', 'wishlist']);
?>
<main class="jb-main jb-page<?php echo $is_service_page ? ' jb-service-page' : ''; ?>">
    <div class="container">
        <?php jullybride_breadcrumbs(); ?>
        <?php
        if ($is_contacts_page) {
            jullybride_template_part('page/contacts');
        } elseif ($is_service_page) {
            jullybride_template_part('page/service');
        } else {
            jullybride_template_part('page/hero');
        }

        if (!$is_contacts_page && !$is_service_page && !jullybride_render_flexible('page_blocks', 'page')) {
            jullybride_template_part('page/content');
        }
        ?>
    </div>
    <?php
    if ($is_service_page) {
        jullybride_template_part('common/important-cta');
    }
    ?>
</main>

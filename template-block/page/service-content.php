<?php
if (!defined('ABSPATH')) {
    exit;
}

$slug = get_post_field('post_name', get_queried_object_id());
?>
<div class="jb-service__content jb-service__content--<?php echo esc_attr($slug); ?>">
    <?php
    while (have_posts()) {
        the_post();
        the_content();
    }
    ?>
</div>

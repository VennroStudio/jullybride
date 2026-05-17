<?php
if (!defined('ABSPATH')) {
    exit;
}

$default_title = 'Секретная папка, в которую мы собираем интересную информацию о подготовке к свадьбе';

if (is_home()) {
    $posts_page_id = (int) get_option('page_for_posts');
    $title = $posts_page_id ? get_the_title($posts_page_id) : $default_title;
} elseif (is_category()) {
    $title = single_cat_title('', false);
} elseif (is_tag()) {
    $title = single_tag_title('', false);
} elseif (is_archive()) {
    $title = get_the_archive_title();
} else {
    $title = get_the_title();
}

$title = trim(wp_strip_all_tags((string) $title)) ?: $default_title;
?>
<header class="jb-blog-header">
    <h1><?php echo esc_html($title); ?></h1>
</header>

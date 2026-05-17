<?php
if (!defined('ABSPATH')) {
    exit;
}

$links = jullybride_legal_links();
?>
<nav class="jb-legal-links" aria-label="Юридические ссылки">
    <ul class="jb-legal-links__list">
        <?php foreach ($links as $link) : ?>
            <li><a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>

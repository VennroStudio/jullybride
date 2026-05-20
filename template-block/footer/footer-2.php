<?php
if (!defined('ABSPATH')) {
    exit;
}

$copyright = trim((string) jullybride_option('footer_copyright_text'));
$subtitle = trim((string) jullybride_option('footer_copyright_subtitle'));
$left_links = jullybride_legal_links('left');
$right_links = jullybride_legal_links('right');

if (!$left_links && !$right_links) {
    $left_links = jullybride_legal_links();
}

$render_links = static function (array $links, string $label): void {
    if (!$links) {
        return;
    }
    ?>
    <nav class="jb-footer-legal" aria-label="<?php echo esc_attr($label); ?>">
        <ul>
            <?php foreach ($links as $link) : ?>
                <li><a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
};
?>
<section class="jb-footer-2 jb-footer-desktop" aria-label="Копирайт">
    <div class="jb-footer-bow" aria-hidden="true">
        <svg viewBox="893 7 104 120" focusable="false">
            <path d="M945.996 26.0361L939.338 26.3885L937.341 26.0361L928.529 34.4539L922.146 44.5943V49.1359L926.375 52.5813L932.916 54.6955L937.341 53.3252L946.466 42.5584L952.536 34.493L954.064 32.1439L948.033 26.8583" />
            <path d="M955.278 29.873L955.944 36.9596L956.531 38.7606L960.056 38.1733V32.3005L957.001 29.873H955.278Z" />
            <path d="M958.059 28.5029L965.421 18.6365L974.821 12.4113L981.478 10.4146L989.585 13.7033L992.483 26.7019L990.799 39.0348L984.416 44.477L968.868 43.5373L963.15 40.366L958.059 28.5029Z" />
            <path d="M958.058 40.7965L957.393 52.1506L961.074 57.4753L969.063 62.4085L974.938 65.4624L980.617 71.6093V80.6143L975.604 85.939L963.62 95.727L960.212 101.717L962.053 113.737L963.62 116.439L964.99 110.996L966.518 98.9375L972.392 93.652L979.873 88.3273L985.708 80.7317L987.353 74.1933L985.708 67.42L977.719 62.017L967.928 55.6743L963.737 48.8619L961.27 39.4653L958.528 40.3658" />
            <path d="M954.808 38.7607L956.335 39.9353L954.338 44.1637L952.537 50.2715L950.461 55.9486L947.289 62.487L940.983 69.0645L932.132 74.1543L924.065 75.7204L919.992 78.8526L916.193 83.9424L914.352 91.3421L913.49 99.5249L911.532 102.54L910.788 101.717L910.201 97.4499L909.457 90.0501L910.553 83.6683L914.939 78.2653L921.754 73.4104L930.135 70.0825L938.124 65.8541L944.743 59.0807L949.991 49.6842L953.006 41.6972L954.808 38.7607Z" />
        </svg>
    </div>
    <div class="container jb-footer-2__inner">
        <div class="jb-footer-2__links jb-footer-2__links--left">
            <?php $render_links($left_links, 'Юридические ссылки слева'); ?>
        </div>

        <div class="jb-footer-2__brand">
            <?php if ($copyright) : ?>
                <p class="jb-footer-copyright"><?php echo esc_html($copyright); ?></p>
            <?php endif; ?>
            <?php if ($subtitle) : ?>
                <p class="jb-footer-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>

        <div class="jb-footer-2__links jb-footer-2__links--right">
            <?php $render_links($right_links, 'Юридические ссылки справа'); ?>
        </div>
    </div>
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$query = $args['query'] ?? null;
if (!$query instanceof WP_Query) {
    return;
}

$total = (int) $query->max_num_pages;
$current = max(1, absint(get_query_var('paged')));

if ($total <= 1) {
    return;
}
?>
<div class="container box-pagination">
    <div class="row">
        <div class="col-12">
            <ul class="owl-list d-flex justify-content-center">
                <?php
                if ($current === 1) {
                    echo '<li class="selected"><span>1</span></li>';
                } else {
                    echo '<li><a href="' . esc_url(get_pagenum_link(1)) . '">1</a></li>';
                }

                if ($current - 2 > 2) {
                    echo '<li><span>...</span></li>';
                }

                $start = max(2, $current - 2);
                $end = min($total - 1, $current + 2);
                for ($i = $start; $i <= $end; $i++) {
                    echo $i === $current
                        ? '<li class="selected"><span>' . esc_html((string) $i) . '</span></li>'
                        : '<li><a href="' . esc_url(get_pagenum_link($i)) . '">' . esc_html((string) $i) . '</a></li>';
                }

                if ($current + 2 < $total - 1) {
                    echo '<li><span>...</span></li>';
                }

                echo $current === $total
                    ? '<li class="selected"><span>' . esc_html((string) $total) . '</span></li>'
                    : '<li><a href="' . esc_url(get_pagenum_link($total)) . '">' . esc_html((string) $total) . '</a></li>';

                $arrow = '<img src="' . esc_url(jullybride_asset_uri('images/icon-5.svg')) . '" alt="Следующая">';
                echo $current < $total
                    ? '<li><a href="' . esc_url(get_pagenum_link($current + 1)) . '" id="load-more-link">' . $arrow . '</a></li>'
                    : '<li class="disabled"><span>' . $arrow . '</span></li>';
                ?>
            </ul>
        </div>
    </div>
</div>

<?php
if (!defined('ABSPATH')) {
    exit;
}

$args = is_array($args ?? null) ? $args : [];
$query = $args['query'] ?? null;
$total = $query instanceof WP_Query ? (int) $query->max_num_pages : (int) ($args['total'] ?? 0);
$current = (int) ($args['current'] ?? max(1, absint(get_query_var('paged')), absint(get_query_var('page'))));
$next_id = array_key_exists('next_id', $args) ? (string) $args['next_id'] : 'load-more-link';

if ($total <= 1) {
    return;
}

$current = min($total, max(1, $current));
$page_link = static fn (int $page): string => esc_url(get_pagenum_link($page));
?>
<div class="container box-pagination">
    <div class="row">
        <div class="col-12">
            <ul class="owl-list d-flex justify-content-center">
                <?php
                if ($current === 1) {
                    echo '<li class="selected"><span>1</span></li>';
                } else {
                    echo '<li><a href="' . $page_link(1) . '">1</a></li>';
                }

                if ($current - 2 > 2) {
                    echo '<li><span>...</span></li>';
                }

                $start = max(2, $current - 2);
                $end = min($total - 1, $current + 2);
                for ($i = $start; $i <= $end; $i++) {
                    echo $i === $current
                        ? '<li class="selected"><span>' . esc_html((string) $i) . '</span></li>'
                        : '<li><a href="' . $page_link($i) . '">' . esc_html((string) $i) . '</a></li>';
                }

                if ($current + 2 < $total - 1) {
                    echo '<li><span>...</span></li>';
                }

                echo $current === $total
                    ? '<li class="selected"><span>' . esc_html((string) $total) . '</span></li>'
                    : '<li><a href="' . $page_link($total) . '">' . esc_html((string) $total) . '</a></li>';

                $arrow = '<img src="' . esc_url(jullybride_asset_uri('images/icon-5.svg')) . '" alt="Следующая">';
                if ($current < $total) {
                    $id_attr = $next_id !== '' ? ' id="' . esc_attr($next_id) . '"' : '';
                    echo '<li><a href="' . $page_link($current + 1) . '"' . $id_attr . '>' . $arrow . '</a></li>';
                } else {
                    echo '<li class="disabled"><span>' . $arrow . '</span></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

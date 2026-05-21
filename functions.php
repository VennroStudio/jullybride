<?php
/**
 * JullyBride theme bootstrap.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('JULLYBRIDE_THEME_VERSION', '0.1.0');
define('JULLYBRIDE_THEME_DIR', get_template_directory());
define('JULLYBRIDE_THEME_URI', get_template_directory_uri());
define('JULLYBRIDE_FOOTER_PRODUCTS_LIMIT', 3);
define('JULLYBRIDE_CATALOG_PER_PAGE', 23);
define('JULLYBRIDE_RECENTLY_VIEWED_LIMIT', 15);
define('JULLYBRIDE_CATALOG_FILTER_PRIORITY', [
    'pa_razmer',
    'pa_silhouette',
    'pa_length',
    'pa_designer',
    'pa_material',
    'pa_style',
]);

require_once JULLYBRIDE_THEME_DIR . '/inc/post-types.php';
require_once JULLYBRIDE_THEME_DIR . '/inc/setup-assets.php';
require_once JULLYBRIDE_THEME_DIR . '/inc/template-helpers.php';
require_once JULLYBRIDE_THEME_DIR . '/inc/product-helpers.php';
require_once JULLYBRIDE_THEME_DIR . '/inc/footer-helpers.php';
require_once JULLYBRIDE_THEME_DIR . '/inc/catalog.php';

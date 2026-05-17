<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<form class="jb-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="jb-search-form__field">
        <span class="screen-reader-text">Поиск</span>
        <input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Что ищем?">
        <button type="submit" aria-label="Найти"></button>
    </label>
</form>

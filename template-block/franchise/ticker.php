<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="franchise-ticker" aria-hidden="true">
    <div class="franchise-ticker__track">
        <?php for ($i = 0; $i < 8; $i++) : ?>
            <span<?php echo $i % 2 === 0 ? ' class="is-pink"' : ''; ?>>Спец условия для действующих свадебных салонов</span>
        <?php endfor; ?>
    </div>
</div>

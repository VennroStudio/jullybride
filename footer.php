<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
if (function_exists('jullybride_prime_acf_option_group')) {
    jullybride_prime_acf_option_group('footer');
}
?>
<footer class="jb-site-footer">
    <?php jullybride_template_part('footer/footer-1'); ?>
    <?php jullybride_template_part('footer/footer-2'); ?>
    <?php jullybride_template_part('footer/footer-mobile'); ?>
</footer>
<?php
wp_footer();
?>
</body>
</html>

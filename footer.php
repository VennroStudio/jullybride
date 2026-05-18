<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<footer class="jb-site-footer">
    <div class="container">
        <div class="jb-site-footer__main">
            <div class="jb-site-footer__brand">
                <?php jullybride_template_part('footer/logo'); ?>
                <?php jullybride_template_part('footer/socials'); ?>
                <?php jullybride_template_part('footer/contacts'); ?>
            </div>
            <?php jullybride_template_part('footer/footer-menu'); ?>
        </div>

        <div class="jb-site-footer__bottom">
            <?php jullybride_template_part('footer/copyright'); ?>
            <?php jullybride_template_part('footer/legal-links'); ?>
        </div>
    </div>
</footer>
<?php
wp_footer();
?>
</body>
</html>

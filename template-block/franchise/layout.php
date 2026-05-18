<?php
if (!defined('ABSPATH')) {
    exit;
}

jullybride_template_part('franchise/helpers');
?>
<main class="franchise-page">
    <?php
    jullybride_template_part('franchise/nav');
    jullybride_template_part('franchise/hero');
    jullybride_template_part('franchise/ticker');
    jullybride_template_part('franchise/business-stack');
    jullybride_template_part('franchise/visibility');
    jullybride_template_part('franchise/social-gallery');
    jullybride_template_part('franchise/brand-now');
    jullybride_template_part('franchise/conditions');
    jullybride_template_part('franchise/steps');
    jullybride_template_part('franchise/team');
    jullybride_template_part('franchise/family');
    jullybride_template_part('franchise/history');
    jullybride_template_part('franchise/merch');
    jullybride_template_part('franchise/guarantee');
    ?>
    <a class="franchise-floating-stamp" href="#conditions" aria-label="Узнать условия франшизы">
        <span>узнать условия франшизы</span>
    </a>
</main>

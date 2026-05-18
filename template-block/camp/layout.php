<?php
if (!defined('ABSPATH')) {
    exit;
}

jullybride_template_part('camp/helpers');
?>
<main class="main-page content jb-camp-page">
    <?php
    jullybride_template_part('camp/hero');
    jullybride_template_part('camp/program');
    jullybride_template_part('camp/audience');
    jullybride_template_part('camp/rest-ribbon');
    jullybride_template_part('camp/gallery');
    jullybride_template_part('camp/prizes');
    jullybride_template_part('camp/video-gallery');
    jullybride_template_part('camp/headliners');
    jullybride_template_part('camp/prices');
    jullybride_template_part('camp/countdown');
    ?>
</main>

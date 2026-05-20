<?php
if (!defined('ABSPATH')) {
    exit;
}

$upload_dir = wp_upload_dir();
$video_url = trailingslashit($upload_dir['baseurl']) . '2023/09/jb-promo-1.4-sub_720.mp4';
$poster_id = 51772;
$poster_url = wp_get_attachment_image_url($poster_id, 'jullybride-wide') ?: wp_get_attachment_image_url($poster_id, 'full');
?>
<section class="jb-about-video">
    <header class="jb-about-heading">
        <h1>О компании</h1>
    </header>

    <div class="jb-about-video__frame">
        <video controls preload="metadata" playsinline poster="<?php echo esc_url($poster_url); ?>">
            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
        </video>
    </div>

    <a class="jb-about-video__link" href="https://www.youtube.com/channel/UCo_Zo2x9fyN19uuxkWO_v-g" target="_blank" rel="noopener">
        Больше наших видео на нашем youtube-канале
    </a>
</section>

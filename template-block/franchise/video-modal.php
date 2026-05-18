<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="franchise-video-modal" class="franchise-video-modal" hidden data-jb-franchise-video-modal>
    <div class="franchise-video-modal__overlay" data-jb-franchise-video-close></div>
    <div class="franchise-video-modal__dialog" role="dialog" aria-modal="true" aria-label="Видео Jully Bride">
        <button class="franchise-video-modal__close" type="button" aria-label="Закрыть видео" data-jb-franchise-video-close></button>
        <video class="franchise-video-modal__player" controls playsinline data-jb-franchise-video-player></video>
    </div>
</div>

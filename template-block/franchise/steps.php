<?php
if (!defined('ABSPATH')) {
    exit;
}

$opening_video = jullybride_franchise_video_url(59025);
?>
<section id="franchise-steps" class="franchise-launch franchise-section">
    <div class="franchise-container">
        <div class="franchise-launch__heading">
            <p>4 шага к открытию</p>
            <h2>Салона Jully Bride</h2>
        </div>
        <div class="franchise-launch__steps">
            <?php jullybride_franchise_image(53298, 'franchise-launch__steps-image franchise-launch__steps-image--desktop', '4 шага к открытию салона Jully Bride'); ?>
            <?php jullybride_franchise_image(53299, 'franchise-launch__steps-image franchise-launch__steps-image--mobile', '4 шага к открытию салона Jully Bride'); ?>
        </div>
        <div class="franchise-launch__video">
            <?php jullybride_franchise_image(53301, 'franchise-launch__video-cover', 'Торжественное открытие салона Jully Bride'); ?>
            <?php if ($opening_video) : ?>
                <button class="franchise-launch__video-button" type="button" data-jb-franchise-video="<?php echo esc_url($opening_video); ?>" aria-label="Смотреть видео с торжественного открытия">
                    <?php jullybride_franchise_image(53302, '', 'Смотреть видео с торжественного открытия'); ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>

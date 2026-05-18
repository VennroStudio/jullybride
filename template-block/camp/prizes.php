<?php
if (!defined('ABSPATH')) {
    exit;
}

$text = jullybride_camp_field('ekran_5_-_tekst_vnutri_vrashhayushhiesya_karuseli');
$items = [
    'parfyum.png',
    'konvert.png',
    'svecha.png',
    'korset.png',
    'klyuch.png',
    'makaruns.png',
    'morozhennoe.png',
    'konvert.png',
    'svecha.png',
    'korset.png',
    'klyuch.png',
    'makaruns.png',
];
?>
<?php if ($text) : ?>
    <div class="position-relative box_carusel_prizov-mobile_wrap">
        <section class="position-relative box_carusel_prizov wow bounceInUp">
            <div class="rotate-trigger" aria-hidden="true"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12 position-relative">
                        <div class="rotate-container-button">
                            <span><?php echo wp_kses_post($text); ?></span>
                        </div>
                        <div class="rotating-items-section" id="rotate-section">
                            <div class="rotate-container">
                                <?php foreach ($items as $index => $file) : ?>
                                    <div class="rotate-container_item rotate-container_item-<?php echo esc_attr((string) ($index + 1)); ?>">
                                        <img src="<?php echo esc_url(jullybride_camp_asset($file)); ?>" alt="">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php endif; ?>

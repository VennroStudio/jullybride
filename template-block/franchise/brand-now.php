<?php
if (!defined('ABSPATH')) {
    exit;
}

$cards_left = [
    ['number' => 'play', 'label' => 'Лучший свадебный салон по версии Wedding Awards NW'],
    ['number' => '12', 'label' => 'Лет на рынке в свадебной индустрии'],
];

$cards_right = [
    ['number' => 'play', 'label' => 'Wedding Cafe By Jully Bride первое в мире кафе для невест'],
    ['number' => '3', 'label' => 'Салона в России. Москва, Санкт-Петербург, Ростов-на-Дону.'],
];
?>
<section id="brand_now" class="franchise-brand franchise-section">
    <div class="franchise-container">
        <div class="franchise-section-heading">
            <h2>Бренд<br>Jully Bride сейчас</h2>
        </div>
        <div class="franchise-brand__composition">
            <div class="franchise-brand__column">
            <?php foreach ($cards_left as $card) : ?>
                <article class="franchise-brand-card">
                    <?php if ($card['number'] === 'play') : ?>
                        <?php jullybride_franchise_image(53234, 'franchise-brand-card__play', ''); ?>
                    <?php else : ?>
                        <strong><?php echo esc_html($card['number']); ?></strong>
                    <?php endif; ?>
                    <p><?php echo esc_html($card['label']); ?></p>
                </article>
            <?php endforeach; ?>
            </div>
            <div class="franchise-brand__center">
                <?php jullybride_franchise_image(53229, 'franchise-brand__society', 'Соцсети Jully Bride'); ?>
            </div>
            <div class="franchise-brand__column">
            <?php foreach ($cards_right as $card) : ?>
                <article class="franchise-brand-card">
                    <?php if ($card['number'] === 'play') : ?>
                        <?php jullybride_franchise_image(53234, 'franchise-brand-card__play', ''); ?>
                    <?php else : ?>
                        <strong><?php echo esc_html($card['number']); ?></strong>
                    <?php endif; ?>
                    <p><?php echo esc_html($card['label']); ?></p>
                </article>
            <?php endforeach; ?>
            </div>
        </div>
        <?php jullybride_franchise_cta('Записаться на консультацию', 'franchise-brand__button'); ?>
        <div class="franchise-brand__decor" aria-hidden="true">
            <?php jullybride_franchise_image(53239, 'franchise-brand__hand franchise-brand__hand--right', ''); ?>
            <?php jullybride_franchise_image(53238, 'franchise-brand__hand franchise-brand__hand--left', ''); ?>
        </div>
    </div>
</section>

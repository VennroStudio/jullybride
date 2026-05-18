<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="franchise-hero franchise-section">
    <div class="franchise-container franchise-hero__grid">
        <div class="franchise-hero__content">
            <h1 class="franchise-hero__title">
                <span>Открой свой бизнес</span>
                <em>в свадебной сфере</em>
            </h1>
            <div class="franchise-hero__facts">
                <div>
                    <strong>1 франшиза в 1 городе</strong>
                    <span>Эксклюзивное право на работу в данном регионе.</span>
                </div>
                <div>
                    <strong>Окупаемость до 2 лет</strong>
                    <span>Проверенная модель бизнеса, с быстрым возвратом вложений.</span>
                </div>
            </div>
            <?php jullybride_franchise_cta('Стать частью команды'); ?>
        </div>

        <div class="franchise-hero__visual" aria-hidden="true">
            <div class="franchise-arch franchise-hero__photo">
                <?php jullybride_franchise_image(53197, 'franchise-hero__image', 'Франшиза Jully Bride'); ?>
            </div>
            <?php jullybride_franchise_image(53195, 'franchise-hero__badge', 'Доход от 1 млн в месяц'); ?>
        </div>
    </div>
</section>

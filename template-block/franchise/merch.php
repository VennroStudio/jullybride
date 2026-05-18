<?php
if (!defined('ABSPATH')) {
    exit;
}

$merch_images = [53118, 53119, 53114, 53112, 53113, 53117];
?>
<section id="franchise-merch" class="franchise-merch-original franchise-section">
    <div class="franchise-container">
        <div class="franchise-merch-original__heading">
            <p>Бонус</p>
            <h2>У нас есть фирменный мерч</h2>
        </div>

        <div class="franchise-merch-carousel">
            <button class="franchise-merch-carousel__arrow franchise-merch-carousel__arrow--prev" type="button" aria-label="Предыдущий мерч" data-jb-merch-prev></button>
            <div class="franchise-merch-carousel__viewport" data-jb-merch-carousel>
                <div class="franchise-merch-carousel__track">
                    <?php foreach ($merch_images as $image_id) : ?>
                        <figure class="franchise-merch-polaroid">
                            <?php jullybride_franchise_image($image_id, '', 'Фирменный мерч Jully Bride'); ?>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="franchise-merch-carousel__arrow franchise-merch-carousel__arrow--next" type="button" aria-label="Следующий мерч" data-jb-merch-next></button>
        </div>

        <div class="franchise-merch-original__card">
            <div class="franchise-merch-original__content">
                <h3>Почему мерч<br>это круто для вас?</h3>
                <div class="franchise-merch-original__columns">
                    <div>
                        <h4>Узнаваемость</h4>
                        <p>Свитшот, шоппер, косметичка или термос с логотипом — это ежедневная реклама.</p>
                        <strong>Делает бренд ближе</strong>
                        <p>Создаёт комьюнити и помогает франчайзи выделяться на фоне конкурентов.</p>
                        <strong>Эмоции после покупки</strong>
                        <p>Стикерпак или бутылка для воды — и бренд остаётся с невестой даже после свадьбы.</p>
                    </div>
                    <div>
                        <h4>Вовлечение</h4>
                        <p>Красивый мерч → больше фото в соцсетях → бесплатный охват для салона!</p>
                        <strong>Дополнительный доход</strong>
                        <p>Девчонки реально хотят купить наши шопперы, термосы и косметички!</p>
                    </div>
                </div>
            </div>
            <?php jullybride_franchise_image(53107, 'franchise-merch-original__girl', ''); ?>
        </div>
    </div>
</section>

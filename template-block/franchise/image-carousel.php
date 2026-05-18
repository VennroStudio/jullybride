<?php
if (!defined('ABSPATH')) {
    exit;
}

$slides = [
    59021,
    59022,
    59023,
    59024,
];
?>
<section class="franchise-image-carousel" aria-label="Фотографии Jully Bride" style="--franchise-carousel-bg: url('<?php echo esc_url(jullybride_franchise_image_url(53075)); ?>');">
    <div class="franchise-image-carousel__inner">
        <button class="franchise-image-carousel__arrow franchise-image-carousel__arrow--prev" type="button" aria-label="Предыдущий слайд" data-jb-franchise-carousel-prev></button>
        <div class="franchise-image-carousel__viewport" data-jb-franchise-carousel>
            <div class="franchise-image-carousel__track">
                <?php foreach ($slides as $image_id) : ?>
                    <figure class="franchise-image-carousel__slide">
                        <?php jullybride_franchise_image($image_id, '', 'Jully Bride', 'full'); ?>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
        <button class="franchise-image-carousel__arrow franchise-image-carousel__arrow--next" type="button" aria-label="Следующий слайд" data-jb-franchise-carousel-next></button>
    </div>
</section>

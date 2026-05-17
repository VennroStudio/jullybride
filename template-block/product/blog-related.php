<?php
if (!defined('ABSPATH')) {
    exit;
}

$blog_posts = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 6,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>
<section class="blog-list">
    <div class="your-turn_righ_top">
        <img class="your-turn-svg2" src="<?php echo esc_url(jullybride_asset_uri('images/spletni.svg')); ?>" alt="">
        <ul>
            <li><a href="https://t.me/jullybridesalon"><img src="<?php echo esc_url(jullybride_asset_uri('images/link-telegram.svg')); ?>" alt=""></a></li>
            <li><a href="https://vk.com/jullybride"><img src="<?php echo esc_url(jullybride_asset_uri('images/link-vkontakte.svg')); ?>" alt=""></a></li>
            <li><a href="https://instagram.com/jullybride"><img src="<?php echo esc_url(jullybride_asset_uri('images/link-instagram.svg')); ?>" alt=""></a></li>
            <li><a href="https://www.youtube.com/channel/UCo_Zo2x9fyN19uuxkWO_v-g"><img src="<?php echo esc_url(jullybride_asset_uri('images/link-youtube.svg')); ?>" alt=""></a></li>
        </ul>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="section-subtitle d-block text-center">Советы стилистов</span>
                <h2 class="section-title text-center font-title">Немного полезностей</h2>
            </div>
        </div>
    </div>

    <?php if ($blog_posts->have_posts()) : ?>
        <ul class="owl-list blog-list_carusel owl-carousel owl-theme autoheight" id="blog-list_carusel">
            <?php while ($blog_posts->have_posts()) : ?>
                <?php $blog_posts->the_post(); ?>
                <li>
                    <div class="blog-list_img">
                        <?php
                        if (has_post_thumbnail()) {
                            echo get_the_post_thumbnail(get_the_ID(), 'blog_carousel', ['alt' => get_the_title()]);
                        }
                        ?>
                    </div>
                    <div class="blog-list_data">
                        <span><?php echo esc_html(get_the_title()); ?></span>
                    </div>
                    <div class="blog-list_meta d-flex">
                        <span><?php echo esc_html(get_the_date('d.m.Y')); ?></span>
                        <a href="<?php echo esc_url(get_permalink()); ?>">Читать статью</a>
                    </div>
                </li>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </ul>
    <?php else : ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    <div class="tabs-carusel_dot new-in-salon-carusel_dot reviews-carusel_dot d-none d-md-table">
        <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_prev custom_btn" id="blog-list_carusel_prev"></a>
        <a href="javascript:void(0)" class="tabs-carusel_nav tabs-carusel_next custom_btn" id="blog-list_carusel_next"></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center position-relative">
                <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="theme-button button-main custom_main_btn">читать больше</a>
            </div>
        </div>
    </div>
</section>

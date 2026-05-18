<?php
if (!defined('ABSPATH')) {
    exit;
}

$team = [
    ['image' => 59026, 'name' => 'Екатерина', 'role' => 'Операционный запуск'],
    ['image' => 59027, 'name' => 'Александра', 'role' => 'Маркетинг и контент'],
    ['image' => 59028, 'name' => 'Анастасия', 'role' => 'Команда и обучение'],
    ['image' => 53307, 'name' => 'Команда Jully Bride', 'role' => 'Поддержка открытия'],
    ['image' => 53310, 'name' => 'Каролина Ходакова', 'role' => 'Сервис и стандарты'],
    ['image' => 53313, 'name' => 'Команда проекта', 'role' => 'Сопровождение партнера'],
];
?>
<section id="franchise-team" class="franchise-team franchise-section">
    <div class="franchise-container">
        <div class="franchise-section-heading">
            <p class="franchise-eyebrow">Не один на старте</p>
            <h2>Пусковая команда</h2>
        </div>
        <div class="franchise-team__grid">
            <?php foreach ($team as $member) : ?>
                <article class="franchise-team-card">
                    <div class="franchise-team-card__image">
                        <?php jullybride_franchise_image($member['image'], '', $member['name']); ?>
                    </div>
                    <h3><?php echo esc_html($member['name']); ?></h3>
                    <p><?php echo esc_html($member['role']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

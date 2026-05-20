<?php
/**
 * Project post types.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'jullybride_register_project_post_types', 20);
function jullybride_register_project_post_types(): void
{
    if (!post_type_exists('promo')) {
        register_post_type('promo', [
            'labels' => [
                'name' => 'Акции',
                'singular_name' => 'Акция',
                'menu_name' => 'Акции',
                'name_admin_bar' => 'Акция',
                'add_new' => 'Добавить',
                'add_new_item' => 'Добавить акцию',
                'edit_item' => 'Изменить акцию',
                'new_item' => 'Новая акция',
                'view_item' => 'Посмотреть акцию',
                'view_items' => 'Посмотреть акции',
                'search_items' => 'Найти акции',
                'not_found' => 'Акции не найдены',
                'not_found_in_trash' => 'В корзине акций не найдено',
                'all_items' => 'Все акции',
                'archives' => 'Архив акций',
                'attributes' => 'Атрибуты акции',
                'insert_into_item' => 'Вставить в акцию',
                'uploaded_to_this_item' => 'Загружено для этой акции',
                'featured_image' => 'Изображение акции',
                'set_featured_image' => 'Задать изображение акции',
                'remove_featured_image' => 'Удалить изображение акции',
                'use_featured_image' => 'Использовать как изображение акции',
            ],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'exclude_from_search' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'has_archive' => false,
            'rewrite' => [
                'slug' => 'promo',
                'with_front' => true,
            ],
            'query_var' => true,
            'can_export' => false,
            'delete_with_user' => false,
            'menu_icon' => 'dashicons-money-alt',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        ]);
    }

    if (!post_type_exists('comanda')) {
        register_post_type('comanda', [
            'labels' => [
                'name' => 'Команда',
                'singular_name' => 'Команда',
                'menu_name' => 'Команда',
                'name_admin_bar' => 'Команда',
                'add_new' => 'Добавить',
                'add_new_item' => 'Добавить участника команды',
                'edit_item' => 'Изменить участника команды',
                'new_item' => 'Новый участник команды',
                'view_item' => 'Посмотреть участника команды',
                'view_items' => 'Посмотреть команду',
                'search_items' => 'Найти в команде',
                'not_found' => 'Участники команды не найдены',
                'not_found_in_trash' => 'В корзине участники команды не найдены',
                'all_items' => 'Вся команда',
                'archives' => 'Архив команды',
                'attributes' => 'Атрибуты участника команды',
                'insert_into_item' => 'Вставить в участника команды',
                'uploaded_to_this_item' => 'Загружено для этого участника',
                'featured_image' => 'Фото участника',
                'set_featured_image' => 'Задать фото участника',
                'remove_featured_image' => 'Удалить фото участника',
                'use_featured_image' => 'Использовать как фото участника',
            ],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'exclude_from_search' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'has_archive' => false,
            'rewrite' => [
                'slug' => 'comanda',
                'with_front' => true,
            ],
            'query_var' => true,
            'can_export' => false,
            'delete_with_user' => false,
            'menu_icon' => 'dashicons-groups',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'author', 'page-attributes'],
        ]);
    }
}

<?php
if (!defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('jullybride-site'); ?>>
<?php wp_body_open(); ?>
<?php
if (function_exists('jullybride_prime_acf_option_group')) {
    jullybride_prime_acf_option_group('header');
}
?>
<header class="jb-site-header" data-jb-header>
    <?php jullybride_template_part('header/top'); ?>
    <?php jullybride_template_part('header/brand'); ?>
    <?php jullybride_template_part('header/nav'); ?>
    <?php jullybride_template_part('header/mobile-menu'); ?>
</header>

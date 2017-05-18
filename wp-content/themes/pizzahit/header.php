<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <?php echo((gt3_get_theme_option("responsive") == "on") ? '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' : '');

        gt3_has_site_icon();
    ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php 
        wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
    <div class="wrapper">
	    <?php echo gt3_get_header(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        body {
            background-color: <?php echo esc_attr(get_theme_mod('pokemon_custom_bg', '#8890f8')); ?>;
            font-family: <?php echo esc_attr(get_theme_mod('pokemon_default_font', "'pokemon_emeraldregular', sans-serif")); ?>;
        }

        /* Estilos del skip link */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: #ffcb05;
            color: #111;
            padding: 8px 15px;
            z-index: 1000;
            text-decoration: none;
            font-weight: bold;
            transition: top 0.3s;
        }
        .skip-link:focus {
            top: 10px;
        }
    </style>
</head>
<body <?php body_class(); ?>>

<a href="#main-content" class="skip-link"><?php esc_html_e('Saltar al contenido principal', 'pokemon-theme'); ?></a>

<header class="frame-container">
    <div class="header-inner" style="text-align:center;">
        <h1 class="site-title"><?php bloginfo('name'); ?></h1>
        <p class="site-description"><?php bloginfo('description'); ?></p>
        
        <?php if (has_custom_logo()) : ?>
            <div class="site-logo">
                <?php the_custom_logo(); ?>
            </div>
        <?php endif; ?>

        <nav class="navbar">
            <ul class="navbar-ul">
                <?php
                if (has_nav_menu('header-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'depth' => 1
                    ));
                } else { ?>
                    <li><a href="<?php echo home_url(); ?>">Inicio</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>

<div id="theme-search-container" class="frame-container" style="display:none; text-align:center; margin:10px auto; max-width:400px;">
    <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
        <label>
            <input type="search" class="search-field" placeholder="<?php esc_attr_e('Buscar…', 'pokemon-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        </label>
        <button type="submit" class="search-submit"><?php esc_html_e('Buscar', 'pokemon-theme'); ?></button>
    </form>
</div>

<main id="main-content" class="content-area">








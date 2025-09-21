<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
    <style>
        body {
            background-color: <?php echo esc_attr(get_theme_mod('pokemon_bg_color', '#8890f8')); ?>;
            font-family: <?php echo esc_attr(get_theme_mod('pokemon_default_font', "'pokemon_emeraldregular', sans-serif")); ?>;
        }

        /* Nombre del sitio */
        .site-title a {
            color: <?php echo esc_attr(get_theme_mod('pokemon_site_title_color', '#111111')); ?>;
            text-decoration: none;
            transition: color 0.3s;
        }
        .site-title a:hover {
            color: #005fcc; /* accesible */
        }

        /* Skip link */
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

        header.frame-container {
            display: flex;
            justify-content: center;
            width: 100%;
            box-sizing: border-box;
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .site-branding {
            text-align: center;
        }

        .navbar-ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .navbar-ul li {
            position: relative;
            padding-left: 18px;
        }

        .navbar-ul li::before {
            content: "▶";
            position: absolute;
            left: 0;
            color: #ffcb05;
            font-size: 0.9rem;
        }

        .navbar-ul a {
            text-decoration: none;
            color: #111;
            font-weight: bold;
            transition: 0.2s;
        }

        .navbar-ul a:hover {
            color: #ffcb05;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-inner {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            .navbar-ul {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .header-inner {
                padding: 0 10px;
            }
        }
    </style>
</head>
<body <?php body_class(); ?>>

<a href="#main-content" class="skip-link"><?php esc_html_e('Saltar al contenido principal', 'pokemon-theme'); ?></a>

<header class="frame-container">
    <div class="header-inner">

        <?php if (has_custom_logo()) : ?>
            <div class="site-logo">
                <?php the_custom_logo(); ?>
            </div>
        <?php endif; ?>

        <div class="site-branding">
            <?php if (is_front_page() && is_home()) : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                </h1>
            <?php else : ?>
                <p class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                </p>
            <?php endif; ?>
            <p class="site-description"><?php bloginfo('description'); ?></p>
        </div>

        <nav class="navbar" role="navigation">
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

<div class="frame-container" style="max-width:400px; margin: 20px auto 0 auto;">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <label class="screen-reader-text" for="separate-search-field"><?php esc_html_e('Buscar en el sitio:', 'pokemon-theme'); ?></label>
        <input type="search" id="separate-search-field" class="search-field" placeholder="<?php esc_attr_e('Buscar…', 'pokemon-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit"><?php esc_html_e('Buscar', 'pokemon-theme'); ?></button>
    </form>
</div>

<main id="main-content" class="content-area">

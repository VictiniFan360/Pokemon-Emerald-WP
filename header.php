<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<a href="#main-content" class="skip-link"><?php esc_html_e('Saltar al contenido principal', 'pokemon-theme'); ?></a>

<header class="frame-container site-header">
    <div class="header-inner">

        <!-- === LOGO / TÍTULO DEL SITIO === -->
        <div class="site-branding">
            <?php if (get_theme_mod('custom_logo')) : ?>
                <!-- Logo tradicional de WordPress -->
                <div class="site-logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php else : ?>
                <!-- Logo como background accesible -->
                <?php if (is_front_page() && is_home()) : ?>
                    <h1 id="logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php else : ?>
                    <p id="logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </p>
                <?php endif; ?>
                <p class="site-description"><?php bloginfo('description'); ?></p>
            <?php endif; ?>
        </div>

        <!-- === MENÚ DE NAVEGACIÓN === -->
        <nav class="navbar" role="navigation" aria-label="<?php esc_attr_e('Menú principal', 'pokemon-theme'); ?>">
            <ul class="navbar-ul">
                <?php
                if (has_nav_menu('header-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'depth'          => 1,
                    ));
                } else { ?>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Inicio</a></li>
                <?php } ?>
            </ul>
        </nav>

    </div>
</header>

<!-- === BUSCADOR === -->
<div class="search-container">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <label class="screen-reader-text" for="separate-search-field"><?php esc_html_e('Buscar en el sitio:', 'pokemon-theme'); ?></label>
        <input type="search" id="separate-search-field" class="search-field" placeholder="<?php esc_attr_e('Buscar…', 'pokemon-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit"><?php esc_html_e('Buscar', 'pokemon-theme'); ?></button>
    </form>
</div>

<main id="main-content" class="content-area">
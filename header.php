<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<a href="#main-content" class="skip-link"><?php esc_html_e('Saltar al contenido principal', 'pokemon-theme'); ?></a>

<header class="frame-container">
    <div class="header-inner">

        <div class="site-branding">
            <h1 id="logo" class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
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

<div class="frame-container search-container">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <label class="screen-reader-text" for="separate-search-field"><?php esc_html_e('Buscar en el sitio:', 'pokemon-theme'); ?></label>
        <input type="search" id="separate-search-field" class="search-field" placeholder="<?php esc_attr_e('Buscar…', 'pokemon-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit"><?php esc_html_e('Buscar', 'pokemon-theme'); ?></button>
    </form>
</div>

<main id="main-content" class="content-area">
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
            <?php
            // Obtener ID y URL del logo
            $logo_id  = get_theme_mod('custom_logo');
            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
            $site_name = get_bloginfo('name');
            $logo_as_bg = get_theme_mod('pokemon_logo_as_bg', false);

            if ($logo_as_bg && $logo_url) {
                // Logo como background accesible
                if (is_front_page() && is_home()) {
                    echo '<h1 id="logo"><a href="' . esc_url(home_url('/')) . '" style="background-image:url(' . esc_url($logo_url) . ');" aria-label="' . esc_attr($site_name) . '">' . esc_html($site_name) . '</a></h1>';
                } else {
                    echo '<p id="logo"><a href="' . esc_url(home_url('/')) . '" style="background-image:url(' . esc_url($logo_url) . ');" aria-label="' . esc_attr($site_name) . '">' . esc_html($site_name) . '</a></p>';
                }
            } elseif ($logo_url) {
                // Logo tradicional con <img>
                if (is_front_page() && is_home()) {
                    echo '<h1 id="logo"><a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($logo_url) . '" alt="' . esc_attr($site_name) . '"></a></h1>';
                } else {
                    echo '<p id="logo"><a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($logo_url) . '" alt="' . esc_attr($site_name) . '"></a></p>';
                }
            } else {
                // Sin logo, solo texto
                if (is_front_page() && is_home()) {
                    echo '<h1 id="logo"><a href="' . esc_url(home_url('/')) . '">' . esc_html($site_name) . '</a></h1>';
                } else {
                    echo '<p id="logo"><a href="' . esc_url(home_url('/')) . '">' . esc_html($site_name) . '</a></p>';
                }
            }
            ?>
            <p class="site-description"><?php bloginfo('description'); ?></p>
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
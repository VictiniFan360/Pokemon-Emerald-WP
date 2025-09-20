<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    if (!function_exists('_wp_render_title_tag')) {
        function pokemon_custom_title() {
            echo '<title>';
            if (is_home() || is_front_page()) {
                bloginfo('name');
            } elseif (is_single() || is_page()) {
                wp_title('|', true, 'right');
                bloginfo('name');
            } elseif (is_archive()) {
                wp_title('', true, 'right');
                bloginfo('name');
            } else {
                bloginfo('name');
            }
            echo '</title>';
        }
        add_action('wp_head', 'pokemon_custom_title');
    }
    ?>

    <?php wp_head(); ?>
    <style>
        body {
            background-color: <?php echo esc_attr(get_theme_mod('pokemon_bg_color', '#8890f8')); ?>;
            font-family: <?php echo esc_attr(get_theme_mod('pokemon_default_font', "'pokemon_emeraldregular', sans-serif")); ?>;
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

        /* Screen reader text */
        .screen-reader-text {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0,0,0,0);
            white-space: nowrap;
            border: 0;
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

        .navbar-search {
            margin-left: 20px;
        }

        .navbar-search input[type="search"] {
            padding: 5px 8px;
            font-size: 0.9rem;
        }

        .navbar-search button {
            padding: 5px 10px;
            font-size: 0.9rem;
            cursor: pointer;
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
            .navbar-search {
                margin-left: 0;
                margin-top: 10px;
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
            <h1 class="site-title"><?php bloginfo('name'); ?></h1>
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

            <div class="navbar-search">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <label class="screen-reader-text" for="header-search-field"><?php esc_html_e('Buscar en el sitio:', 'pokemon-theme'); ?></label>
                    <input type="search" id="header-search-field" class="search-field" placeholder="<?php esc_attr_e('Buscar…', 'pokemon-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit" class="search-submit"><?php esc_html_e('Buscar', 'pokemon-theme'); ?></button>
                </form>
            </div>
        </nav>

    </div>
</header>

<main id="main-content" class="content-area">
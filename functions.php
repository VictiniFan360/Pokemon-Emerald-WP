<?php
/*
Theme Name: Pokémerald Theme
Theme URI: https://emerald.alejofernandez.es.ht
Author: Alejo Fernández
Author URI: https://emerald.alejofernandez.es.ht
Description: Tema con tipografía Pokémon Emerald y marcos personalizables para NavBar, Footer y contenido.
Version: 1.3
License: GPLv2 or later
Text Domain: pokemon-theme
*/

// Scripts y estilos
function pokemon_theme_scripts() {
    wp_register_script(
        'pokemon-frame',
        get_template_directory_uri() . '/js/frame.js',
        array(),
        '1.10',
        true
    );

    wp_localize_script('pokemon-frame', 'pokemonTheme', array(
        'templateUrl' => get_template_directory_uri(),
        'defaultFrame' => get_theme_mod('pokemon_default_frame', 1)
    ));

    wp_enqueue_script('pokemon-frame');
    wp_enqueue_style('pokemon-style', get_stylesheet_uri());
    wp_enqueue_style('pokemon-style-tablet', get_template_directory_uri() . '/style-tablet.css', array('pokemon-style'));
    wp_enqueue_style('pokemon-style-mobile', get_template_directory_uri() . '/style-mobile.css', array('pokemon-style'));
}
add_action('wp_enqueue_scripts', 'pokemon_theme_scripts');

// Menús
function pokemon_register_menus() {
    register_nav_menus(array(
        'header-menu' => __('Menú del Header', 'pokemon-theme'),
        'footer-menu' => __('Menú del Footer', 'pokemon-theme'),
    ));
}
add_action('after_setup_theme', 'pokemon_register_menus');

// Widgets Footer
function pokemon_register_footer_widgets() {
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'pokemon-theme'),
        'id' => 'footer-widget-area',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));

    // Sidebar derecha
    register_sidebar(array(
        'name' => __('Right Sidebar', 'pokemon-theme'),
        'id' => 'right-sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'pokemon_register_footer_widgets');

// Soporte logo
function pokemon_theme_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'pokemon_theme_setup');

// Personalizar colores, marco, tipografía y copyright
function pokemon_customize_register($wp_customize) {
    // Color de fondo
    $wp_customize->add_setting('pokemon_bg_color', array(
        'default' => '#8890f8',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'pokemon_bg_color_control',
        array(
            'label' => __('Color de Fondo', 'pokemon-theme'),
            'section' => 'colors',
            'settings' => 'pokemon_bg_color',
        )
    ));

    // Marco por defecto
    $wp_customize->add_setting('pokemon_default_frame', array(
        'default' => 1,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('pokemon_default_frame_control', array(
        'label' => __('Marco por defecto', 'pokemon-theme'),
        'section' => 'title_tagline',
        'settings' => 'pokemon_default_frame',
        'type' => 'select',
        'choices' => array_combine(range(1,10), array_map(fn($i)=>"Marco $i", range(1,10)))
    ));

    // Color de texto
    $wp_customize->add_setting('pokemon_default_text_color', array(
        'default' => '#111111',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'pokemon_default_text_color_control',
        array(
            'label' => __('Color de texto por defecto', 'pokemon-theme'),
            'section' => 'colors',
            'settings' => 'pokemon_default_text_color',
        )
    ));

    // Tipografía
    $wp_customize->add_setting('pokemon_default_font', array(
        'default' => "'pokemon_emeraldregular', sans-serif",
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('pokemon_default_font_control', array(
        'label' => __('Tipografía por defecto', 'pokemon-theme'),
        'section' => 'title_tagline',
        'settings' => 'pokemon_default_font',
        'type' => 'select',
        'choices' => array(
            "'pokemon_emeraldregular', sans-serif" => 'Pokémon Emerald',
            "Arial, sans-serif" => 'Arial',
            "Georgia, serif" => 'Georgia',
            "Courier New, monospace" => 'Courier New',
        )
    ));

    // Copyright
    $wp_customize->add_setting('pokemon_footer_text', array(
        'default' => 'Todos los derechos reservados',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pokemon_footer_text', array(
        'label' => __('Texto del copyright del footer', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'text',
    ));
}
add_action('customize_register', 'pokemon_customize_register');

// Inyectar estilos personalizados
function pokemon_customize_css() {
    ?>
    <style type="text/css">
        body {
            background-color: <?php echo get_theme_mod('pokemon_bg_color', '#8890f8'); ?>;
        }
        .frame-container {
            border-image-source: url("<?php echo get_template_directory_uri(); ?>/img/frame_<?php echo get_theme_mod('pokemon_default_frame', 1); ?>.png");
            color: <?php echo get_theme_mod('pokemon_default_text_color', '#111111'); ?>;
            font-family: <?php echo get_theme_mod('pokemon_default_font', "'pokemon_emeraldregular', sans-serif"); ?>;
        }
        @font-face {
            font-family: 'pokemon_emeraldregular';
            src: url('<?php echo get_template_directory_uri(); ?>/res/pokemon-emerald-webfont.eot');
            src: url('<?php echo get_template_directory_uri(); ?>/res/pokemon-emerald-webfont.eot?#iefix') format('embedded-opentype'),
                 url('<?php echo get_template_directory_uri(); ?>/res/pokemon-emerald-webfont.woff2') format('woff2'),
                 url('<?php echo get_template_directory_uri(); ?>/res/pokemon-emerald-webfont.woff') format('woff'),
                 url('<?php echo get_template_directory_uri(); ?>/res/pokemon-emerald-webfont.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
    <?php
}
add_action('wp_head', 'pokemon_customize_css');











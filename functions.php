<?php
/*
Theme Name: Pokémerald Theme
Theme URI: https://wpemerald.webs.nf
Author: Alejo Fernández
Author URI: https://alejofernandez.es.ht
Description: Tema con tipografía Pokémon Emerald y marcos personalizables para NavBar, Footer y contenido.
Version: 2.0
License: GPLv2 or later
Text Domain: pokemon-theme
*/

// ========================
// Soporte para logo y título
// ========================
function pokemon_theme_setup() {
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'pokemon_theme_setup');

// ========================
// Título personalizado en la página de inicio
// ========================
function pokemon_custom_document_title($title) {
    if (is_front_page() || is_home()) {
        $title['title'] = get_bloginfo('name') . ' - ' . get_bloginfo('description');
    }
    return $title;
}
add_filter('document_title_parts', 'pokemon_custom_document_title');

// ========================
// Menús
// ========================
function pokemon_register_menus() {
    register_nav_menus(array(
        'header-menu' => __('Menú del Header', 'pokemon-theme'),
        'footer-menu' => __('Menú del Footer', 'pokemon-theme'),
    ));
}
add_action('after_setup_theme', 'pokemon_register_menus');

// ========================
// Widgets
// ========================
function pokemon_register_footer_widgets() {
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'pokemon-theme'),
        'id' => 'footer-widget-area',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'pokemon_register_footer_widgets');

// ========================
// Scripts y estilos
// ========================
function pokemon_theme_scripts() {
    wp_enqueue_style('pokemon-style', get_stylesheet_uri());
    wp_enqueue_style('pokemon-style-tablet', get_template_directory_uri() . '/style-tablet.css', array('pokemon-style'));
    wp_enqueue_style('pokemon-style-mobile', get_template_directory_uri() . '/style-mobile.css', array('pokemon-style'));

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
}
add_action('wp_enqueue_scripts', 'pokemon_theme_scripts');

// ========================
// Sanitización
// ========================
function sanitize_frame_choice($input) {
    $input = absint($input);
    return ($input >= 1 && $input <= 10) ? $input : 1;
}

// ========================
// Customizer
// ========================
function pokemon_customize_register($wp_customize) {
    // Marco predeterminado
    $wp_customize->add_setting('pokemon_default_frame', array(
        'default' => 1,
        'sanitize_callback' => 'sanitize_frame_choice',
    ));
    $wp_customize->add_control('pokemon_default_frame', array(
        'label' => __('Marco por defecto', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'select',
        'choices' => array_combine(range(1, 10), array_map(fn($i) => "Marco $i", range(1, 10))),
    ));

    // Color de fondo
    $wp_customize->add_setting('pokemon_bg_color', array(
        'default' => '#f8f8f8',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
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

    // Imagen de fondo
    $wp_customize->add_setting('pokemon_bg_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'pokemon_bg_image_control',
        array(
            'label' => __('Imagen de fondo (opcional)', 'pokemon-theme'),
            'section' => 'colors',
            'settings' => 'pokemon_bg_image',
        )
    ));

    // Colores
    $wp_customize->add_setting('pokemon_default_text_color', array(
        'default' => '#111111',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'pokemon_default_text_color_control',
        array(
            'label' => __('Color de texto', 'pokemon-theme'),
            'section' => 'colors',
            'settings' => 'pokemon_default_text_color',
        )
    ));

    $wp_customize->add_setting('pokemon_site_title_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'pokemon_site_title_color_control',
        array(
            'label' => __('Color del nombre del sitio', 'pokemon-theme'),
            'section' => 'colors',
            'settings' => 'pokemon_site_title_color',
        )
    ));

    $wp_customize->add_setting('pokemon_site_title_hover_color', array(
        'default' => '#003366',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'pokemon_site_title_hover_color_control',
        array(
            'label' => __('Color del hover del nombre del sitio', 'pokemon-theme'),
            'section' => 'colors',
            'settings' => 'pokemon_site_title_hover_color',
        )
    ));

    // Tipografía
    $wp_customize->add_setting('pokemon_default_font', array(
        'default' => "'pokemon_emeraldregular', sans-serif",
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pokemon_default_font_control', array(
        'label' => __('Tipografía por defecto', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'select',
        'choices' => array(
            "'pokemon_emeraldregular', sans-serif" => 'Pokémon Emerald',
            "Arial, sans-serif" => 'Arial',
            "Georgia, serif" => 'Georgia',
            "Courier New, monospace" => 'Courier New',
        ),
    ));

    // Año inicial
    $wp_customize->add_setting('pokemon_footer_start_year', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('pokemon_footer_start_year', array(
        'label'       => __('Año inicial del copyright (opcional)', 'pokemon-theme'),
        'section'     => 'title_tagline',
        'type'        => 'number',
        'input_attrs' => array('min' => 2000, 'max' => date('Y')),
    ));

    // Texto del footer
    $wp_customize->add_setting('pokemon_footer_text', array(
        'default' => 'Todos los derechos reservados',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pokemon_footer_text', array(
        'label' => __('Texto del footer', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'text',
    ));

    // Modo logo (nuevo)
    $wp_customize->add_setting('pokemon_logo_display_mode', array(
        'default'           => 'background',
        'sanitize_callback' => function($input) {
            $valid = array('image', 'background');
            return in_array($input, $valid) ? $input : 'background';
        },
    ));
    $wp_customize->add_control('pokemon_logo_display_mode_control', array(
        'label'       => __('Modo de visualización del logotipo', 'pokemon-theme'),
        'description' => __('Elegí si el logotipo se muestra como imagen o como fondo del título.', 'pokemon-theme'),
        'section'     => 'title_tagline',
        'type'        => 'select',
        'choices'     => array(
            'image'      => __('Mostrar como imagen (the_custom_logo)', 'pokemon-theme'),
            'background' => __('Usar como fondo del título (recomendado)', 'pokemon-theme'),
        ),
    ));
}
add_action('customize_register', 'pokemon_customize_register');
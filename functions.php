<?php
// ============================
// Pokémemerald Theme Functions
// ============================

// Cargar scripts y estilos
function pokemon_theme_scripts() {
    wp_enqueue_style('pokemon-style', get_stylesheet_uri(), array(), '1.0');
}
add_action('wp_enqueue_scripts', 'pokemon_theme_scripts');

// Soporte para logo personalizado, título, etc.
function pokemon_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'header-menu' => __('Menú principal', 'pokemon-theme'),
    ));
}
add_action('after_setup_theme', 'pokemon_theme_setup');

// ============================
// Customizer: Colores y Logo
// ============================
function pokemon_customize_register($wp_customize) {

    // Color de fondo del sitio
    $wp_customize->add_setting('pokemon_bg_color', array(
        'default' => '#f8f8f8',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pokemon_bg_color', array(
        'label' => __('Color de fondo del sitio', 'pokemon-theme'),
        'section' => 'colors',
    )));

    // Modo del logo (imagen o background)
    $wp_customize->add_setting('pokemon_logo_display_mode', array(
        'default' => 'background',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('pokemon_logo_display_mode', array(
        'label' => __('Modo de logotipo', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'radio',
        'choices' => array(
            'image' => __('Usar como imagen', 'pokemon-theme'),
            'background' => __('Usar como fondo', 'pokemon-theme'),
        ),
    ));

    // Año de inicio del footer
    $wp_customize->add_setting('pokemon_start_year', array(
        'default' => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('pokemon_start_year', array(
        'label' => __('Año de inicio del sitio (opcional)', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'text',
    ));
}
add_action('customize_register', 'pokemon_customize_register');

// ============================
// Estilos dinámicos: fondo y logo
// ============================
function pokemon_custom_dynamic_styles() {
    $bg_color = get_theme_mod('pokemon_bg_color', '#f8f8f8');
    $logo_mode = get_theme_mod('pokemon_logo_display_mode', 'background');

    echo '<style>
    body { background-color: ' . esc_attr($bg_color) . '; }';

    if ($logo_mode === 'background' && has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
        if ($logo_url) {
            echo '
            #logo a {
                background-image: url("' . esc_url($logo_url) . '");
                background-repeat: no-repeat;
                background-size: contain;
                background-position: center;
                display: inline-block;
                width: 190px;
                height: 85px;
                font-size: 0;
                text-indent: -9999px;
            }';
        }
    }

    echo '</style>';
}
add_action('wp_head', 'pokemon_custom_dynamic_styles');
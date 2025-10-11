<?php
/*
Theme Name: Pokémerald Theme
Theme URI: https://wpemerald.webs.nf
Author: Alejo Fernández
Author URI: https://alejofernandez.es.ht
Description: Tema con tipografía Pokémon Emerald, marcos personalizables, navbar, sidebar, footer y accesibilidad aumentada.
Version: 2.2.2
License: GPLv2 or later
Text Domain: pokemon-theme
*/

// ========================
// SOPORTE BÁSICO DEL TEMA
// ========================
function pokemon_theme_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));
    add_theme_support('title-tag');
    add_theme_support('custom-background');

    register_nav_menus(array(
        'header-menu' => __('Menú del Header', 'pokemon-theme'),
        'footer-menu' => __('Menú del Footer', 'pokemon-theme'),
    ));
}
add_action('after_setup_theme', 'pokemon_theme_setup');

// ========================
// WIDGETS
// ========================
function pokemon_register_widgets() {
    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'pokemon-theme'),
        'id'            => 'footer-widget-area',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
    register_sidebar(array(
        'name'          => __('Right Sidebar', 'pokemon-theme'),
        'id'            => 'right-sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'pokemon_register_widgets');

// ========================
// SCRIPTS Y ESTILOS
// ========================
function pokemon_theme_scripts() {
    wp_enqueue_style('pokemon-style', get_stylesheet_uri());

    wp_register_script(
        'pokemon-frame',
        get_template_directory_uri() . '/js/frame.js',
        array(),
        '2.2',
        true
    );

    wp_localize_script('pokemon-frame', 'pokemonTheme', array(
        'templateUrl'   => get_template_directory_uri(),
        'defaultFrame'  => get_theme_mod('pokemon_default_frame', 1),
        'accessibility' => get_theme_mod('pokemon_accessibility_mode', false)
    ));

    wp_enqueue_script('pokemon-frame');
}
add_action('wp_enqueue_scripts', 'pokemon_theme_scripts');

// ========================
// SANITIZACIÓN
// ========================
function sanitize_frame_choice($input) {
    $input = absint($input);
    return ($input >= 1 && $input <= 10) ? $input : 1;
}

// ========================
// PERSONALIZADOR (CUSTOMIZER)
// ========================
function pokemon_customize_register($wp_customize) {

    // Marco predeterminado
    $wp_customize->add_setting('pokemon_default_frame', array(
        'default'           => 1,
        'sanitize_callback' => 'sanitize_frame_choice',
    ));
    $wp_customize->add_control('pokemon_default_frame', array(
        'label'    => __('Marco por defecto', 'pokemon-theme'),
        'section'  => 'title_tagline',
        'type'     => 'select',
        'choices'  => array_combine(range(1, 10), array_map(fn($i) => "Marco $i", range(1, 10))),
    ));

    // Tipografía por defecto
    $wp_customize->add_setting('pokemon_default_font', array(
        'default'           => "'pokemon_emeraldregular', sans-serif",
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pokemon_default_font_control', array(
        'label'    => __('Tipografía por defecto', 'pokemon-theme'),
        'section'  => 'title_tagline',
        'type'     => 'select',
        'choices'  => array(
            "'pokemon_emeraldregular', sans-serif" => 'Pokémon Emerald',
            "Arial, sans-serif"                    => 'Arial',
            "Georgia, serif"                       => 'Georgia',
            "Courier New, monospace"               => 'Courier New',
        ),
    ));

    // Color de fondo
    $wp_customize->add_setting('pokemon_bg_color', array(
        'default'           => '#f8f8f8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'pokemon_bg_color_control',
        array(
            'label'    => __('Color de Fondo', 'pokemon-theme'),
            'section'  => 'colors',
            'settings' => 'pokemon_bg_color',
        )
    ));

    // Accesibilidad aumentada
    $wp_customize->add_setting('pokemon_accessibility_mode', array(
        'default'           => false,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('pokemon_accessibility_mode', array(
        'label'       => __('Activar modo de accesibilidad aumentada', 'pokemon-theme'),
        'description' => __('Muestra enlaces en azul y rectángulos punteados al enfocar.', 'pokemon-theme'),
        'section'     => 'title_tagline',
        'type'        => 'checkbox',
    ));

    // Opción de logo como background
    $wp_customize->add_setting('pokemon_logo_as_bg', array(
        'default'           => false,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('pokemon_logo_as_bg', array(
        'label'       => __('Usar logo como background', 'pokemon-theme'),
        'description' => __('Si está activado, el logo se mostrará como background en lugar de imagen <img>.'),
        'section'     => 'title_tagline',
        'type'        => 'checkbox',
    ));
}
add_action('customize_register', 'pokemon_customize_register');

// ========================
// FUNCIÓN PARA IMPRIMIR EL LOGO
// ========================
function pokemon_the_logo() {
    $logo_id   = get_theme_mod('custom_logo');
    $logo_url  = wp_get_attachment_image_url($logo_id, 'full');
    $site_name = get_bloginfo('name');

    if (get_theme_mod('pokemon_logo_as_bg', false) && $logo_url) {
        echo '<div id="logo"><a href="' . esc_url(home_url('/')) . '" style="background-image:url(' . esc_url($logo_url) . ');" aria-label="' . esc_attr($site_name) . '"></a></div>';
    } elseif ($logo_url) {
        echo '<div id="logo"><a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($logo_url) . '" alt="' . esc_attr($site_name) . '"></a></div>';
    } else {
        echo '<div id="logo"><a href="' . esc_url(home_url('/')) . '">' . esc_html($site_name) . '</a></div>';
    }
}

// ========================
// CSS DINÁMICO
// ========================
function pokemon_dynamic_css() {
    $bg_color   = get_theme_mod('pokemon_bg_color', '#f8f8f8');
    $font       = get_theme_mod('pokemon_default_font', "'pokemon_emeraldregular', sans-serif");
    $frame      = absint(get_theme_mod('pokemon_default_frame', 1));
    $accessible = get_theme_mod('pokemon_accessibility_mode', false);
    ?>
    <style>
        body {
            background-color: <?php echo esc_attr($bg_color); ?>;
            font-family: <?php echo esc_attr($font); ?>;
        }

        .frame-container {
            border-image-source: url('<?php echo get_template_directory_uri(); ?>/img/frame_<?php echo $frame; ?>.png');
        }

        <?php if ($accessible): ?>
        a {
            color: #0056b3 !important;
            text-decoration: underline !important;
        }
        a:focus,
        button:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px dotted #005A9C !important;
            outline-offset: 3px;
            background-color: transparent !important;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'pokemon_dynamic_css');
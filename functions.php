<?php
/**
 * Funciones principales del tema Pokémerald
 * Versión 2.2.6
 */

if (!defined('ABSPATH')) exit; // Seguridad

/* === SOPORTE DEL TEMA === */
function pokemon_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_theme_support('custom-logo', array(
        'height'      => 85,
        'width'       => 190,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    add_theme_support('custom-background', array(
        'default-color' => '#f8f8f8',
    ));

    add_theme_support('customize-selective-refresh-widgets');

    register_nav_menus(array(
        'header-menu' => __('Menú principal', 'pokemon-theme'),
    ));
}
add_action('after_setup_theme', 'pokemon_theme_setup');


/* === WIDGETS === */
function pokemon_register_widgets() {
    register_sidebar(array(
        'name'          => __('Área de widgets del footer', 'pokemon-theme'),
        'id'            => 'footer-widget-area',
        'description'   => __('Widgets que aparecerán en el pie de página.', 'pokemon-theme'),
        'before_widget' => '<div class="widget frame-container">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'pokemon_register_widgets');


/* === ENCOLAR ESTILOS Y SCRIPTS === */
function pokemon_theme_scripts() {
    wp_enqueue_style('pokemon-style', get_stylesheet_uri(), array(), '2.2.6');
    wp_enqueue_script('pokemon-scripts', get_template_directory_uri() . '/js/pokemon.js', array('jquery'), '2.2.6', true);
}
add_action('wp_enqueue_scripts', 'pokemon_theme_scripts');


/* === FUENTE PERSONALIZADA (Pokémon Emerald Regular) === */
function pokemon_enqueue_fonts() {
    $font_path = get_template_directory_uri() . '/res/pokemon-emerald-webfont/';
    $custom_css = "
        @font-face {
            font-family: 'pokemon_emeraldregular';
            src: url('{$font_path}pokemon_emeraldregular.eot');
            src: url('{$font_path}pokemon_emeraldregular.eot?#iefix') format('embedded-opentype'),
                 url('{$font_path}pokemon_emeraldregular.woff2') format('woff2'),
                 url('{$font_path}pokemon_emeraldregular.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        body {
            font-family: 'pokemon_emeraldregular', sans-serif;
        }
    ";
    wp_add_inline_style('pokemon-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'pokemon_enqueue_fonts');


// ========================
// PERSONALIZADOR (CUSTOMIZER)
// ========================
function pokemon_customize_register($wp_customize) {

    // Sección: Apariencia general
    $wp_customize->add_section('pokemon_general_section', array(
        'title'       => __('Apariencia general', 'pokemon-theme'),
        'priority'    => 30,
        'description' => __('Configura colores, fuente, marco y accesibilidad.', 'pokemon-theme'),
    ));

    // Fondo del sitio
    $wp_customize->add_setting('pokemon_bg_color', array(
        'default'           => '#f8f8f8',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pokemon_bg_color_control', array(
        'label'    => __('Color de fondo del sitio', 'pokemon-theme'),
        'section'  => 'pokemon_general_section',
        'settings' => 'pokemon_bg_color',
    )));

    // Fondo del footer
    $wp_customize->add_setting('pokemon_footer_bg', array(
        'default'           => '#f8f8f8',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'pokemon_footer_bg_control', array(
        'label'    => __('Color de fondo del footer (si no hay imagen)', 'pokemon-theme'),
        'section'  => 'pokemon_general_section',
        'settings' => 'pokemon_footer_bg',
    )));

    // Tipografía
    $wp_customize->add_setting('pokemon_font_family', array(
        'default'           => "'pokemon_emeraldregular', sans-serif",
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pokemon_font_family_control', array(
        'label'    => __('Tipografía del sitio', 'pokemon-theme'),
        'section'  => 'pokemon_general_section',
        'settings' => 'pokemon_font_family',
        'type'     => 'select',
        'choices'  => array(
            "'pokemon_emeraldregular', sans-serif" => 'Pokémon Emerald',
            'Arial, sans-serif' => 'Arial',
            'Georgia, serif' => 'Georgia',
            '"Courier New", monospace' => 'Courier New',
        ),
    ));

    // Marco
    $wp_customize->add_setting('pokemon_frame_style', array(
        'default'           => 1,
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('pokemon_frame_style_control', array(
        'label'    => __('Marco decorativo', 'pokemon-theme'),
        'section'  => 'pokemon_general_section',
        'settings' => 'pokemon_frame_style',
        'type'     => 'select',
        'choices'  => array_combine(range(1,10), array_map(fn($i) => "Marco $i", range(1,10))),
    ));

    // Modo accesibilidad
    $wp_customize->add_setting('pokemon_accessibility_mode', array(
        'default'           => false,
        'transport'         => 'refresh',
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('pokemon_accessibility_mode_control', array(
        'label'    => __('Activar modo accesibilidad', 'pokemon-theme'),
        'section'  => 'pokemon_general_section',
        'settings' => 'pokemon_accessibility_mode',
        'type'     => 'checkbox',
    ));

    // Texto y año del footer
    $wp_customize->add_setting('pokemon_footer_text', array(
        'default'   => __('Todos los derechos reservados', 'pokemon-theme'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('pokemon_footer_text_control', array(
        'label'    => __('Texto del pie de página', 'pokemon-theme'),
        'section'  => 'title_tagline',
        'settings' => 'pokemon_footer_text',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('pokemon_footer_start_year', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('pokemon_footer_start_year_control', array(
        'label'    => __('Año inicial del pie de página', 'pokemon-theme'),
        'section'  => 'title_tagline',
        'settings' => 'pokemon_footer_start_year',
        'type'     => 'number',
    ));

    // Logo como background
    $wp_customize->add_setting('pokemon_logo_as_bg', array(
        'default'   => false,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('pokemon_logo_as_bg_control', array(
        'label'       => __('Usar logo como fondo accesible', 'pokemon-theme'),
        'description' => __('Si se activa, el logo se mostrará como background del título del sitio manteniendo texto accesible.'),
        'section'     => 'title_tagline',
        'settings'    => 'pokemon_logo_as_bg',
        'type'        => 'checkbox',
    ));
}
add_action('customize_register', 'pokemon_customize_register');

/* === COLOR DEL FOOTER (SI NO HAY IMAGEN DE FONDO) === */
function pokemon_footer_inline_style() {
    $footer_bg_color = get_theme_mod('pokemon_footer_bg_color', '#f8f8f8');
    $background_image = get_background_image();

    if (!$background_image) {
        echo "<style>footer.frame-container { background-color: " . esc_attr($footer_bg_color) . "; }</style>";
    }
}
add_action('wp_head', 'pokemon_footer_inline_style');


/* ========================
   FUNCIÓN LOGO
   ======================== */
function pokemon_the_logo() {
    $logo_id   = get_theme_mod('custom_logo');
    $logo_url  = wp_get_attachment_image_url($logo_id, 'full');
    $site_name = get_bloginfo('name');

    if (get_theme_mod('pokemon_logo_as_bg', false) && $logo_url) {
        echo '<h1 id="logo"><a href="' . esc_url(home_url('/')) . '" style="background-image:url(' . esc_url($logo_url) . ');" aria-label="' . esc_attr($site_name) . '">' . esc_html($site_name) . '</a></h1>';
    } elseif ($logo_url) {
        echo '<h1 id="logo"><a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($logo_url) . '" alt="' . esc_attr($site_name) . '"></a></h1>';
    } else {
        echo '<h1 id="logo"><a href="' . esc_url(home_url('/')) . '">' . esc_html($site_name) . '</a></h1>';
    }
}

// ========================
// ESTILOS DINÁMICOS EN HEAD
// ========================
function pokemon_dynamic_styles() {
    // Valores del personalizador (o defaults si no hay)
    $bg_color        = get_theme_mod('pokemon_bg_color', '#f8f8f8');
    $footer_bg       = get_theme_mod('pokemon_footer_bg', '#f8f8f8');
    $font            = get_theme_mod('pokemon_font_family', "'pokemon_emeraldregular', sans-serif");
    $frame           = get_theme_mod('pokemon_frame_style', 1);
    $accessible      = get_theme_mod('pokemon_accessibility_mode', false);
    $background_image = get_background_image();

    ?>
    <style>
        body {
            background-color: <?php echo esc_attr($bg_color); ?>;
            font-family: <?php echo esc_attr($font); ?>;
        }

        .frame-container {
            border-image-source: url('<?php echo esc_url(get_template_directory_uri()); ?>/img/frame_<?php echo intval($frame); ?>.png');
        }

        <?php if (!$background_image): ?>
        footer.frame-container {
            background-color: <?php echo esc_attr($footer_bg); ?>;
        }
        <?php endif; ?>

        <?php if ($accessible): ?>
        a {
            color: #0056b3 !important;
            text-decoration: underline !important;
        }

        a:focus,
        a:hover,
        button:focus,
        button:hover,
        input:focus,
        input:hover,
        select:focus,
        select:hover,
        textarea:focus,
        textarea:hover {
            outline: 2px solid #007BFF !important;
            outline-offset: 2px;
            background-color: rgba(0, 123, 255, 0.1);
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'pokemon_dynamic_styles');


?>


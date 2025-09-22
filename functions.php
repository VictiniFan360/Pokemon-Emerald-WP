<?php
/*
Theme Name: Pokémerald Theme
Theme URI: https://wpemerald.webs.nf
Author: Alejo Fernández
Author URI: https://alejofernandez.es.ht
Description: Tema con tipografía Pokémon Emerald y marcos personalizables para NavBar, Footer y contenido.
Version: 1.7
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

// Personalizar título en la página de inicio
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
        'choices' => array(
            1 => 'Marco 1',
            2 => 'Marco 2',
            3 => 'Marco 3',
            4 => 'Marco 4',
            5 => 'Marco 5',
            6 => 'Marco 6',
            7 => 'Marco 7',
            8 => 'Marco 8',
            9 => 'Marco 9',
            10 => 'Marco 10',
        ),
    ));

    // Color de fondo
    $wp_customize->add_setting('pokemon_bg_color', array(
        'default' => '#8890f8',
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

    // Imagen de fondo opcional
    $wp_customize->add_setting('pokemon_bg_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'pokemon_bg_image_control',
        array(
            'label'       => __('Imagen de fondo de la página', 'pokemon-theme'),
            'section'     => 'colors',
            'settings'    => 'pokemon_bg_image',
            'description' => __('Sube una imagen opcional para el fondo de la página (PNG o WebP).', 'pokemon-theme'),
            'mime_type'   => 'image',
        )
    ));

    // Color de texto general
    $wp_customize->add_setting('pokemon_default_text_color', array(
        'default' => '#111111',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
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

    // Color del nombre del sitio
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

    // Color del hover del nombre del sitio
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
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pokemon_default_font_control', array(
        'label' => __('Tipografía por defecto', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'select',
        'settings' => 'pokemon_default_font',
        'choices' => array(
            "'pokemon_emeraldregular', sans-serif" => 'Pokémon Emerald',
            "Arial, sans-serif" => 'Arial',
            "Georgia, serif" => 'Georgia',
            "Courier New, monospace" => 'Courier New',
        ),
    ));

    // Texto de copyright
    $wp_customize->add_setting('pokemon_footer_text', array(
        'default' => 'Todos los derechos reservados',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pokemon_footer_text', array(
        'label' => __('Texto del copyright del footer', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'text',
    ));

    // Accesibilidad (opcional)
    $wp_customize->add_setting('pokemon_accessibility_mode', array(
        'default' => false,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    $wp_customize->add_control('pokemon_accessibility_mode', array(
        'label' => __('Activar modo de accesibilidad (mejor enfoque en enlaces)', 'pokemon-theme'),
        'section' => 'title_tagline',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'pokemon_customize_register');

// ========================
// CSS personalizado
// ========================
function pokemon_customize_css() {
    ?>
<style type="text/css">
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

    body {
        background-color: <?php echo esc_attr(get_theme_mod('pokemon_bg_color', '#8890f8')); ?>;
        <?php if (get_theme_mod('pokemon_bg_image')) : ?>
            background-image: url('<?php echo esc_url(get_theme_mod('pokemon_bg_image')); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        <?php endif; ?>
        font-family: <?php echo esc_attr(get_theme_mod('pokemon_default_font', "'pokemon_emeraldregular', sans-serif")); ?>;
        color: <?php echo esc_attr(get_theme_mod('pokemon_default_text_color', '#111111')); ?>;
    }

    .frame-container {
        border-image-source: none;
        display: block;
        padding: 20px;
        margin: 20px auto;
        border: 30px solid transparent;
        border-image-slice: 15;
        border-image-repeat: repeat repeat;
        border-image-width: 30px;
        border-image-outset: 0;
        background-color: #f8f8f8;
        max-width: 800px;
        width: 90%;
        box-sizing: border-box;
    }

    .site-title a {
        color: <?php echo esc_attr(get_theme_mod('pokemon_site_title_color', '#000000')); ?>;
        text-decoration: none;
        transition: color 0.3s;
    }
    .site-title a:hover {
        color: <?php echo esc_attr(get_theme_mod('pokemon_site_title_hover_color', '#003366')); ?>;
    }

    /* Botón "Leer más" personalizado */
    .more-link {
        display: inline-block;
        background: none !important;
        border: none !important;
        padding: 0;
        margin-top: 10px;
        font-weight: bold;
        font-size: 1rem;
        color: #0056cc;
        text-decoration: none;
    }
    .more-link:hover,
    .more-link:focus {
        color: #003399;
        text-decoration: underline;
    }
    .more-link::before {
        content: ">>";
        margin-right: 5px;
    }

    a:hover::before,
    a:focus::before,
    a:active::before {
        color: #005fcc;
    }

    a:hover,
    a:focus,
    a:active {
        color: #005fcc;
        outline: none;
    }

    <?php if (get_theme_mod('pokemon_accessibility_mode', false)) : ?>
    a:hover,
    a:focus {
        outline: 2px dotted #005A9C;
        outline-offset: 3px;
        background-color: transparent;
        color: #0011ff !important;
    }
    a:hover::before,
    a:focus::before {
        color: #0011ff !important;
    }
    <?php endif; ?>
</style>
    <?php
}
add_action('wp_head', 'pokemon_customize_css');
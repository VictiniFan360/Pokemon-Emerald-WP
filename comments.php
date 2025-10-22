<?php
/**
 * comments.php - Pokémerald theme
 */

if ( post_password_required() ) {
    return;
}

// Si otro template ya imprimió el form (flag global), lo detectamos.
global $pokemon_comment_form_rendered;
if ( empty( $pokemon_comment_form_rendered ) ) {
    $comment_form_already_shown = false;
} else {
    $comment_form_already_shown = true;
}
?>

<div id="comments" class="comments-area frame-container">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $count = get_comments_number();
            if ( $count === 1 ) {
                echo esc_html__( 'Un comentario', 'pokemon-theme' );
            } else {
                printf( esc_html__( '%s comentarios', 'pokemon-theme' ), number_format_i18n( $count ) );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 64,
                'callback'   => 'pokemon_comment_format_with_meta',
            ) );
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php
    // Si el formulario no se mostró antes, lo mostramos aquí.
    if ( ! $comment_form_already_shown && ( comments_open() || get_comments_number() ) ) {
        comment_form();
        // comment_form() disparará comment_form_before y marcará la global en el plugin.
    } elseif ( $comment_form_already_shown ) {
        // Si ya se mostró en otro sitio, imprimimos solo un pequeño enlace para "Ir al formulario"
        if ( comments_open() ) {
            echo '<p class="comment-form-link-note"><a href="#respond">' . esc_html__( 'Ir al formulario de comentarios', 'pokemon-theme' ) . '</a></p>';
        }
    }
    ?>

</div><!-- .comments-area -->

<?php
// Callback para renderizado de cada comentario aplicando estilos desde comment meta
function pokemon_comment_format_with_meta( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

    $frame = get_comment_meta( $comment->comment_ID, 'pokemon_frame_choice', true );
    $italic = get_comment_meta( $comment->comment_ID, 'pokemon_font_italic', true );
    $color = get_comment_meta( $comment->comment_ID, 'pokemon_text_color', true );
    $emo = get_comment_meta( $comment->comment_ID, 'pokemon_selected_emoticon', true );

    // Generamos clases y estilos
    $classes = 'single-comment';
    if ( $frame && intval($frame) > 0 ) {
        $classes .= ' comment-frame-' . intval($frame);
    }
    $style = '';
    if ( $color ) {
        $style .= 'color: ' . esc_attr( $color ) . ';';
    }
    if ( $italic ) {
        $style .= 'font-style: italic;';
    }

    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $classes ); ?> style="<?php echo esc_attr( $style ); ?>">
        <div class="comment-avatar">
            <?php echo get_avatar( $comment, 64 ); ?>
        </div>

        <div class="comment-body">
            <div class="comment-meta">
                <span class="comment-author"><?php echo get_comment_author_link(); ?></span>
                <span class="comment-date"><?php echo get_comment_date(); ?></span>
            </div>

            <div class="comment-text">
                <?php
                // Si hay emoticono seleccionado, lo mostramos en la cabecera del comentario
                if ( $emo ) {
                    echo '<span class="comment-emo" aria-hidden="true"> ' . esc_html( $emo ) . ' </span>';
                }
                comment_text();
                ?>
            </div>

            <div class="comment-actions">
                <?php comment_reply_link( array_merge( $args, array(
                    'reply_text' => __( 'Responder', 'pokemon-theme' ),
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth'],
                ) ) ); ?>
            </div>
        </div>
    </<?php echo $tag; ?>>
    <?php
}
?>
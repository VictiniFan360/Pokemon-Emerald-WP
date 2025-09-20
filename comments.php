<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area frame-container">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ( 1 === $comments_number ) {
                printf( esc_html__( 'Un comentario en &ldquo;%s&rdquo;', 'pokemon-theme' ), get_the_title() );
            } else {
                printf(
                    esc_html( _nx( '%1$s comentario en &ldquo;%2$s&rdquo;', '%1$s comentarios en &ldquo;%2$s&rdquo;', $comments_number, 'comments title', 'pokemon-theme' ) ),
                    number_format_i18n( $comments_number ),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 48,
                'callback'   => 'pokemon_comment_callback',
            ) );
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php
    comment_form( array(
        'class_form' => 'comment-form frame-container',
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h3>',
    ) );
    ?>

</div><!-- #comments -->

<?php
// Callback para mostrar cada comentario dentro de un frame
function pokemon_comment_callback( $comment, $args, $depth ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> <?php comment_class('frame-container'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
            <div class="comment-author vcard">
                <?php if ( get_avatar( $comment, 48 ) ) : ?>
                    <?php echo get_avatar( $comment, 48 ); ?>
                <?php endif; ?>
                <?php printf( '<b class="fn">%s</b>', get_comment_author_link() ); ?>
            </div>
            <div class="comment-meta commentmetadata">
                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                    <?php printf( esc_html__( '%1$s a las %2$s', 'pokemon-theme' ), get_comment_date(), get_comment_time() ); ?>
                </a>
                <?php edit_comment_link( esc_html__( '(Editar)', 'pokemon-theme' ), '  ', '' ); ?>
            </div>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array(
                    'add_below' => 'comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth']
                ) ) ); ?>
            </div>
        </div>
    <?php
}
?>

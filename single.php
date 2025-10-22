<?php
/**
 * Template para mostrar entradas individuales
 * Tema: Pokémerald
 */

get_header(); ?>

<main id="main" class="site-main frame-container">

<?php
if (have_posts()) :
    while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <p class="entry-meta">
                    <?php
                    printf(
                        __('Publicado el %1$s por %2$s', 'pokemon-theme'),
                        get_the_date(),
                        get_the_author()
                    );
                    ?>
                </p>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <footer class="entry-footer">
                <?php the_tags('<p class="post-tags">Etiquetas: ', ', ', '</p>'); ?>
            </footer>
        </article>

        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile;
else :
    echo '<p>' . __('No hay contenido disponible.', 'pokemon-theme') . '</p>';
endif;
?>

</main>

<?php get_footer(); ?>

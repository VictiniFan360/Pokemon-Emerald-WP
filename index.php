<?php get_header(); ?>

<main class="content-area">

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="frame-container">
                <h2><?php the_title(); ?></h2>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>

        <div class="pagination frame-container">
            <?php the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('« Anterior', 'pokemon-theme'),
                'next_text' => __('Siguiente »', 'pokemon-theme'),
            )); ?>
        </div>

    <?php else : ?>
        <article class="frame-container">
            <h2><?php _e('No hay contenido disponible.', 'pokemon-theme'); ?></h2>
        </article>
    <?php endif; ?>

</main>

<?php get_footer(); ?>



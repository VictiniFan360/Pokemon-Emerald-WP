<?php
get_header(); 
?>

<main id="main-content" class="content-area">

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <article <?php post_class('frame-container'); ?>>

                <h1 class="entry-title"><?php the_title(); ?></h1>

                <div class="entry-meta">
                    <?php echo get_the_date(); ?> | <?php the_author(); ?>
                </div>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

            </article>

        <?php endwhile; ?>
    <?php else : ?>

        <div class="frame-container" style="text-align:center;">
            <p><?php esc_html_e('No se encontró la entrada.', 'pokemon-theme'); ?></p>
        </div>

    <?php endif; ?>

</main>

<?php
get_footer();
?>
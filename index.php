<?php
get_header(); 
?>

<main id="main-content" class="content-area">

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <article <?php post_class('frame-container'); ?>>

                <h2 class="entry-title">
                    <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                </h2>

                <div class="entry-meta">
                    <?php echo get_the_date(); ?> | <?php the_author(); ?>
                </div>

                <div class="entry-content">
                    <?php
                    if (is_page()) {
                        the_content();
                    } else {
                        if (has_excerpt()) {
                            the_excerpt();
                        } else {
                            echo wp_trim_words(get_the_content(), 50, '...');
                        }
                    }
                    ?>
                </div>

                <?php if (!is_single() && !is_page()) : ?>
                    <p class="more-link">
                        <a href="<?php the_permalink(); ?>"><?php esc_html_e('Leer más', 'pokemon-theme'); ?></a>
                    </p>
                <?php endif; ?>

            </article>

        <?php endwhile; ?>

        <div class="pagination frame-container" style="text-align:center;">
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('« Anterior', 'pokemon-theme'),
                'next_text' => __('Siguiente »', 'pokemon-theme'),
            ));
            ?>
        </div>

    <?php else : ?>

        <div class="frame-container" style="text-align:center;">
            <p><?php esc_html_e('No se encontraron entradas.', 'pokemon-theme'); ?></p>
        </div>

    <?php endif; ?>

</main>

<?php
get_footer();
?>

<?php
get_header(); 
?>

<main id="main-content" class="content-area">

    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    $args = array(
        'posts_per_page' => 5,
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>

            <div class="frame-container">
                <article <?php post_class(); ?>>

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
            </div>

        <?php endwhile; ?>

        <?php
        if ($query->found_posts > 5) : ?>
            <div class="pagination frame-container" style="text-align:center;">
                <?php
                echo paginate_links(array(
                    'total'   => $query->max_num_pages,
                    'current' => $paged,
                    'mid_size'=> 2,
                    'prev_text'=> __('« Anterior', 'pokemon-theme'),
                    'next_text'=> __('Siguiente »', 'pokemon-theme'),
                ));
                ?>
            </div>
        <?php endif; ?>

    <?php else : ?>

        <div class="frame-container" style="text-align:center;">
            <p><?php esc_html_e('No se encontraron entradas.', 'pokemon-theme'); ?></p>
        </div>

    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

</main>

<?php
get_footer();
?>
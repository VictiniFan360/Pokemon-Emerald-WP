<?php get_header(); ?>

<main class="content-area">
    <h1 class="archive-title frame-container"><?php the_archive_title(); ?></h1>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="frame-container">
                <h2><?php the_title(); ?></h2>
                <div class="entry-content">
                    <?php the_excerpt(); ?>
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
            <h2><?php esc_html_e('No hay contenido disponible.', 'pokemon-theme'); ?></h2>
        </article>
    <?php endif; ?>
</main>

<aside class="sidebar">
    <div class="frame-container">
        <?php if (is_active_sidebar('right-sidebar')) : ?>
            <?php dynamic_sidebar('right-sidebar'); ?>
        <?php else: ?>
            <div class="sidebar-widget">
                <h4>Categorías</h4>
                <ul><?php wp_list_categories(array('title_li' => '')); ?></ul>
            </div>
            <div class="sidebar-widget">
                <h4>Archivos</h4>
                <ul><?php wp_get_archives(); ?></ul>
            </div>
        <?php endif; ?>
    </div>
</aside>

<?php get_footer(); ?>

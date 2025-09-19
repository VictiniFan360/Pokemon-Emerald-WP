<?php get_header(); ?>

<main class="content-area">

    <div class="main-content">
        <?php if (have_posts()) : ?>
            <!-- Encabezado de resultados -->
            <header class="archive-header frame-container">
                <h1><?php printf(__('Resultados de búsqueda para: %s', 'pokemon-theme'), '<span>' . get_search_query() . '</span>'); ?></h1>
            </header>

            <!-- Resultados -->
            <?php while (have_posts()) : the_post(); ?>
                <article class="frame-container">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <!-- Paginación -->
            <div class="pagination frame-container">
                <?php the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('« Anterior', 'pokemon-theme'),
                    'next_text' => __('Siguiente »', 'pokemon-theme'),
                )); ?>
            </div>

        <?php else : ?>
            <article class="frame-container">
                <h2><?php _e('No se encontraron resultados', 'pokemon-theme'); ?></h2>
            </article>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">

        <!-- Formulario de búsqueda enmarcado -->
        <div class="frame-container">
            <?php get_search_form(); ?>
        </div>

        <!-- Páginas -->
        <div class="frame-container">
            <h4>Páginas</h4>
            <ul>
                <?php wp_list_pages(array('title_li' => '')); ?>
            </ul>
        </div>

        <!-- Archivos -->
        <div class="frame-container">
            <h4>Archivos</h4>
            <ul>
                <?php wp_get_archives(); ?>
            </ul>
        </div>

        <!-- Categorías -->
        <div class="frame-container">
            <h4>Categorías</h4>
            <ul>
                <?php wp_list_categories(array('title_li' => '')); ?>
            </ul>
        </div>

        <!-- Meta -->
        <div class="frame-container">
            <h4>Meta</h4>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
            </ul>
        </div>

    </aside>
</main>

<?php get_footer(); ?>
<?php get_header(); ?>

<main class="content-area">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article class="frame-container">
            <h2><?php the_title(); ?></h2>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; endif; ?>
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
